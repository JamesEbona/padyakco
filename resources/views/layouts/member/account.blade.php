<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Padyak.Co - Member</title>
<link rel="shortcut icon" href="{{ asset('images/member/padyak_logo.png') }}" />
<script src="https://kit.fontawesome.com/e63941d481.js" crossorigin="anonymous"></script>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<link rel="stylesheet" href="{{ asset('css/member/bootstrap.css') }}">
<!-- jQuery (Bootstrap's JavaScript plugins) -->
<script src="{{ asset('js/member/jquery.min.js') }}"></script>
<!-- Custom Theme files -->
<link rel="stylesheet" href="{{ asset('css/member/style.css') }}" media="all">
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Bike-shop" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--webfont-->
<link href='http://fonts.googleapis.com/css?family=Roboto:500,900,100,300,700,400' rel='stylesheet' type='text/css'>
<!--webfont-->
<!-- dropdown -->
<script src="{{ asset('js/member/jquery.easydropdown.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/member/nav.css') }}" media="all">
<script src="{{ asset('js/member/scripts.js') }}"></script>
<!--js-->
<!---- start-smoth-scrolling---->
        <script src="{{ asset('js/member/move-top.js') }}"></script>
        <script src="{{ asset('js/member/easing.js') }}"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
		</script>
<!---- start-smoth-scrolling---->


</head>
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
									<li><a href="{{ route('orders') }}">MY ORDERS</a></li>										
							  </ul>
						  </li>
						  <li class="dropdown1"><a href="{{ route('book') }}">REPAIR SERVICE</a>
							 <ul class="dropdown2">
									<li><a href="{{ route('book') }}">BOOK A MECHANIC</a></li>
									<li><a href="{{ route('bookView') }}">VIEW BOOKINGS</a></li>
							  </ul>
						 </li>      
						 <li class="dropdown1"><a href="accessories.html">TRIP GUIDES</a>
							 <ul class="dropdown2">
									<li><a href="accessories.html">TRIP DESTINATIONS</a></li>
										<li><a href="accessories.html">ARTICLES</a></li>
										<li><a href="accessories.html">CONTRIBUTE</a></li>
							  </ul>
						 </li>    
						
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
						  <a class="shop" href="{{ route('memberCart') }}"><img src="{{ asset('images/member/cart.png') }}" alt=""/></a>						 
					      <span class="badge">{{ Session::has('cartTotal') ? Session::get('cartTotal') : '' }}</span>
						
					  </ul>
				 </div>
				 <div class="clearfix"></div>
			 </div>
	  </div>	 
		 
</div>
<!--/banner-->
<div class="cart">
<div class="container">
<div class="col-md-3 cart-total">
		
		
		<img src="/storage/{{auth()->user()->image}}" alt="" class="img-circle w-100 center-block mb-2 avatar-myaccount" >
		
			
		   
			<div class="account-mini-details">
			<h3 class="text-center">{{ auth()->user()->first_name}} {{ auth()->user()->last_name}}</h3>
			<p class="text-center">Member</p>
			</div>
			<div class="text-center mt-3">
            <div><a class="account-links {{{ (Route::current()->getName() == "myAccount" ? 'active-link' : '') }}}" href="/">Account Details</a></div>
			<div><a class="account-links {{{ (Route::current()->getName() == "editProfile" ? 'active-link' : '') }}}" href="{{route('editProfile')}}">Update Profile</a></div>
			<div><a class="account-links {{{ (Route::current()->getName() == "editAddress" ? 'active-link' : '') }}}" href="{{route('editAddress')}}">Update Delivery Details</a></div>
			<div><a class="account-links {{{ (Route::current()->getName() == "editPassword" ? 'active-link' : '') }}}" href="{{route('editPassword')}}">Change Password</a></div>
			<div><a class="account-links" href="">My Repair Bookings</a></div>
			<div><a class="account-links {{{ (Route::current()->getName() == "orders" ? 'active-link' : '') }}}" href="{{route('orders')}}">My Orders</a></div>
            <div>
            <a class="account-links" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
            </form>
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

</body>
</html>


