@extends('layouts.member.general')
@section('content')
<!--/banner-->
<div class="product">
	 <div class="container">
		 <div class="ctnt-bar cntnt">
			 <div class="content-bar">
				 <div class="single-page">
					 <div class="product-head">
					 
						<a href="/">Home</a> <span>/</span> <a href="/bicycles">BICYCLES</a> <span>/</span>	<a href="/bicycles/show/{{$bicycle->id}}">{{$bicycle->title}}</a>
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
									<img class="etalage_thumb_image" src="/storage/{{$bicycle->image1}}" class="img-responsive" />
									<img class="etalage_source_image" src="/storage/{{$bicycle->image1}}" class="img-responsive" title="" />
								</a>
							</li>
							<li>
								<img class="etalage_thumb_image" src="/storage/{{$bicycle->image2}}" class="img-responsive" />
								<img class="etalage_source_image" src="/storage/{{$bicycle->image2}}" class="img-responsive" title="" />
							</li>
							<li>
								<img class="etalage_thumb_image" src="/storage/{{$bicycle->image3}}" class="img-responsive"  />
								<img class="etalage_source_image" src="/storage/{{$bicycle->image3}}"class="img-responsive"  />
							</li>
						    <li>
								<img class="etalage_thumb_image" src="/storage/{{$bicycle->image1}}" class="img-responsive"  />
								<img class="etalage_source_image" src="/storage/{{$bicycle->image1}}"class="img-responsive"  />
							</li>
						</ul>
						</div>
					 </div>
					 
					 <div class="details-left-info">
					 	 @if(session()->has('message'))
						  <div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Ordered!</strong> {{ session()->get('message') }}
							</div>
                            @endif
							<h3>{{$bicycle->title}}</h3>
								<h4>Model No: {{$bicycle->id}}</h4>
							<h4></h4>
							<p><label>₱</label> {{$bicycle->price}}</p>
							<p class="size">STOCKS LEFT ::</p>
							<a class="length" >{{$bicycle->quantity}}</a>
							<div class="btn_form">
			                @guest
							    <?php
								$productQty = 0;
								if(Session::has('cart')){
                                 $cart = (array) Session::get('cart');
								 $productQty = $cart['items']['3']['qty'];
								}
                                if($bicycle->quantity == 0 OR $productQty >= $bicycle->quantity){
								?>
								<a class="cartDisabled">SOLD OUT</a>
								<?php
								}
								else{
								?>
								<a href="{{route('addCart', ['id' => $bicycle->id])}}">ADD TO CART</a>
								<?php
								}
								?>
							@endguest
							@auth   
							<?php
                                if($bicycle->quantity == 0 OR $cart_item_qty >= $bicycle->quantity){
								?>
								<a class="cartDisabled">SOLD OUT</a>
								<?php
								}
								else{
								?>
								<a href="{{route('memberAddCart', ['id' => $bicycle->id])}}">ADD TO CART</a>
								<?php
								}
								?>
							@endauth
							</div>
							<div class="bike-type">
							<p>TYPE  ::<a>{{$bicycle->subcategory->title}}</a></p>
							<p>BRAND  ::<a>{{$bicycle->brand}}</a></p>
							</div>
							<h5>Description  ::</h5>
							<p class="desc">{{$bicycle->description}}</p>
					 </div>
					 <div class="clearfix"></div>				 	
				  </div>
			  </div>
		  </div>
		  <div class="single-bottom2">
			  <h6>Related Products</h6>
			  @foreach($related_products as $related_product)
			 <div class="product">
					 <div class="product-desc">
						  <div class="product-img product-img2">
							 <img src="/storage/{{$related_product->image1}}" class="img-responsive " alt=""/>
						 </div>
						 <div class="prod1-desc">
								<h5><a class="product_link" href="/bicycles/show/{{$related_product->id}}">{{$related_product->brand}} {{$related_product->title}}</a></h5>
								<p class="product_descr">{{$related_product->description}}</p>									
						 </div>
						 <div class="clearfix"></div>
					 </div>
					 <div class="product_price">
							<span class="price-access">₱{{$related_product->price}}</span>								
							<a class="button1 ml-2" href="/bicycles/show/{{$related_product->id}}"><span>View</span></a>
					 </div>
						<div class="clearfix"></div>
			 </div>
			 @endforeach
		
			
		 </div>	
	 </div>
</div>
<!---->
@endsection