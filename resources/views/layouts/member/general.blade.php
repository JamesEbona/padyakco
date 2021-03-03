<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Padyak.Co</title>
<link rel="shortcut icon" href="{{ asset('images/member/padyak_logo.png') }}" />
<script src="https://kit.fontawesome.com/e63941d481.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('css/member/bootstrap.css') }}">
<!-- jQuery (Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/member/jquery.min.js') }}"></script>
<!-- Custom Theme files -->
<link href="{{ asset('css/member/form.css') }}" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="{{ asset('css/member/style.css') }}" media="all">

<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="keywords" content="Bike-shop" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--webfont-->
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>
<!--webfont-->
<!-- dropdown -->
<script src="{{ asset('js/member/jquery.easydropdown.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/member/nav.css') }}" media="all">
<!-- <script src="{{ asset('js/member/scripts.js') }}"></script> -->
<!--js-->
<!---- start-smoth-scrolling---->
        <!-- <script src="{{ asset('js/member/move-top.js') }}"></script>
        <script src="{{ asset('js/member/easing.js') }}"></script> -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
		</script>
<!---- start-smoth-scrolling---->
<style>

#description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}

#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

.pac-card {
  margin: 10px 10px 0 0;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  background-color: #fff;
  font-family: Roboto;
}

#pac-container {
  padding-bottom: 12px;
  margin-right: 12px;
}

.pac-controls {
  display: inline-block;
  padding: 5px 11px;
}

.pac-controls label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

#searchInput {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 400px;
}

#searchInput:focus {
  border-color: #4d90fe;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}

#target {
  width: 345px;
}

.btn-continue{
	background:orange;
	padding:10px 1.5em;
	border-radius:7px;
	font-size:1em;
	color:#fff;
	text-decoration:none;
	display: block;
   font-weight: 600;  
   text-align: center;
   width: 72%;
   margin: 0px auto 3em auto;
}
.btn-continue:hover{
	background:#333;
	color:#fff;
}


</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


</head>
<body>
<!--banner-->
<script src="{{ asset('js/member/responsiveslides.min.js') }}"></script>
<script>  
    $(function () {
      $("#slider").responsiveSlides({
      	auto: false,
      	nav: true,
      	speed: 500,
        namespace: "callbacks",
        pager: true,
      });
    });
  </script>
<div class="banner-bg banner-sec" style="background: url({{ asset('images/member/bg.jpg') }}) no-repeat; background-size:cover;
	min-height:200px;">	
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
						  <li class="dropdown1"><a href="/bicycles">STORE</a>
							  <ul class="dropdown2">
									<li><a href="/bicycles">MOUNTAIN BIKES</a></li>
									<li><a href="/bicycles">ROAD BIKES</a></li>
				                     @auth
									<li><a href="{{ route('orders') }}">MY ORDERS</a></li>
									@endauth												 
							  </ul>
						  </li>
						  <li class="dropdown1"><a href="{{ route('book') }}">REPAIR SERVICE</a>
							 <ul class="dropdown2">
									<li><a href="{{ route('book') }}">BOOK A MECHANIC</a></li>
									@auth
									<li><a href="{{ route('bookView') }}">VIEW BOOKINGS</a></li>
									@endauth
							  </ul>
						 </li>      
						 <li class="dropdown1"><a href="accessories.html">TRIP GUIDES</a>
							 <ul class="dropdown2">
									<li><a href="accessories.html">TRIP DESTINATIONS</a></li>
										<li><a href="accessories.html">ARTICLES</a></li>
										<li><a href="accessories.html">CONTRIBUTE</a></li>
							  </ul>
						 </li>    
						 @guest           
						 <li class="dropdown1"><a href="/login">LOGIN</a></li>
						 @endguest

						 @auth
						 <li class="dropdown1"><a href="/">MY ACCOUNT</a></li>

						 <li class="dropdown1">
						
                                       <a  href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('LOGOUT') }}</a>
                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
						
						 </li>
						  @endauth
						  @guest
						  <a class="shop" href="{{ route('cart') }}"><img src="{{ asset('images/member/cart.png') }}" alt=""/></a>						 
					      <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
						  @endguest
						  @auth
						  <a class="shop" href="{{ route('memberCart') }}"><img src="{{ asset('images/member/cart.png') }}" alt=""/></a>						 
					      <span class="badge">{{ Session::has('cartTotal') ? Session::get('cartTotal') : '' }}</span>
						  @endauth
					  </ul>
				 </div>
				 <div class="clearfix"></div>
			 </div>
	  </div>	 
		 
</div>
@yield('content')

<!---->
<div class="footer">
	 <div class="container wrap">
		<div class="logo2">
			 <a href="index.html"><img src="{{ asset('images/member/logo2.png') }}" alt=""/></a>
		</div>
		<div class="ftr-menu">
			 <ul>
				 <li class=""><a href="">© 2020 Padyak.Co</a></li>
				 <li><a href=""><i class="fab fa-facebook fa-2x"></i></a></li>
				 <li><a href=""><i class="fas fa-envelope fa-2x"></i></a></li>
			 </ul>
		</div>
		<div class="clearfix"></div>
	 </div>
</div>
<!---->
@yield('js')
 <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
 <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRpg8ZlzcJmaK8AYYf3-dPS-DyYnJBiqA&callback=initMap&libraries=places"
      async defer
    ></script>
</body>
</html>


