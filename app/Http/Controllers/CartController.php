<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartSession;
use Session;


class CartController extends Controller
{

    public function index()
    {
        if (!Session::has('cart')) {
            return view('home.cart');
        }
        $oldCart = Session::get('cart');
        $cart = new CartSession($oldCart);
        return view('home.cart', ['products' => $cart->items, 'totalPrice' => number_format($cart->totalPrice, 2, '.', ''), 'cartItemNo' => 0]);
    }

    public function store(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->add($product, $product->id);

        Session::put('cart', $cart);

        return redirect()->back()->with('message', 'Product added to cart.');   

        // return redirect()->route('bicycles');
    }

    public function addByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->addByOne($id);

        Session::put('cart', $cart);
     
        return redirect()->route('cart');
    }

    public function reduceByOne($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('cart');
    }

    public function removeItem($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new CartSession($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
            return response()->json([
                'cart' => 'empty']);
            
        }
    }

}

