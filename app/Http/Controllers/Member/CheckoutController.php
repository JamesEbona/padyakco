<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Session;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','member','active']);
    }

    public function address(Request $request)
    {
        $cartId = Cart::where('user_id', Auth::id())->first()->id;

        if ($request->session()->has('cart')) {
            CartItem::where('cart_id',$cartId)->delete();
            $oldCart = Session::get('cart'); 
            $sessionCart = $oldCart->items;

            foreach ($sessionCart as $sessionCartItem) {
                   $cartItem = new CartItem;
                   $cartItem->cart_id = $cartId;
                   $cartItem->product_id = $sessionCartItem['item']['id'];
                   $cartItem->quantity = $sessionCartItem['qty'];
                   $cartItem->save();
            }  
            
            $cart = Cart::findOrFail($cartId);
            $cart->total_quantity = $oldCart->totalQty;
            $cart->save();
            
            session::put('cartTotal',$oldCart->totalQty);

            Session::forget('cart');
        }
     
        return view('member.CheckoutAddress');
    }

    public function saveAddress(Request $request){
        $request->validate([
            'address1' => 'required|string|max:100',
            'address2' => 'string|nullable|max:100',
            'postal_code' => 'required|regex:/\d{4}/',
            'city' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'province' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
            'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
            
        ]);

        $data = array(
            'address1' => request('address1'),
            'address2' => request('address2'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'province' => request('province'),
            'phone_number' => request('phone_number'),
        );

        $UserID = auth()->user()->id;
        Address::where('user_id', $UserID)->update($data);
         
        // $cartId = Cart::where('user_id', Auth::id())->first()->id;
        // $cart =  Cart::where('id',$cartId)->first();
        // $cartItems =  CartItem::where('cart_id',$cartId)->get();
        // $cartItemNo = 0;
        // $cartItemTotal = 0;
        return redirect()->route('checkoutReview');
    }

    public function review(){
        $cartId = Cart::where('user_id', Auth::id())->first()->id;
        $cart =  Cart::where('id',$cartId)->first();
        $cartItems =  CartItem::where('cart_id',$cartId)->get();
        $cartItemNo = 0;
        $cartItemTotal = 0;
        $cartDeliveryTotal = 0;

        return view('member.CheckoutReview', compact('cart','cartItems','cartItemNo', 'cartItemTotal', 'cartDeliveryTotal'));
    }

   
}
