@section('title')
Padyak.Co Admin - View Order
@endsection

@extends('layouts.admin.admin')


@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Tracker</h1>
    </div>

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="d-inline">Order # {{$order->id}}</h4>
                            @if($order->status =="paid")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-primary">{{$order->status}}</span></h4>
                            @elseif($order->status =="in-transit")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-info">{{$order->status}}</span></h4>
                            @elseif($order->status =="delivered")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-success">{{$order->status}}</span></h4>
                            @elseif($order->status =="cancelled")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-danger">{{$order->status}}</span></h4>
                            @endif       
                        </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col-md-12">
                            <p class="mt-3">{{ date('F j, Y', strtotime(auth()->user()->created_at))}} | ₱{{number_format($order->grand_total)}} | {{$order->quantity_total}}
					           @if($order->quantity_total == 1) item @else items @endif</p>
                        </div>
                    </div>
                    @foreach($order->orderitems as $orderItem)
                        <div class="row mb-3 border-bottom" style="padding-top: 12px;">
					        <div class="col-md-3">
					            <img src="/storage/{{$orderItem->product->image1}}" class="img-fluid mt-3"  alt="Product Image"/>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <h4 class="font-italic">{{$orderItem->product->title}}</h4>
                                </div>
                                <div class="row">
                                    <p class="m-0 p-0">Brand: {{$orderItem->product->brand}}</p>
                                </div>
                                <div class="row">
                                    <p class="m-0 p-0">Type: {{$orderItem->product->subcategory->title}}</p>
                                </div>
                                <div class="row">
                                    <p class="m-0 p-0">Type: {{$orderItem->product->subcategory->title}}</p>
                                </div>
                                <div class="row" style="border-bottom: 1px solid; padding-bottom: 12px;">
                                    <p class="m-0 p-0">Quantity: {{$orderItem->quantity}}</p>
                                </div>
                                <div class="row pt-3">
                                     <div class="col-md-4">
                                        <h5>₱{{number_format($orderItem->price,2)}}</h5>
                                     </div>
                                     <div class="col-md-4 text-center">
                                        <h5>X {{$orderItem->quantity}}</h5>
                                     </div>
                                     <div class="col-md-4 text-right">
                                        <h5>₱{{number_format($orderItem->price * $orderItem->quantity,2)}}</h5>
                                     </div>
                                </div>
                            </div>
					    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body"> 
                            <h4 class="mb-2">Member Details:</h4>
                                <div class="row">       
                                     <div class="col-xl-2 col-lg-2 d-flex">     
                                         <a href="/storage/{{$order->user->image}}" target="_blank">   
                                             <img src="/storage/{{$order->user->image}}" alt="" class="rounded-circle w-100" style="max-width: 100px;">
                                         </a>
                                     </div>     
                                     <div class="col-xl-10 col-lg-10">
                                          <p class="m-0 p-0">{{$order->user->first_name}} {{$order->user->last_name}}</p>
                                          <p class="m-0 p-0">{{$order->user->email}}</p>
                                          @if($order->user->status =="active")
                                             <p><span class="badge badge-pill badge-success">{{$order->user->status}}</span></p>
                                          @else
                                             <p><span class="badge badge-pill badge-danger">{{$order->user->status}}</span></p>
                                          @endif
                                    </div>
                               </div>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body"> 
                            <h4 class="mb-2">Delivery Details:</h4>
                            <p class="m-0 p-0">{{$order->first_name}} {{$order->last_name}}</p>
                            <p class="m-0 p-0">{{$order->address1}}</p>
                            <p class="m-0 p-0">{{$order->address2}}</p>
                            <p class="m-0 p-0">{{$order->city}}, {{$order->postal_code}}</p>
                            <p class="m-0 p-0">{{$order->province}}</p>
                            <p class="m-0 p-0">{{$order->phone_number}}</p>           
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Order Summary:</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                     <p>Product Total ({{$order->quantity_total}})</p>
                                </div>
                                <div class="col-md-6 text-right">
                                     <p>₱{{number_format($order->sub_total,2)}}</p>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 2px solid; padding-bottom: 12px;">
                                <div class="col-md-8">
                                     <p>Delivery Total ({{$order->province}})</p>
                                </div>
                                <div class="col-md-4 text-right">
                                     <p>₱{{number_format($order->shipping,2)}}</p>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 12px;">
                                <div class="col-md-6">
                                    <p>Payment Total</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <p>₱{{number_format($order->grand_total,2)}}</p>
                                </div>
                            </div>             
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>











  
  <!-- <div class="col-xl-6 col-lg-6">
    <div class="card shadow mb-4">
      <div class="card-body">           
      </div>
    </div>
  </div> -->

  

@endsection