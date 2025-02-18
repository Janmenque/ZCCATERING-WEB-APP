<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $list = Category::orderBy('name')->get();
        return view('category.index', ['list' => $list]);
    }

    public function store(Request $request)
    {
        if($request->has('category_id'))
        {
            $table = Category::find($request->input('category_id'));
        }
        else
        {
            $table = new Category();
        }
        $table->name = $request->input('name');
        $table->save();

        return redirect()->back()->with('status', 'Category saved');
    }

    public function delete($id)
    {
        $table = Category::find($id);
        if($table->product->count() > 0)
        {
            foreach($table->product as $item)
            {
                delete_product_pix($item->pix);
            }
        }
        $table->delete();

        return redirect()->back()->with('status', 'Category deleted');
    }
}
