@section('title')
Padyak.Co - Order placed
@endsection

@extends('layouts.member.general')
@section('content')

<div class="cart" >
	 <div class="container style="min-height:160vh"">
     <div class="cart-top">
			<a>CART / </a>
			<a>DELIVERY /</a>
			<a>REVIEW & PAY</a> /
			<a style="text-decoration: underline;">ORDER PLACED</a>
		 </div>	
			
		 <div class="col-md-7 mt-5">
         <h3>Your store order has been received.</h3>
         <h2>Order Number: {{$order->id}}</h2>
         <p>Hello {{auth()->user()->first_name}},</p>
         <p>We have received your order and will send you an e-receipt to your email shortly.</p>
         <p>You can track your order <a href="{{route('orders')}}">here.</a></p>
			 </div>
             <div class="col-md-5 mt-5" style="border-left: 1px solid; padding-left: 16px; ">
		   <h2>Check out these products:</h2>
           @foreach($related_products as $related_product)
           <div class="product">
					 <div class="product-desc">
						  <div class="product-img product-img2">
							 <img src="/storage/{{$related_product->image1}}" class="img-responsive " alt=""/>
						 </div>
						 <div class="prod1-desc">
								<h2><a class="product_link" href="/bicycles/show/{{$related_product->id}}">{{$related_product->brand}} {{$related_product->title}}</a></h2>
																	
						 </div>
						 <div class="clearfix"></div>
					 </div>
					 <div class="product_price">
														
							<a class="button1 ml-2" href="/bicycles/show/{{$related_product->id}}"><span>View</span></a>
					 </div>
						<div class="clearfix"></div>
			 </div>
           @endforeach
           </div>
		
			
		 </div>
		  
	
	 </div>
</div>
@endsection