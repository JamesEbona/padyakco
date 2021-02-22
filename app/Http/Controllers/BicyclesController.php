<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;


class BicyclesController extends Controller
{

    public function index()
    {
        $products = Product::where('category_id', 1)->where('status','active')->paginate(12);
        $categories = Category::all();
        $subcategories = SubCategory::where('category_id', 1)->get();
        // $brands = Product::select('brand')->where('category_id', 1)->get();
        $brands = Product::where('category_id', 1)->distinct()->get('brand');
        return view('home.bicycles', compact('products','categories','subcategories','brands'));
    }

    public function fetch_bicycles_data(Request $request)
    {
     if($request->ajax())
     {
        // if(request('subcategory_id') != NULL){  
        $subcategory_filter = $request->get('subcategory_id');
        $brand_filter = $request->get('brand');
        $price_filter = $request->get('price');
        
        
        $products = Product::whereIn('subcategory_id', $subcategory_filter)->whereIn('brand', $brand_filter)->where('price', '<=',  $price_filter)->where('status','active')->paginate(12); 
       
         
        return view('home.bicycles_data', compact('products'))->render();
     }
    }

    public function show($id){
        $bicycle = Product::findOrFail($id);
        $related_products = Product::where('category_id', 1)->where('status','active')->inRandomOrder()->limit(3)->get();
        $cart_item_qty = 0;

        if (Auth::user()) {
            $cartId = Cart::where('user_id', Auth::id())->first()->id;
            if (CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->exists()) {
                $cart_item_qty = CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->first()->quantity;
            }
        }

        return view('home.bicycle', compact('bicycle','related_products','cart_item_qty'));

    }
}
