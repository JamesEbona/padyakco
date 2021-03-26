<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductCategoryReport;
use App\Models\StoreDaySales;
use App\Models\StoreMonthSales;
use App\Models\StoreYearSales;
use Illuminate\Support\Facades\Auth;
use App\Events\NewOrderEvent;
use App\Models\Coupon;
// use App\Mail\OrderReceipt;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Notification;
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
        $product_check = '';
        $discount = 0;
        $discount_code = '';
        if(session()->has('coupon')){
        $discount = session()->get('coupon')['discount']; 
        $discount_code = session()->get('coupon')['name'];
        }

        if($cart->total_quantity == 0){
            return redirect()->route('memberCart');
        }
        else if(url()->previous() != 'http://padyakco.test/member/checkout/address' && url()->previous() != 'http://padyakco.test/member/checkout/storeCoupon' && url()->previous() != 'http://padyakco.test/member/checkout/destroyCoupon' && url()->previous() != 'http://padyakco.test/member/checkout/review'){
            return redirect()->route('memberCart');
        }
        else{
            foreach ($cartItems as $cartItem){
           
                $product = Product::where('id',$cartItem->product_id)->where('status','active')->first();
                //add wher status / where deleted at
                $oldQty = $cartItem->quantity;
                if (isset($product)) {
                    if($product->quantity == 0){
                    
                        $response = [ 'success' => 'false'];
                        $cartItem->delete();
                        $cart->total_quantity -= $oldQty;
                        $cart->save();
                        session::put('cartTotal',$cart->total_quantity);
                        $product_check = "out of stock";
                    }
                    elseif($product->quantity < $cartItem->quantity){
                        $cartItem->quantity = $product->quantity;
                        $cartItem->save();
                        $cart->total_quantity -= $oldQty - $product->quantity;
                        $cart->save();
                        session::put('cartTotal',$cart->total_quantity);
                        $product_check = "out of stock";
                    }
                }
                else{
                    $cartItem->delete();
                    $cart->total_quantity -= $oldQty;
                    $cart->save();
                    session::put('cartTotal',$cart->total_quantity);
                    $product_check = "not found";
                }
            }
            
            if($product_check == "out of stock"){
                return redirect()->route('memberCart')->with('cart_stock', 'Some items were removed from your cart becuase it is out of stock.');
            }
            else if($product_check == "not found"){
                return redirect()->route('memberCart')->with('cart_stock', 'Some items were removed from your cart because the product is not found.');
            }
            else{
            return view('member.CheckoutReview', compact('cart','cartItems','cartItemNo', 'cartItemTotal', 'cartDeliveryTotal', 'discount', 'discount_code'));
            }
        }
    }

    public function check(Request $request){
        $cart = Cart::where('user_id', Auth::id())->first();
        $cartItems =  CartItem::where('cart_id',$cart->id)->get();

        // $response['success'] = true;

        foreach ($cartItems as $cartItem){
            //delete cart item
            //update total quantity of cart
            $product = Product::where('id',$cartItem->product_id)->first();
            $oldQty = $cartItem->quantity;
            if($product->quantity == 0){
                // $response['success'] = false;
                $response = [ 'success' => 'false'];
                $cartItem->delete();
                $cart->total_quantity -= $oldQty;
                $cart->save();
                session::put('cartTotal',$cart->total_quantity);
                // session::put('message', 'Some items in your cart were removed because it is out of stock.');
            }
            elseif($product->quantity < $cartItem->quantity){
                // $response['success'] = false;
                // $response = [ 'success' => 'false'];
                $cartItem->quantity = $product->quantity;
                $cartItem->save();
                $cart->total_quantity -= $oldQty - $product->quantity;
                $cart->save();
                session::put('cartTotal',$cart->total_quantity);
                //minus quantity cart to meet min requirement
                // session::put('message', 'Some items in your cart were removed because it is out of stock.');
                
            }
            // else{
            //     $product->quantity -= $oldQty;
            //     $product->save();
            // }
        }

        // header('Content-type: application/json');
        // echo json_encode($response);
        
    }

    public function order(Request $request){
        //get data from ajax
        //store order
       
        $cart = Cart::where('user_id', Auth::id())->firstOrFail();
       
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->quantity_total = $cart->total_quantity; 
        $order->sub_total =  request('item_total');
        $order->grand_total =  request('amount');
        $order->shipping =  request('delivery_total');
        $order->first_name = auth()->user()->first_name;
        $order->last_name = auth()->user()->last_name;
        $order->email = auth()->user()->email;
        $order->address1 = auth()->user()->address->address1;
        $order->address2 = auth()->user()->address->address2;
        $order->city = auth()->user()->address->city;
        $order->province = auth()->user()->address->province;
        $order->postal_code = auth()->user()->address->postal_code;
        $order->phone_number = auth()->user()->address->phone_number;
        $order->status = 'paid';
        $discount = request('discount');
        if(isset($discount)){
            $order->discount =  request('discount');
            $order->discount_code =  request('discount_code');
            session()->forget('coupon');
        }
        $order->save();

        $orderDay = date_format($order->created_at, 'd');
        if($orderDay == 01){
            StoreDaySales::query()->update(['after' => 1]);
        }
        $storeDaySales = StoreDaySales::firstOrNew(['day' =>  $orderDay]);
        $storeDaySales->profit += $order->grand_total;
        $storeDaySales->after = 0;
        $storeDaySales->save();

        $orderMonth = date_format($order->created_at, 'F');
        if($orderMonth == "January"){
            StoreMonthSales::query()->update(['after' => 1]);
        }
        $storeMonthSales = StoreMonthSales::firstOrNew(['month' =>  $orderMonth]);
        $storeMonthSales->profit += $order->grand_total;
        $storeMonthSales->after = 0;
        $storeMonthSales->save();

        $orderYear = date_format($order->created_at, 'Y');
        $storeYearSales = StoreYearSales::firstOrNew(['year' =>  $orderYear]);
        $storeYearSales->profit += $order->grand_total;
        $storeYearSales->save();

        //store order items
       
        $cartItems =  CartItem::where('cart_id',$cart->id)->get();
        foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->product->price;
                $orderItem->shipping_fee = $cartItem->product->delivery_fee;
                $orderItem->provincial_shipping_fee = $cartItem->product->provincial_delivery_fee;
                $orderItem->save();

                //minus product quantity
                $product = Product::where('id',$orderItem->product_id)->firstOrFail();
                $product->quantity -= $orderItem->quantity;
                $productCategoryReport = ProductCategoryReport::firstOrNew(['title' => $product->category->title]);
                $productCategoryReport->number += $orderItem->quantity;
                $productCategoryReport->save();
                $product->save(); 
        }

         //delete cart items
        CartItem::where('cart_id',$cart->id)->delete();

        //delete cart order cart total
        $cart->total_quantity = 0;
        $cart->save();

        //forget cart order cart total
        Session::forget('cartTotal');

        //email receipt
        event(new NewOrderEvent($order));

        //redirect to order placed view
        return redirect()->route('orderPlaced');

        // header('Content-type: application/json');
        // $response = $order->id; 
        // echo json_encode($response);
        // return redirect('member/checkout/orderPlaced/'.$order->id);
    }

    public function orderPlaced(){
        $order =  Order::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->firstOrFail();
        $related_products = Product::where('status','active')->inRandomOrder()->limit(4)->get();
        return view('member.orderPlaced', compact('order','related_products'));
    }

    public function storeCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->where('status', 'active')->where('category', 'Store')->first();

        if (!$coupon) {
            return back()->withErrors('Invalid coupon code. Please try again.');
        }

        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $coupon->discount($request->cartTotal)
        ]);

        return redirect()->route('checkoutReview')->with('message', 'Coupon has been applied!');
    }

    public function destroyCoupon()
    {
        session()->forget('coupon');

        return redirect()->route('checkoutReview')->with('message', 'Coupon has been removed!');
    }
  
}
