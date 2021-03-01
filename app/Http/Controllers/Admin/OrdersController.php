<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderShippedEvent;
use App\Events\OrderDeliveredEvent;
use App\Events\OrderCancelledEvent;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $orders = Order::all();
        return view('admin.Orders', compact('orders'));
    }

    public function modify(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'address1' => 'required|string|max:100',
        'address2' => 'string|nullable|max:100',
        'postal_code' => 'required|regex:/\d{4}/',
        'city' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
        'province' => 'required|string|regex:/^[a-zA-Z ]*$/|max:20|',
        'phone_number' => array('required','regex:/^(09|\+639)\d{9}$/'),
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }

  
     $data = array(
            'address1' => request('address1'),
            'address2' => request('address2'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'province' => request('province'),
            'phone_number' => request('phone_number'),
        );

    
    Order::where('id', request('editId'))->update($data);
     
    return redirect("/admin/orders");
    
    }

    public function updateStatus(Request $request)
    {

      $validator = \Validator::make($request->all(), [
        'status' => 'required|string|max:100'
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
    
      $status = request('status');
      $order = Order::findOrFail(request('editId'));
      $order->status = $status;
      $order->save();

      if($status == "in-transit"){
        event(new OrderShippedEvent($order));
      }
      else if($status == "delivered"){
        event(new OrderDeliveredEvent($order));  
      }
      else if($status == "cancelled"){
        event(new OrderCancelledEvent($order)); 
      }
    
      return redirect("/admin/orders");
    
    }

    public function show($id)
    {
        $order = Order::where('id',$id)->firstOrFail();
        return view('admin.Order', compact('order'));
    }

}

