@extends('layouts.home.home')
@section('content')
<body>
<!--banner-->
<script src="{{ asset('js/member/responsiveslides.min.js') }}"></script>
<script>  
    $(function () {
      $("#slider").responsiveSlides({
      	auto: true,
      	nav: true,
      	speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>
<div class="banner-bg" style="background: url({{ asset('images/member/bg.jpg') }}) no-repeat; background-size:cover;
	min-height:835px;">	
	  <div class="container">
			 <div class="header">
			       <div class="logo">
						 <a href="/"><img src="{{ asset('images/member/padyak_logo.png') }}" alt=""/></a>
				   </div>							 
				  <div class="top-nav">										 
						<label class="mobile_menu" for="mobile_menu">
						<span>Menu</span>
						</label>
						<input id="mobile_menu" type="checkbox">
					   <ul class="nav">
					      <li class="dropdown1"><a href="/">HOME</a></li>
						  <li class="dropdown1"><a href="/bicycles">STORE</a>
							  <ul class="dropdown2">
									<li><a href="/bicycles">MOUNTAIN BIKES</a></li>
									<li><a href="/bicycles">ROAD BIKES</a></li>									
							  </ul>
						  </li>
						  <li class="dropdown1"><a href="{{ route('book') }}">REPAIR SERVICE</a>
							 <ul class="dropdown2">
									<li><a href="{{ route('book') }}">BOOK A MECHANIC</a></li>
							  </ul>
						 </li>      
						 <li class="dropdown1"><a href="{{route('tripGuides')}}">TRIP GUIDES</a>
						
						 </li>    
						 <li class="dropdown1"><a href="/register">REGISTER</a></li>    
						 <li class="dropdown1"><a href="/login">LOGIN</a></li>
						 <a class="shop" href="{{ route('cart') }}"><img src="{{ asset('images/member/cart.png') }}" alt=""/></a>
						 <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
						
					  </ul>
				 </div>
				 <div class="clearfix"></div>
			 </div>
	  </div>	 
	 <div class="caption">
		 <div class="slider">
					   <div class="callbacks_container">
						   <ul class="rslides" id="slider">
							    <li><h1>ONLINE BICYCLE STORE</h1></li>
								<li><h1>BICYCLE REPAIR SERVICE</h1></li>	
								<li><h1>TRIP GUIDE</h1></li>	
						  </ul>
						  <p>You <span>create</span> the <span>journey,</span> we supply the <span>parts</span></p>
						  <a class="morebtn" href="/register">JOIN NOW</a>
					  </div>
				  </div>
	 </div>
	 <div class="dwn">
		<a class="scroll" href="#cate"><img src="{{ asset('images/member/scroll.png') }}" alt=""/></a>
	 </div>				 
</div>
<!--/banner-->
<div id="cate" class="categories" style="background: url({{ asset('images/member/cate.jpg') }}">
	 <div class="container">
		 <h3>WHAT WE OFFER</h3>
		 <div class="categorie-grids">
			 <a href="bicycles.html"><div class="col-md-4 cate-grid" style="background: url({{ asset('images/member/c1.jpg') }}) no-repeat;">
				 <h4>NEED A BICYCLE?</h4>
				 <p>Choose from countless bicycle selections</p>
				 <a class="store" href="/bicycles">GO TO STORE</a>
			 </div></a>
			 <a href="bicycles.html"><div class="col-md-4 cate-grid" style="background: url({{ asset('images/member/c2.jpg') }}) no-repeat;">
				 <h4>HAVE A BICYCLE PROBLEM?</h4>
				 <p>Book an appointment with our mechanics</p>
				 <a class="store" href="{{route('book')}}">GO TO REPAIR SERVICE</a>
			 </div></a>
			 <a href="bicycles.html"><div class="col-md-4 cate-grid" style="background: url({{ asset('images/member/c3.jpg') }}) no-repeat;">
				 <h4>DON'T KNOW WHERE TO GO?</h4>
				 <p>View cycling trip guides</p>
				 <a class="store" href="/guides">GO TO TRIP GUIDE</a>
			 </div></a>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>
<!--bikes-->
<div class="bikes">	
		 <h3>POPULAR BICYCLES</h3>
		 <div class="bikes-grids">			 
			 <ul id="flexiselDemo1">
			     @foreach($products as $product)
				 <li>
					 <img src="/storage/{{$product->image1}}" alt=""/>
					 <div class="bike-info">
						 <div class="model">
							 <h4>{{$product->brand}} {{$product->title}}<span>₱{{$product->price}}</span></h4>							 
						 </div>
										 
						 <div class="clearfix"></div>
					 </div>
					 <div class="viw">
						<a href="{{route('viewBicycle', $product->id)}}">Quick View</a>
					 </div>
				 </li>
				 @endforeach
		    </ul>
			<script type="text/javascript">
			 $(window).load(function() {			
			  $("#flexiselDemo1").flexisel({
				visibleItems: 3,
				animationSpeed: 1000,
				autoPlay: true,
				autoPlaySpeed: 3000,    		
				pauseOnHover:true,
				enableResponsiveBreakpoints: true,
				responsiveBreakpoints: { 
					portrait: { 
						changePoint:480,
						visibleItems: 1
					}, 
					landscape: { 
						changePoint:640,
						visibleItems: 2
					},
					tablet: { 
						changePoint:768,
						visibleItems: 3
					}
				}
			});
			});
			</script>
			<script src="{{ asset('js/member/jquery.flexisel.js') }}"></script>	 
	</div>
</div>
<!---->
<div class="contact" style="background: url({{ asset('images/member/contact.jpg') }}) no-repeat 0px 0px; min-height:560px;
	background-size:cover; text-align:center; padding:4em 0;">
	<div class="container">
		<h3>CONTACT US</h3>
		<p>Please contact us for any inquires.</p>
		<form method="post" action="{{route('storeInquiry')}}">
		@csrf
		@if(session()->has('message'))
        <div class="alert alert-success" style="width:95%;">
        {{ session()->get('message') }}
        </div>
      @endif
            @if ($errors->any())
              <div class="alert alert-danger" style="width:95%;">
               <ul>
                  @foreach ($errors->all() as $error)
                   {{ $error }}<br>
                   @endforeach
              </ul>
              </div>
            @endif
			<input type="text" name="name" placeholder="NAME" required="">
			 <input type="text"  name="email" placeholder="E-MAIL" required="">			 
			 <input class="user"  type="text" name="subject" placeholder="SUBJECT" required=""><br>
			 <textarea name="message" placeholder="MESSAGE"></textarea>
			 <input type="submit" value="SEND">
		</form>
	</div>
</div>

@endsection