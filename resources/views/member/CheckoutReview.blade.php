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
		 @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="ml-4">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
			 <h2>Order Summary ({{ $cart->total_quantity ?? '0' }})</h2>
			  @foreach($cartItems as $cartItem)
			  <?php
               $cartItemNo++;
			   $cartItemTotal += $cartItem->product->price * $cartItem->quantity;
			  ?>
			 <div class="cart-header{{$cartItemNo}} cartHead">
			
				 <div class="cart-sec">
						<div class="cart-item cyc">
						      <a href="/store/show/{{$cartItem->product->id}}">
							 <img src="/storage/{{$cartItem->product->image1}}"/>
							 </a>
						</div>
					   <div class="cart-item-info">
							 <h3>{{$cartItem->product->brand}} {{$cartItem->product->title}}<span>Model No: {{$cartItem->product->id}}</span></h3>
							 <h4><span>₱ </span>{{number_format($cartItem->product->price,2)}}</h4>
						     <h4>X</h4>
							 <p class="qty">Quantity :</p>
						     <strong>{{$cartItem->quantity}}</strong>
                             <h4 class= "ml-5"><span>₱ </span>{{number_format($cartItem->product->price * $cartItem->quantity,2)}}</h4>
							
							 <!-- <input min="1" type="number" id="quantity" name="quantity" value="1" class="form-control input-small"> -->
					   </div>
					   <div class="clearfix"></div>
						<div class="delivery">
                            @if(Auth::user()->address->province == 'Metro Manila')
                             <?php
                               $cartDeliveryTotal += $cartItem->product->delivery_fee * $cartItem->quantity;
                             ?>
						     <p>Delivery fee: ₱ {{number_format($cartItem->product->delivery_fee * $cartItem->quantity,2)}}</p>
                            @else()
                            <?php
                               $cartDeliveryTotal += $cartItem->product->provincial_delivery_fee * $cartItem->quantity;
                             ?>
                            <p>Provincial Delivery fee: ₱ {{number_format($cartItem->product->provincial_delivery_fee * $cartItem->quantity,2)}}</p> 
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
				 <span class="total">₱ {{number_format($cartItemTotal,2)}}</span>
				 <span>Delivery Charges</span>
				 <span class="total">₱ {{number_format($cartDeliveryTotal,2)}}</span>
				 @if(session()->has('coupon'))
				 <form action="{{route('store.destroyCoupon')}}" method="post" id="destroy_coupon">
				 @csrf
				 <span>Discount<a class="account-links ml-2" href="javascript:$('#destroy_coupon').submit();"><i class="fas fa-trash-alt fa-sm"></i></a></span>
                 </form>
				 
				 <span class="total">- ₱ {{number_format(session()->get('coupon')['discount'],2)}}</span>
				 <span>({{session()->get('coupon')['name']}})</span>
				 <span class="total">&nbsp;</span>
				 @endif
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">TOTAL</h4>
			 <span class="total final">₱ {{max(number_format($cartItemTotal + $cartDeliveryTotal - $discount,2),0.00)}}</span>
			 <div class="clearfix"></div>
             <div id="paypalButtons" class="mt-5"></div>
			 @if(! session()->has('coupon'))
			 <div class="total-item mt-2">
				 <h3>COUPONS</h3>
                 <form action="{{route('store.storeCoupon')}}" method="post">
                 @csrf
				 <input type="text" class="form-control" name="coupon_code" id="coupon_code"> 
				 <input type="hidden" name="cartTotal" value="{{$cartItemTotal + $cartDeliveryTotal}}">
				 <button type="submit" class="btn cpns">Apply Coupon</a>
                 </form>
			 </div>
			 @endif
			 <div class="total-item mt-0">
				 <!-- <h3>OPTIONS</h3> -->
				 <h3>REMINDERS</h3>
				 <!-- <h4>COUPONS</h4>
				 <a class="cpns" href="#">Apply Coupons</a> -->
				 <p><a href="{{route('myAccount')}}">My account</a> to check your orders</p>
				 <p>An online receipt will be sent to your registered e-mail.</p>
			 </div>
			</div>
	 </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id=AdxXimYRlwtcfMiPD8Y13isalZqY6IO847zNO43qvfPzSlnBtMNzKahvjaQTtukF-eRCPlRKpcBeXliy&currency=PHP"></script>
<script>
    var amount = {{max(($cartItemTotal + $cartDeliveryTotal) - $discount, 0.00)}};
	var item_total = {{$cartItemTotal}};
	var discount = {{$discount}};
	var discount_code = '{{$discount_code}}';
	var delivery_total = {{$cartDeliveryTotal}};
    paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.

	
	    //removed check code ajax here
	  
		return actions.order.create({
						purchase_units: [{
						description: "Padyak.Co store order",
						amount: {
						
							value: amount,
							// breakdown: {
							// 			item_total: {
							// 				currency_code:"PHP",
							// 				value: item_total
							// 			},
							// 			shipping: {
							// 				currency_code:"PHP",
							// 				value: delivery_total
							// 			},
							// 		}
						},
						
						}],
						application_context: {
        shipping_preference: 'NO_SHIPPING'
      }
					});	
		
    },
    onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({  
			type: 'POST',  
			url: '{{ route("order") }}', 
			data: { amount: amount,
			        item_total: item_total,
					delivery_total: delivery_total,
					discount_code: discount_code,
					discount: discount
			},
			success: function(response) {
				window.location = "{{ route('orderPlaced') }}";
			}
		});		   
      });
    }
  }).render('#paypalButtons');
  //This function displays Smart Payment Buttons on your web page.

</script>
@endsection
