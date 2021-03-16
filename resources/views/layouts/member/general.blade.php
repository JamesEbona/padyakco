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



.card {
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}

.card > hr {
  margin-right: 0;
  margin-left: 0;
}

.card > .list-group {
  border-top: inherit;
  border-bottom: inherit;
}

.card > .list-group:first-child {
  border-top-width: 0;
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
}

.card > .list-group:last-child {
  border-bottom-width: 0;
  border-bottom-right-radius: calc(0.25rem - 1px);
  border-bottom-left-radius: calc(0.25rem - 1px);
}

.card > .card-header + .list-group,
.card > .list-group + .card-footer {
  border-top: 0;
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  min-height: 1px;
  padding: 1.25rem;
}

.card-title {
  margin-bottom: 0.75rem;
}

.card-subtitle {
  margin-top: -0.375rem;
  margin-bottom: 0;
}

.card-text:last-child {
  margin-bottom: 0;
}

.card-link:hover {
  text-decoration: none;
}

.card-link + .card-link {
  margin-left: 1.25rem;
}

.card-header {
  padding: 0.75rem 1.25rem;
  margin-bottom: 0;
  background-color: rgba(0, 0, 0, 0.03);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-footer {
  padding: 0.75rem 1.25rem;
  background-color: rgba(0, 0, 0, 0.03);
  border-top: 1px solid rgba(0, 0, 0, 0.125);
}

.card-footer:last-child {
  border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
}

.card-header-tabs {
  margin-right: -0.625rem;
  margin-bottom: -0.75rem;
  margin-left: -0.625rem;
  border-bottom: 0;
}

.card-header-pills {
  margin-right: -0.625rem;
  margin-left: -0.625rem;
}

.card-img-overlay {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1.25rem;
  border-radius: calc(0.25rem - 1px);
}

.card-img,
.card-img-top,
.card-img-bottom {
  -ms-flex-negative: 0;
  flex-shrink: 0;
  width: 100%;
}

.card-img,
.card-img-top {
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
}

.card-img,
.card-img-bottom {
  border-bottom-right-radius: calc(0.25rem - 1px);
  border-bottom-left-radius: calc(0.25rem - 1px);
}

.card-deck .card {
  margin-bottom: 15px;
}

@media (min-width: 576px) {
  .card-deck {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    margin-right: -15px;
    margin-left: -15px;
  }
  .card-deck .card {
    -ms-flex: 1 0 0%;
    flex: 1 0 0%;
    margin-right: 15px;
    margin-bottom: 0;
    margin-left: 15px;
  }
}

.card-group > .card {
  margin-bottom: 15px;
}

@media (min-width: 576px) {
  .card-group {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
  }
  .card-group > .card {
    -ms-flex: 1 0 0%;
    flex: 1 0 0%;
    margin-bottom: 0;
  }
  .card-group > .card + .card {
    margin-left: 0;
    border-left: 0;
  }
  .card-group > .card:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .card-group > .card:not(:last-child) .card-img-top,
  .card-group > .card:not(:last-child) .card-header {
    border-top-right-radius: 0;
  }
  .card-group > .card:not(:last-child) .card-img-bottom,
  .card-group > .card:not(:last-child) .card-footer {
    border-bottom-right-radius: 0;
  }
  .card-group > .card:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .card-group > .card:not(:first-child) .card-img-top,
  .card-group > .card:not(:first-child) .card-header {
    border-top-left-radius: 0;
  }
  .card-group > .card:not(:first-child) .card-img-bottom,
  .card-group > .card:not(:first-child) .card-footer {
    border-bottom-left-radius: 0;
  }
}

.card-columns .card {
  margin-bottom: 0.75rem;
}

@media (min-width: 576px) {
  .card-columns {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3;
    -webkit-column-gap: 1.25rem;
    -moz-column-gap: 1.25rem;
    column-gap: 1.25rem;
    orphans: 1;
    widows: 1;
  }
  .card-columns .card {
    display: inline-block;
    width: 100%;
  }
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
             @guest
            <li class="dropdown1"><a href="/">HOME</a></li>   
             @endguest
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
						 <li class="dropdown1"><a href="{{route('tripGuides')}}">TRIP GUIDES</a>
							 <!-- <ul class="dropdown2">
									<li><a href="{{route('tripGuides')}}">TRIP DESTINATIONS</a></li>
										<li><a href="{{route('tripGuides')}}">TIPS</a></li>
							  </ul> -->
						 </li>    
						 @guest   
             <li class="dropdown1"><a href="/register">REGISTER</a></li>        
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
			 <a href="/"><img src="{{ asset('images/member/logo2.png') }}" alt=""/></a>
		</div>
		<div class="ftr-menu">
			 <ul>
				 <li class=""><a href="">© 2020 Padyak.Co</a></li>
				 <li><a href="https://www.facebook.com/"><i class="fab fa-facebook fa-2x"></i></a></li>
				 <li><a href="mailto: padyak.co@gmail.com"><i class="fas fa-envelope fa-2x"></i></a></li>
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


