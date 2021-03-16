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
<link rel="stylesheet" href="{{ asset('css/member/style.css') }}" media="all">
<link href="{{ asset('css/member/form.css') }}" rel="stylesheet" type="text/css" media="all" />
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

</body>
</html>
