@extends('layouts.member.account')

@section('title')
My Orders
@endsection

@section('content')
<div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
			 <h1 class="mb-4">My Orders:</h1>
			 @foreach($orders as $order)
			 <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-6">
				    <a href="{{route('orderView', ['id' => $order->id])}}" class="account-links"><h2>Order # {{$order->id}}</h2></a>
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
					<div class="row">
					<div class="col-md-12">
				    <p>{{ date('F j, Y', strtotime(auth()->user()->created_at))}} | ₱{{number_format($order->grand_total)}} | {{$order->quantity_total}}
					@if($order->quantity_total == 1) item @else items @endif
					</p>
					</div>
					</div>
					<div class="row">
					
					@foreach($order->orderitems as $orderItem)
					<div class="col-md-3">
					<a href="/bicycles/show/{{$orderItem->product->id}}">
					<img src="/storage/{{$orderItem->product->image1}}" class="img-responsive mt-3" style=" max-width: 500px;
                     height: 100px;" alt=""/>
					</a>
					</div>
					@endforeach
					
					</div>
				  </div>
			 </div>
			 @endforeach
			 
		   
			 <dic class="row">&nbsp;</div>
			 <div class="row text-center mt-5 mb-5">
			 {{ $orders->links() }}
             </div>

		
			
		 </div>
	
		
		 
	
	 </div>
				</div>



@endsection