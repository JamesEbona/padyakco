@extends('layouts.member.account')

@section('title')
My Booking
@endsection

@section('content')
<div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
			 <h1 class="mb-4"> <a href="{{route('bookView')}}" class="account-links">Bookings</a> / My Booking</h1>
			 <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-6">
				   <h2>Booking # {{$booking->id}}</h2>
					</div>
					<div class="col-md-6">
                    @if($booking->status =="pending")
					<h2 class="text-right"><span class="label label-warning">{{$booking->status}}</span></h2>
                    @elseif($booking->status =="confirmed")
					<h2 class="text-right"><span class="label label-info">{{$booking->status}}</span></h2>
					@elseif($booking->status =="en route")
					<h2 class="text-right"><span class="label label-default">{{$booking->status}}</span></h2>
					@elseif($booking->status =="done")
					<h2 class="text-right"><span class="label label-success">{{$booking->status}}</span></h2>
					@elseif($booking->status =="cancelled")
					<h2 class="text-right"><span class="label label-danger">{{$booking->status}}</span></h2>
					@endif
					</div>
					</div>
					<div class="row mb-3">
					<div class="col-md-12">
                    <p>Schedule: {{date('F j, Y h:i A', strtotime($booking->booking_time))}}</p>
				    <p>Repair Type: {{$booking->repair_type}}</p>
                    <p>Location: {{$booking->location}}</p>
					</div>
					</div>
                  
				
				  </div>
			 </div>  
             <div class="row">
             @if($booking->mechanic_id != NULL)
             <div class="col-md-6">
             <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-12">
				    <h2>Mechanic Details:</h2>
					</div>
					</div>
					<div class="row">
                    <div class="col-md-12">
                    <img src="/storage/{{$booking->mechanic->image}}" alt="" class="img-circle w-100 center-block mb-2 avatar-myaccount" >
                    </div>
					</div>
                    <div class="row">
                    <div class="col-md-12">
				    <p class="text-center">{{$booking->mechanic->first_name}} {{$booking->mechanic->last_name}} </p>
					</div>
                    </div>
					<div class="row">
                    <div class="col-md-12">
				    <p class="text-center">{{$booking->mechanic->phone_number}}</p>
					</div>
                    </div>
				  </div>
			 </div>  
             </div>
             @endif
             <div class="col-md-6">
             <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-12">
				    <h2>Booking Price Summary:</h2>
					</div>
					</div>
					<div class="row">
					<div class="col-md-6">
				    <p>{{$booking->repair_type}} Repair Fee</p>
					</div>
                    <div class="col-md-6 text-right">
				    <p>₱{{number_format($booking->repair_fee,2)}}</p>
					</div>
					</div>
					<div class="row" style="border-bottom: 2px solid; padding-bottom: 12px;">
					<div class="col-md-8">
                    <p>Transportation Fee</p>
					</div>
                    <div class="col-md-4 text-right">
				    <p>₱{{number_format($booking->transportation_fee,2)}}</p>
					</div>
					</div>
                    @if($booking->additional_fee != NULL)
                    <div class="row" style="border-bottom: 2px solid; padding-bottom: 12px;">
					<div class="col-md-8">
                    <p>Additional Fee</p>
					</div>
                    <div class="col-md-4 text-right">
				    <p>₱{{number_format($booking->additional_fee,2)}}</p>
					</div>
					</div>
                    @endif
                    <div class="row" style="padding-top: 12px;">
					<div class="col-md-6">
                    <p>Payment Total @if($booking->additional_fee == NULL)Estimate @endif</p>
					</div>
                    <div class="col-md-6 text-right">
				    <p>₱{{number_format($booking->total_fee,2)}}</p>
					</div>
					</div>
                    
				  </div>
			 </div>  
             </div>
             </div>
			 @if($booking->notes != NULL)
			 <div class="row">
			 <div class="col-md-12">
			 <div class="cart-header">
		     <div class="cart-sec">
			 <h2>Notes to mechanic:</h2>
			 <p class="mb-5">{{$booking->notes}}</p>
			 </div>
			 </div>
			 </div>
			 @endif
			 <div class="row">&nbsp;</div>
		

		
			
		 </div>
	
		
		 
	
	 </div>
				</div>



@endsection