<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index($xfilter = '--')
    {
        $filter = filter($xfilter);
        $and = $filter['and'];
        $vfilter = $filter['vfilter'];

        $category_list = Category::orderBy('name')->get();

        $list = Product::whereRaw("id > 0 $and")->orderBy('created_at', 'desc')->paginate(20);
        return view('product.index', ['vfilter' => $vfilter, 'list' => $list, 'category_list' => $category_list]);
    }

    public function create($id = '--')
    {
        if ($id != '--') {
            $info = Product::find($id);
        }
        $category_list = Category::orderBy('name')->get();
        return view('product.create', ['info' => @$info, 'id' => $id, 'category_list' => $category_list]);
    }

    public function store(Request $request)
    {
        $id = $request->input('product_id');
        $request->validate([
            'pix' => 'image|nullable'
        ]);

        if ($id == '--') {
            $table = new Product();
        } else {
            $table = Product::find($id);
        }
        $table->name = $request->input('name');
        $table->description = $request->input('description');
        if ($request->hasFile('pix')) {
            if ($id != '--') {
                delete_product_pix($table->pix);
            }
            $pix = $request->file('pix')->store('', 'product');

            $manager = new ImageManager(
                new Driver()
            );
            // open an image file
            $img = $manager->read(public_path('uploads/product/' . $pix));
            $img->resize(200, 200);
            $img->save();

            $table->pix = $pix;
        }
        $table->category_id = $request->input('category');
        $table->price = $request->input('price');
        $table->save();

        return redirect()->route('product')->with('status', 'Product saved');
    }

    public function delete($id)
    {
        $table = Product::find($id);
        delete_product_pix($table->pix);
        $table->delete();

        return redirect()->route('product')->with('status', 'Product deleted');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        return view('product.cart');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        $product = Product::findOrFail($id);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->pix
            ];
        }
          
        session()->put('cart', $cart);
        echo 'success';
        //return redirect()->back()->with('status', 'Product added to cart successfully!');
    }

    public function refresh_cart()
    {
        return view('product.refresh_cart');
    }
    public function refresh_cart_pos()
    {
        return view('product.refresh_cart_pos');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('status', 'Cart updated successfully');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('status', 'Product removed successfully');
        }
    }
}
