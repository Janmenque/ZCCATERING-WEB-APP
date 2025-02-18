<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function notice()
    {
        return view('notice');
    }
    public function index()
    {
        $slide_list = Slide::all();
        $category_list = Category::all();
        $product_list = Product::all();
        return view('welcome', ['slide_list' => $slide_list, 'category_list' => $category_list, 'product_list' => $product_list]);
    }

    public function filter(Request $request, $route)
    {
        $ft = '';

        if ($request->input('search') != '') {
            $ft = $ft . "search__" . $request->input('search') . '--';
        }
        if ($request->input('category') != '') {
            $ft = $ft . "category__" . $request->input('category') . '--';
        }
        if ($request->input('id') != '') {
            $ft = $ft . "id__" . $request->input('id') . '--';
        }
        if ($request->input('status') != '') {
            $ft = $ft . "status__" . $request->input('status') . '--';
        }
        if ($request->input('date') != '') {
            $ft = $ft . "date__" . $request->input('date') . '--';
        }
        if ($request->input('drange') != '') {
            $ft = $ft . "drange__" . $request->input('drange') . '--';
        }

        return redirect()->route($route, ['xfilter' => $ft]);
    }
}
