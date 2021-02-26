<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id',auth()->id())->paginate(5);
        return view('member.Orders', compact('orders'));
     
    }

    public function show($id)
    {
        $order = Order::where('user_id',auth()->id())->where('id',$id)->firstOrFail();
        return view('member.Order', compact('order'));
    }

  
}

