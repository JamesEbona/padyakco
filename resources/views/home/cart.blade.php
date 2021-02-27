@section('title')
Padyak.Co - My Cart
@endsection

@extends('layouts.member.general')
@section('content')
<div class="cart" >
	 <div class="container style="min-height:160vh"">
		 <div class="cart-top">
			<a href="javascript:history.back()"><< back</a>
		 </div>	
			
		 <div class="col-md-9 cart-items">
			 <h2>My Shopping Bag ({{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }})</h2>
			  @if(Session::has('cart'))
			  @foreach($products as $product)
			  <?php
               $cartItemNo++;
			  ?>
				<script>$(document).ready(function(c) {
					$('.close{{$cartItemNo}}').on('click', function(c){
						$('.cart-header{{$cartItemNo}}').fadeOut('slow', function(c){
							$('.cart-header{{$cartItemNo}}').remove();
							$.ajax({
								type: "GET",
								url: "cart/remove/{{$product['item']['id']}}",
								success: function (result) {
                                 
									window.location = "{{ url('/cart') }}";
								   
                                }
								
						    });
						});
						});	  
					});
			   </script>
			 <div class="cart-header{{$cartItemNo}} cartHead">
				 <div class="close{{$cartItemNo}} closeCart"> </div>
				 <div class="cart-sec">
						<div class="cart-item cyc">
							 <img src="/storage/{{$product['item']['image1']}}"/>
						</div>
					   <div class="cart-item-info">
							 <h3>{{$product['item']['brand']}} {{$product['item']['title']}}<span>Model No: {{$product['item']['id']}}</span></h3>
							 <h4><span>₱ </span>{{number_format($product['price'],2)}}</h4>
						
							 <p class="qty">Quantity :</p>
							 @if ($product['qty'] == 1)
							 <button class="btn btn-warning btn-sm disabled" disabled><i class="fa fa-minus" aria-hidden="true"></i></button>
							 @else
							 <a class="btn btn-warning btn-sm  " href="{{route('reduceCart', $product['item']['id'])}}"><i class="fa fa-minus" aria-hidden="true"></i></a>
							 @endif
						     <strong>{{$product['qty']}}</strong>
							 @if ($product['qty'] >= $product['item']['quantity'])
							 <a class="btn btn-warning btn-sm disabled"><i class="fa fa-plus" aria-hidden="true"></i></a>
				             @else
							 <a class="btn btn-warning btn-sm " href="{{route('addOneCart', $product['item']['id'])}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
							 @endif
							
							 <!-- <input min="1" type="number" id="quantity" name="quantity" value="1" class="form-control input-small"> -->
					   </div>
					   <div class="clearfix"></div>
						<div class="delivery">
						     <p>Stocks available: {{$product['item']['quantity']}}</p>
							 <span>Delivered in 1-2 weeks</span>
							 <div class="clearfix"></div>
				        </div>						
				  </div>
			 </div>
			@endforeach
			
		 </div>
		  
		 <div class="col-md-3 cart-total" style="border-left: 1px solid; padding-left: 16px; ">
			 <a class="continue" href="/bicycles">Browse more items</a>
			 <div class="price-details">
				 <h3>Price Details</h3>
				 <span>Item Total</span>
				 <span class="total">₱ {{number_format($totalPrice,2)}}</span>
				 <span>Discount</span>
				 <span class="total">---</span>
				 <span>Delivery Charges</span>
				 <span class="total">Calculated on checkout</span>
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">SUBTOTAL</h4>
			 <span class="total final">₱ {{number_format($totalPrice,2)}}</span>
			 <div class="clearfix"></div>
			 <a class="order" href="/login">Checkout</a>
			 <div class="total-item">
				 <h3>OPTIONS</h3>
				 <h4>COUPONS</h4>
				 <a class="cpns" href="#">Apply Coupons</a>
				 <p><a href="/login">Log In</a> to checkout your items</p>
			 </div>
			</div>
			@else
			
			
		 </div>
		  
		 <div class="col-md-3 cart-total" style="border-left: 1px solid; padding-left: 16px; ">
			 <a class="continue" href="/bicycles">Browse more items</a>
			 <div class="price-details">
				 <h3>Price Details</h3>
				 <span>Prdouct Total</span>
				 <span class="total">---</span>
				 <span>Discount</span>
				 <span class="total">---</span>
				 <span>Delivery Charges</span>
				 <span class="total">---</span>
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">SUBTOTAL</h4>
			 <span class="total final">---</span>
			 <div class="clearfix"></div>
			 <a class="order cartDisabled" >Checkout</a>
			 <div class="total-item">
				 <h3>OPTIONS</h3>
				 <h4>COUPONS</h4>
				 <a class="cpns cartDisabled" >Apply Coupons</a>
				 <p>Add an item to your cart.</p>
			 </div>
			</div>
            
			 
			@endif
	 </div>
</div>
@endsection
