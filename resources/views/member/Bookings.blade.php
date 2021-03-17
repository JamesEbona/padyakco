@extends('layouts.member.account')

@section('title')
My Bookings
@endsection

@section('content')
<div class="col-md-9 cart-items my-account-content" id="bookingsContent" style="padding-left: 16px;">
			 <h1 class="mb-4">My Bookings:</h1>
			 @foreach($bookings as $booking)
			 <div class="cart-header">
				 <div class="cart-sec">
				 <div class="row">
				 <div class="col-md-6">
                    <a href="{{route('bookShow', ['id' => $booking->id])}}" class="account-links"><h2>Booking # {{$booking->id}}</h2></a>
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
					<div class="row">
					<div class="col-md-12">
                    <p>Schedule: {{date('F j, Y h:i A', strtotime($booking->created_at))}}</p>
				    <p>Repair Type: {{$booking->repair_type}}</p>
                    <p>Location: {{$booking->location}}</p>
                    @if($booking->mechanic_id != NULL)
                    <p>Mechanic Name: {{$booking->mechanic->first_name}} {{$booking->mechanic->last_name}}</p>
                    @endif

					</div>
					</div>
					<div class="row">
					<div class="col-md-3">
					</div>
					</div>
				  </div>
			 </div>
		
			 @endforeach
		   
			 <dic class="row">&nbsp;</div>
			 <div class="row text-center mt-5 mb-5">
			 {{ $bookings->links() }}
             </div>
			 <div class="row">&nbsp;</div>
			
		
			
		 </div>
	 </div>
	</div>
@endsection

@section('js')
@if(count($bookings) != 0)
<script>
$("#bookingsContent").css({"border-left": "1px solid", "padding-left": "16px"});
</script>
@else
<script>
$("#sideBar").css({"border-right": "1px solid", "padding-right": "16px"});
</script>
@endif
@endsection