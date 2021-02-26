<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;


class CartController extends Controller
{

    public function index()
    {
     
        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        $cart =  Cart::where('id',$cartId)->first();
        $cartItems =  CartItem::where('cart_id',$cartId)->get();
        $cartItemNo = 0;
        $cartItemTotal = 0;
        return view('member.Cart', compact('cartItems','cart','cartItemNo','cartItemTotal'));
    }

    public function store($id)
    {
        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        if (CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->exists()) {
            $cartItemId = CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->first()->id;
            $cart_item = CartItem::findOrFail($cartItemId);
            $cart_item->quantity = ++$cart_item->quantity;
            $cart_item->save();
        }
        else{
            $cart_item = new CartItem;
            $cart_item->cart_id = $cartId;
            $cart_item->product_id = $id;
            $cart_item->quantity = 1;
            $cart_item->save();
        }

        $cart = Cart::findOrFail($cartId);
        $cart_total_quantity = ++$cart->total_quantity;
        $cart->total_quantity = $cart_total_quantity;
        $cart->save();

        session()->put('cartTotal',$cart_total_quantity);

        return redirect()->back()->with('message', 'Product added to cart.');   
    }

    public function addByOne($id)
    {
        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        if (CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->exists()) {
            $cartItemId = CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->first()->id;
            $cart_item = CartItem::findOrFail($cartItemId);
            $cart_item->quantity = ++$cart_item->quantity;
            $cart_item->save();
        }

        $cart = Cart::findOrFail($cartId);
        $cart_total_quantity = ++$cart->total_quantity;
        $cart->total_quantity = $cart_total_quantity;
        $cart->save();

        session()->put('cartTotal',$cart_total_quantity);
     
        return redirect()->route('memberCart');
    }

    public function reduceByOne($id) {

        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        if (CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->exists()) {
            $cartItemId = CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->first()->id;
            $cart_item = CartItem::findOrFail($cartItemId);
            $cart_item->quantity = --$cart_item->quantity;
            if($cart_item->quantity > 0){
            $cart_item->save();
            }
            else{
            $cart_item->delete(); 
            }

            $cart = Cart::findOrFail($cartId);
            $cart_total_quantity = --$cart->total_quantity;
            $cart->total_quantity = $cart_total_quantity;
            $cart->save();
            session()->put('cartTotal', $cart_total_quantity);
        }

        return redirect()->route('memberCart');
    }

    public function removeItem($id) {

        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        if (CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->exists()) {
            $cartItemId = CartItem::where('cart_id', '=', $cartId)->where('product_id', '=', $id)->first()->id;
            $cart_item = CartItem::findOrFail($cartItemId);
            $cart_item->delete(); 
            

            $cart = Cart::findOrFail($cartId);
            $cart_total_quantity = $cart->total_quantity;
            $cart->total_quantity = --$cart_total_quantity;
            $cart->save();
            session()->put('cartTotal', $cart_total_quantity);
            
            if($cart->total_quantity <= 0){
                return response()->json([
                    'cart' => 'empty']);

            }
          
        }


    }

}

