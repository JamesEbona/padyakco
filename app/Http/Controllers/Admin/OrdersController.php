<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Courier;
use App\Models\Product;
use App\Models\OrderItem;
use App\Events\OrderShippedEvent;
use App\Events\OrderDeliveredEvent;
use App\Events\OrderCancelledEvent;
use App\Models\ProductCategoryReport;
use App\Models\StoreDaySales;
use App\Models\StoreMonthSales;
use App\Models\StoreYearSales;
class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','admin','active']);
    }

    public function index()
    {
        $orders = Order::all();
        $couriers = Courier::all();
        return view('admin.Orders', compact('orders','couriers'));
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
        'status' => 'required|string|max:100',
        'courier_id' => 'nullable|max:100',
        'tracking_number' => 'nullable|max:100'
     ]);
  
      if ($validator->fails()){
        return response()->json(['errors'=>$validator->errors()->all()]);
      }
    
      $status = request('status');
      $order = Order::findOrFail(request('editId'));
      $current_status = $order->status;
      $order->status = $status;
      if(request('courier_id') != NULL || request('courier_id') != ''){
      $order->courier_id = request('courier_id');
      }
      if(request('tracking_number') != NULL){
      $order->tracking_number = request('tracking_number');
      }
      $order->save();

      if($current_status != $status){

      if($status == "in-transit"){
        event(new OrderShippedEvent($order));
      }
      else if($status == "delivered"){
        event(new OrderDeliveredEvent($order));  
      }
      else if($status == "cancelled"){
        event(new OrderCancelledEvent($order)); 
        $orderItems =  OrderItem::where('order_id',$order->id)->get();
        foreach ($orderItems as $orderItem) {
                $product = Product::where('id',$orderItem->product_id)->first();
                $productCategoryReport = ProductCategoryReport::where('title', '=', $product->category->title)->first();
                $productCategoryReport->number -= $orderItem->quantity;
                $productCategoryReport->save();
        }

        $storeDaySale = StoreDaySales::where('day',date_format($order->created_at, 'd'))->first();
        $storeDaySale->profit -= $order->grand_total;
        $storeDaySale->save();

        $storeMonthSale = StoreMonthSales::where('month',date_format($order->created_at, 'F'))->first();
        $storeMonthSale->profit -= $order->grand_total;
        $storeMonthSale->save();

        $storeYearSale = StoreYearSales::where('year',date_format($order->created_at, 'Y'))->first();
        $storeYearSale->profit -= $order->grand_total;
        $storeYearSale->save();
      }
    }
    
      return redirect("/admin/orders");
    
    }

    public function show($id)
    {
        $order = Order::where('id',$id)->firstOrFail();
        return view('admin.Order', compact('order'));
    }

}

