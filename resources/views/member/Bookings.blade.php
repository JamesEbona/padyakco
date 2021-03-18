@extends('layouts.member.account')

@section('title')
My Bookings
@endsection

@section('content')
<div class="col-md-9 cart-items my-account-content" id="bookingsContent" style="padding-left: 16px;">
			 <h1 class="mb-4">My Bookings:</h1>
			 @if(session()->has('message'))
				<div class="alert alert-success mb-4">
					{{ session()->get('message') }}
				</div>
             @endif
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
					<div class="col-md-8">
                    <p>Schedule: {{date('F j, Y h:i A', strtotime($booking->booking_time))}}</p>
				    <p>Repair Type: {{$booking->repair_type}}</p>
                    <p>Location: {{$booking->location}}</p>
                    @if($booking->mechanic_id != NULL)
                    <p>Mechanic Name: {{$booking->mechanic->first_name}} {{$booking->mechanic->last_name}}</p>
                    @endif
					</div>
					<div class="col-md-4">
					@if($booking->status =="pending")
					<a class="pull-right btn btn-danger btn-sm" data-id="{{$booking->id}}" onclick="cancelBooking(this);">Cancel booking</a>
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

	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to cancel your booking?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Your repair service booking will be cancelled.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Back</button>
          <a class="btn btn-danger" id="CancelBookingButton">Cancel
          </a>
        </div>
      </div>
    </div>
  </div> 
@endsection

@section('js')
<script src="{{ asset('js/member/bootstrap.min.js') }}"></script>
<script>
function cancelBooking(arg) {
    $('#deleteModal').modal('show');
    var id = $(arg).attr('data-id');
    var href_start = "/member/book/cancel/";
    var href = href_start + id;

     $("#CancelBookingButton").attr('href', href);
}
</script>
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