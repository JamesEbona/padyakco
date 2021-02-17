@extends('layouts.member.account')
@section('content')

		 <div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
			 <h2>My Profile:<a href="member/editprofile" class="account-links"><i class="fas fa-fw fa-edit pull-right"></i></a></h2>
			 <div class="cart-header">
				
				 <div class="cart-sec">
					<p>First Name:   {{ auth()->user()->first_name}}<p>
					<p>Last Name:   {{ auth()->user()->last_name}}<p>
					<p>E-mail:   {{ auth()->user()->email}}<p>
					<p>Joined at:   {{ date('F j, Y', strtotime(auth()->user()->created_at))}}<p>
				  </div>
			 </div>
			 <h2>My Delivery Details:<a href="member/editaddress" class="account-links"><i class="fas fa-fw fa-edit pull-right"></i></a></h2>
			 <div class="cart-header">
				
				<div class="cart-sec">
				    <p>Address1:   {{auth()->user()->address->address1}} <p>
					<p>Address2:   {{auth()->user()->address->address2}} <p>
					<p>City:   {{auth()->user()->address->city}}<p>
					<p>Province:   {{auth()->user()->address->province}}<p>
					<p>Postal Code:   {{auth()->user()->address->postal_code}}<p>
					<p>Phone Number:   {{auth()->user()->address->phone_number}}<p>
				 </div>
			</div>
			<h2>My Payment Details:<a href="" class="account-links"><i class="fas fa-fw fa-edit pull-right"></i></a></h2>
			<div class="cart-header">
				<div class="cart-sec">
					<p>Card Number: <p>  
					<p>Date of Expiry: <p>
				 </div>
			</div>
			

		
			
		 </div>
	
		
		 
	
	 </div>
				</div>

<!---->


@endsection