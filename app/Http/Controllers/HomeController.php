<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('category_id', 1)->where('status','active')->inRandomOrder()->limit(6)->get();
        return view('home.index', compact('products'));
    }

}
