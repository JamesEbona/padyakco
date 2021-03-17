@extends('layouts.member.general')
@section('content')
<!--/banner-->
<div class="product">
	 <div class="container">
		 <div class="ctnt-bar cntnt">
			 <div class="content-bar">
				 <div class="single-page">
					 <div class="product-head">
					 
						<a class="account-links" href="/">Home</a> <span>/</span> <a class="account-links" href="/store">STORE</a> <span>/</span>	<a class="account-links" href="/store/show/{{$product->id}}">{{$product->title}}</a>
						</div>
					 <!--Include the Etalage files-->
				      	<link rel="stylesheet" href="{{ asset('css/member/etalage.css') }}">
						<script src="{{ asset('js/member/jquery.etalage.min.js') }}"></script>
				<script>
			jQuery(document).ready(function($){

				$('#etalage').etalage({
					thumb_image_width: 400,
					thumb_image_height: 400,
					source_image_width: 800,
					source_image_height: 1000,
					show_hint: true,
					click_callback: function(image_anchor, instance_id){
						alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
					}
				});

			});
		</script>
						<!--//details-product-slider-->
					 <div class="details-left-slider">
						 <div class="grid images_3_of_2">
						  <ul id="etalage">
							<li>
								<a href="optionallink.html">
									<img class="etalage_thumb_image" src="/storage/{{$product->image1}}" class="img-responsive" />
									<img class="etalage_source_image" src="/storage/{{$product->image1}}" class="img-responsive" title="" />
								</a>
							</li>
							<li>
								<img class="etalage_thumb_image" src="/storage/{{$product->image2}}" class="img-responsive" />
								<img class="etalage_source_image" src="/storage/{{$product->image2}}" class="img-responsive" title="" />
							</li>
							<li>
								<img class="etalage_thumb_image" src="/storage/{{$product->image3}}" class="img-responsive"  />
								<img class="etalage_source_image" src="/storage/{{$product->image3}}"class="img-responsive"  />
							</li>
						    <li>
								<img class="etalage_thumb_image" src="/storage/{{$product->image1}}" class="img-responsive"  />
								<img class="etalage_source_image" src="/storage/{{$product->image1}}"class="img-responsive"  />
							</li>
						</ul>
						</div>
					 </div>
					 
					 <div class="details-left-info">
					 	 @if(session()->has('message'))
						  <div class="alert alert-success">
							<strong>Ordered!</strong> {{ session()->get('message') }}
							</div>
                            @endif
							<h3>{{$product->title}}</h3>
								<h4>Model No: {{$product->id}}</h4>
							<h4></h4>
							<p><label>₱</label> {{number_format($product->price,2)}}</p>
							<p class="size">STOCKS LEFT ::</p>
							@guest
							<?php
							$productQty = 0;
								if(Session::has('cart')){
                                 $cart = (array) Session::get('cart');
								 if(isset($cart['items'][$product->id])){
								 $productQty = $cart['items'][$product->id]['qty'];
								 }
								}
							?>
							<a class="length" >{{$product->quantity - $productQty}}</a>
							@endguest
							@auth 
							<a class="length" >{{$product->quantity - $cart_item_qty}}</a>
							@endauth
							<div class="btn_form">
			                @guest
							    <?php
							
                                if($product->quantity == 0 OR $productQty >= $product->quantity){
								?>
								<a class="cartDisabled">SOLD OUT</a>
								<?php
								}
								else{
								?>
								<a href="{{route('addCart', ['id' => $product->id])}}">ADD TO CART</a>
								<?php
								}
								?>
							@endguest
							@auth   
							<?php
                                if($product->quantity == 0 OR $cart_item_qty >= $product->quantity){
								?>
								<a class="cartDisabled">SOLD OUT</a>
								<?php
								}
								else{
								?>
								<a href="{{route('memberAddCart', ['id' => $product->id])}}">ADD TO CART</a>
								<?php
								}
								?>
							@endauth
							</div>
							<div class="bike-type">
							<p>TYPE  ::<a>{{$product->subcategory->title}}</a></p>
							<p>BRAND  ::<a>{{$product->brand}}</a></p>
							</div>
							<h5>Description  ::</h5>
							<p class="desc">{{$product->description}}</p>
					 </div>
					 <div class="clearfix"></div>				 	
				  </div>
			  </div>
		  </div>
		  @if(count($related_products) != 0)
		  <div class="single-bottom2">
			  <h6>Related Products</h6>
			  @foreach($related_products as $related_product)
			 <div class="product">
					 <div class="product-desc">
						  <div class="product-img product-img2">
							 <img src="/storage/{{$related_product->image1}}" class="img-responsive " alt=""/>
						 </div>
						 <div class="prod1-desc">
								<h5><a class="product_link" href="/store/show/{{$related_product->id}}">{{$related_product->brand}} {{$related_product->title}}</a></h5>
								<p class="product_descr">{{$related_product->description}}</p>									
						 </div>
						 <div class="clearfix"></div>
					 </div>
					 <div class="product_price">
							<span class="price-access">₱{{number_format($related_product->price,2)}}</span>								
							<a class="button1 ml-2" href="/store/show/{{$related_product->id}}"><span>View</span></a>
					 </div>
						<div class="clearfix"></div>
			 </div>
			 @endforeach
		 </div>	
		 @endif

	 </div>
</div>
<!---->
@endsection