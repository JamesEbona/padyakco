@section('title')
Padyak.Co - Checkout
@endsection

@extends('layouts.member.general')
@section('content')
<div class="cart" >
	 <div class="container style="min-height:160vh"">
     <div class="cart-top">
			<a href="{{ route('memberCart') }}">CART / </a>
			<a href="{{ route('checkoutAddress') }}">DELIVERY /</a>
			<a style="text-decoration: underline;" href="{{ route('checkoutReview') }}">REVIEW & PAY</a> /
			<a style="color: grey;">ORDER PLACED</a>
		 </div>	
			
		 <div class="col-md-9 cart-items">
			 <h2>Order Summary ({{ $cart->total_quantity ?? '0' }})</h2>
			  @foreach($cartItems as $cartItem)
			  <?php
               $cartItemNo++;
			   $cartItemTotal += $cartItem->product->price * $cartItem->quantity;
			  ?>
			 <div class="cart-header{{$cartItemNo}} cartHead">
			
				 <div class="cart-sec">
						<div class="cart-item cyc">
							 <img src="/storage/{{$cartItem->product->image1}}"/>
						</div>
					   <div class="cart-item-info">
							 <h3>{{$cartItem->product->brand}} {{$cartItem->product->title}}<span>Model No: {{$cartItem->product->id}}</span></h3>
							 <h4><span>₱ </span>{{number_format($cartItem->product->price, 2, '.', '')}}</h4>
						     <h4>X</h4>
							 <p class="qty">Quantity :</p>
						     <strong>{{$cartItem->quantity}}</strong>
                             <h4 class= "ml-5"><span>₱ </span>{{number_format($cartItem->product->price * $cartItem->quantity, 2, '.', '')}}</h4>
							
							 <!-- <input min="1" type="number" id="quantity" name="quantity" value="1" class="form-control input-small"> -->
					   </div>
					   <div class="clearfix"></div>
						<div class="delivery">
                            @if(Auth::user()->address->province == 'Metro Manila')
                             <?php
                               $cartDeliveryTotal += $cartItem->product->delivery_fee * $cartItem->quantity;
                             ?>
						     <p>Delivery fee: ₱ {{number_format($cartItem->product->delivery_fee * $cartItem->quantity, 2, '.', '')}}</p>
                            @else()
                            <?php
                               $cartDeliveryTotal += $cartItem->product->provincial_delivery_fee * $cartItem->quantity;
                             ?>
                            <p>Provincial Delivery fee: ₱ {{number_format($cartItem->product->provincial_delivery_fee * $cartItem->quantity, 2, '.', '')}}</p> 
                            @endif
							 <span>Delivered in 1-2 weeks</span>
							 <div class="clearfix"></div>
				        </div>						
				  </div>
			 </div>
			@endforeach
			
		 </div>
		  
		 <div class="col-md-3 cart-total" style="border-left: 1px solid; padding-left: 16px; ">
			
			 <div class="price-details">
				 <h3>Price Details</h3>
				 <span>Item Total</span>
				 <span class="total">₱ {{number_format($cartItemTotal, 2, '.', '')}}</span>
				 <span>Discount</span>
				 <span class="total">---</span>
				 <span>Delivery Charges</span>
				 <span class="total">₱ {{number_format($cartDeliveryTotal, 2, '.', '')}}</span>
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">TOTAL</h4>
			 <span class="total final">₱ {{number_format($cartItemTotal + $cartDeliveryTotal, 2, '.', '')}}</span>
			 <div class="clearfix"></div>
             <div id="paypalButtons" class="mt-5"></div>
			 <div class="total-item">
				 <h3>OPTIONS</h3>
				 <h4>COUPONS</h4>
				 <a class="cpns" href="#">Apply Coupons</a>
				 <p><a href="{{route('myAccount')}}">My account</a> to check your orders</p>
			 </div>
			</div>
	 </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=PHP"></script>
<script>paypal.Buttons().render('#paypalButtons');</script>
@endsection
