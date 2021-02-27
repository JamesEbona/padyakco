@extends('layouts.member.account')

@section('title')
My Order
@endsection

@section('content')
<div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
			 <h1 class="mb-4"> <a href="{{route('orders')}}" class="account-links">Orders</a> / Order Tracker</h1>
			 <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-6">
				   <h2>Order # {{$order->id}}</h2>
					</div>
					<div class="col-md-6">
					@if($order->status =="paid")
					<h2 class="text-right"><span class="label label-primary">{{$order->status}}</span></h2>
					@elseif($order->status =="in-transit")
					<h2 class="text-right"><span class="label label-info">{{$order->status}}</span></h2>
					@elseif($order->status =="in-delivered")
					<h2 class="text-right"><span class="label label-success">{{$order->status}}</span></h2>
					@elseif($order->status =="in-cancelled")
					<h2 class="text-right"><span class="label label-danger">{{$order->status}}</span></h2>
					@endif
					</div>
					</div>
					<div class="row mb-3">
					<div class="col-md-12">
				    <p>{{ date('F j, Y', strtotime(auth()->user()->created_at))}} | ₱{{number_format($order->grand_total)}} | {{$order->quantity_total}}
					@if($order->quantity_total == 1) item @else items @endif
					</p>
					</div>
					</div>
                    @foreach($order->orderitems as $orderItem)
                    <div class="row mb-3" style="border-top: 1px solid; padding-top: 12px;">
					<div class="col-md-3">
					<a href="/bicycles/show/{{$orderItem->product->id}}">
					<img src="/storage/{{$orderItem->product->image1}}" class="img-responsive mt-3" style=" max-width: 180px;
                     height: 150px;" alt=""/>
					</a>
                    </div>
                    <div class="col-md-9">
                    <div class="row">
                    <h3>{{$orderItem->product->title}}<h3>
                    </div>
                    <div class="row">
                    <p>Brand: {{$orderItem->product->brand}}</p>
                    </div>
                    <div class="row">
                    <p>Type: {{$orderItem->product->subcategory->title}}</p>
                    </div>
                    <div class="row">
                    <p>Type: {{$orderItem->product->subcategory->title}}</p>
                    </div>
                    <div class="row" style="border-bottom: 1px solid; padding-bottom: 12px;">
                    <p>Quantity: {{$orderItem->quantity}}</p>
                    </div>
                    <div class="row pt-3">
                    <div class="col-md-4"><h2>₱{{number_format($orderItem->price,2)}}</h2></div>
                    <div class="col-md-4 text-center"><h2>X {{$orderItem->quantity}}</h2></div>
                    <div class="col-md-4 text-right">
                    <h2>₱{{number_format($orderItem->price * $orderItem->quantity,2)}}</h2>
                    </div>
                    </div>
                    </div>
					</div>
					@endforeach
				
				  </div>
			 </div>  
             <div class="row">
             <div class="col-md-6">
             <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-12">
				    <h2>Delivery Details:</h2>
					</div>
					</div>
					<div class="row">
					<div class="col-md-12">
				    <p>{{$order->first_name}} {{$order->last_name}} </p>
					</div>
					</div>
					<div class="row">
					<div class="col-md-12">
                    <p>{{$order->address1}}</p>
					</div>
					</div>
                    <div class="row">
					<div class="col-md-12">
                    <p>{{$order->address2}}</p>
					</div>
					</div>
                    <div class="row">
					<div class="col-md-12">
                    <p>{{$order->city}}, {{$order->postal_code}}</p>
					</div>
					</div>
                    <div class="row">
					<div class="col-md-12">
                    <p>{{$order->province}}</p>
					</div>
					</div>
                    <div class="row">
					<div class="col-md-12">
                    <p>{{$order->phone_number}}</p>
					</div>
					</div>
                    
				  </div>
			 </div>  
             </div>
             <div class="col-md-6">
             <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-12">
				    <h2>Order Summary:</h2>
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
			 <dic class="row">&nbsp;</div>
		

		
			
		 </div>
	
		
		 
	
	 </div>
				</div>



@endsection