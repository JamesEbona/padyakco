@extends('layouts.admin.admin')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Bookings List</h1>
</div>


<!-- Content Row -->

<div class="row">

  <!-- Area Chart -->
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
     
      <!-- Card Body -->
      <div class="card-body">
      @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
        </div>
      
      @endif
         <!-- <div class="alert alert-success" style="display:none"> </div> -->
  
    
      <div class="table-responsive">
      <table id="bookingstable" class="table text-center">
<thead>
<tr>
  <th>Booking Number</th>
  <th>Member Name</th>
  <th>Phone Number</th>
  <th>Location</th>
  <th>Repair Type</th>
  <th>Mechanic</th>
  <th>Schedule</th>
  <!-- <th>Date Booked</th> -->
  <th>Status</th>
  <th style="column-width:800px;">Action</th>
</tr>
</thead>
<tbody>
<!-- <tr>
  <td>Row 1 Data 1</td>
</tr> -->
@foreach ($bookings as $booking)
  <tr>
      <td>{{$booking->id}}</td>
      <td>{{$booking->first_name}} {{$booking->last_name}}</td>
      <td>{{$booking->phone_number}}</td>
      <td>{{$booking->location}}</td>
      <td>{{$booking->repair_type}}</td>
      <td>{{$booking->mechanic->first_name ?? 'Not'}} {{$booking->mechanic->last_name ?? 'Set'}}</td> 
      <td>{{$booking->booking_time}}</td>
      <!-- <td>{{date_format($booking->created_at,"d M, Y H:i")}}</td> -->
      @if($booking->status =="pending")
        <td><span class="badge badge-warning justify-content-center">{{$booking->status}}</span></td>
        @elseif($booking->status =="confirmed")
        <td><span class="badge badge-info justify-content-center">{{$booking->status}}</span></td>
        @elseif($booking->status =="en route")
        <td><span class="badge badge-primary justify-content-center">{{$booking->status}}</span></td>
        @elseif($booking->status =="done")
        <td><span class="badge badge-success justify-content-center">{{$booking->status}}</span></td>
        @elseif($booking->status =="cancelled")
        <td><span class="badge badge-danger justify-content-center">{{$booking->status}}</span></td>
        @endif
      <td><div class="row justify-content-center">
      <div class="col-md-3">
      <button class="btn btn-dark" @if($booking->status == "cancelled" || $booking->status == "done") disabled @endif data-id="{{$booking->id}}" data-firstname="{{$booking->first_name}}" data-lastname="{{$booking->last_name}}" data-phonenumber="{{$booking->phone_number}}" 
      data-repairtype="{{$booking->repair_type}}" data-bookingtime="{{ Carbon\Carbon::parse($booking->booking_time)->format('Y-m-d\TH:i')}}" data-notes="{{$booking->notes}}" data-additionalfee="{{$booking->additional_fee}}"
      data-status="{{$booking->status}}" onclick="editBooking(this);"><i class="fa fa-edit" aria-hidden="true"></i></button>
      </div>
      <div class="col-md-3">
      <button class="btn btn-warning" data-firstname="{{$booking->first_name}}" data-lastname="{{$booking->last_name}}" data-phonenumber="{{$booking->phone_number}}" 
      data-location="{{$booking->location}}" data-repairtype="{{$booking->repair_type}}" data-bookingtime="{{$booking->booking_time}}" data-notes="{{$booking->notes}}"
      data-mechanicname="{{$booking->mechanic->first_name ?? ''}} {{$booking->mechanic->last_name ?? ''}}"  data-mechanicimage="{{$booking->mechanic->image ?? ''}}" data-userimage="{{$booking->user->image ?? ''}}"
      data-additionalfee ="{{$booking->additional_fee ?? 0.00}}" data-repairfee="{{$booking->repair_fee}}" data-transportationfee="{{$booking->transportation_fee}}" data-id="{{$booking->id}}" data-createdat="{{$booking->created_at}}"
      data-totalfee="{{$booking->total_fee}}" data-status="{{$booking->status}}" data-mechanicstatus="{{$booking->mechanic->status ?? ''}}" data-mechanicnumber="{{$booking->mechanic->phone_number ?? ''}}" data-userstatus="{{$booking->user->status}}" onclick="viewBooking(this);"><i class="fas fa-info-circle" aria-hidden="true"></i></button>
      </div>
      <div class="col-md-3">
      <a class="btn btn-secondary" href="{{route('adminBookingsShowAddress', ['id' => $booking->id])}}"><i class="fas fa-map-marked-alt" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-3 ">
      <button class="btn btn-info" @if($booking->status != "confirmed" && $booking->status != "en route") disabled @endif data-id="{{$booking->id}}" data-mechanic="{{$booking->mechanic_id}}" data-additionalfee="{{$booking->additional_fee}}" onclick="updateMechanic(this);"><i class="fas fa-wrench" aria-hidden="true"></i></button>
      </div>
     
      </div> </td> 
  </tr>
@endforeach

</tbody>
</table>
</div>
                
      </div>
    </div>
  </div>

 
</div>


</div>

@endsection

@section('modals')
  <div class="modal fade crud" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_booking" action="javascript:void(0)" >
            @CSRF
           
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Booking Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="editId" name="editId">
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="editStatus">
                        </select>
                    </div> 
                    <div class="form-group">
                        <label>Additional Fee</label>
                        <input class="form-control" type="number" id="editAdditionalFee" name="additional_fee" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control" type="text" id="editFirstName" name="first_name" required="" >
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control" type="text" id="editLastName" name="last_name" required="" >
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input class="form-control" type="tel" id="editPhoneNumber" name="phone_number" required="" >
                    </div>
                    <div class="form-group">
                        <label>Repair Type</label>
                        <select class="form-control" name="repair_type" id="editRepairType">
                        <option value="Basic">Basic</option>
                        <option value="Expert">Expert</option>
                        <option value="Upgrade">Upgrade</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" rows="5" id="editNotes" name="notes"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Schedule</label>
                        <input type="datetime-local"  id="editBookingTime" name="booking_time"  class="form-control" required="">
                    </div>
                      <div class="pt-2">
              </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
        </div>
        </div>
         </div>
        </div>

        <div class="modal fade crud" id="editMechanicModal" tabindex="-1" role="dialog" aria-labelledby="editMechanicModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" type="post"  id="submit_edit_mechanic" action="javascript:void(0)" >
            @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Assigned Mechanic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="editMechanicId" name="editMechanicId">
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
            <div class="form-group">
                <label>Booking Number</label>
                <input class="form-control" id="viewStatusId" type="text" disabled >
                    </div>
                    <div class="form-group">
                        <label>Mechanic Assigned</label>
                        <select class="form-control" name="mechanic" id="editMechanic">
                        <option value="" selected>Select a mechanic</option>
                        @foreach($mechanics as $mechanic)  
                        <option value="{{$mechanic->id}}">{{$mechanic->first_name}} {{$mechanic->last_name}}</option>
                        @endforeach
                        </select>
                    </div>                    
                      <div class="pt-2">
              </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
        </div>
        </div>
         </div>
        </div>

  <div class="modal fade crud" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
                @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle">View Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row">
                <div class="col-md-12">
                <div class="card m-1">
            <div class="card-body">
              <h4 class="d-inline">Booking # </h4><h4 class="d-inline" id="viewId"></h4>
              <h4 class="d-inline ml-2"><span id="viewBookingStatus"></span></h4>
              <div class="row mt-2">
              <div class="col-md-12">
               <p class="d-inline">Location: </p><p class="d-inline" id="viewLocation"></p>
               </div>
              </div>
              <div class="row">
              <div class="col-md-12">
               <p class="d-inline">Booked at: </p><p class="d-inline" id="viewCreatedAt"></p>
               </div>
              </div>
              <div class="row">
              <div class="col-md-12">
               <p class="d-inline">Schedule: </p><p class="d-inline" id="viewBookingTime"></p>
               </div>
              </div>
              <div class="row">
              <div class="col-md-12">
               <p class="d-inline">Repair Type: </p><p class="d-inline" id="viewRepairType"></p>
               </div>
              </div>
                </div> 
          </div>
          </div>
          </div>
          <div class="row">
                <div class="col-md-6">
                <div class="card m-1">
            <div class="card-body">
            <h4 class="mb-2">Member Details:</h4>
            <div class="row mt-3">       
            <div class="col-xl-2 col-lg-2 d-flex">     
                <img id="viewUserImage" alt="" class="rounded-circle w-100" style="max-height:80px; max-width: 100px;">
            </div>     
            <div class="col-xl-10 col-lg-10">
            <p id= viewFirstName class="m-0 p-0 d-inline"></p> <p id= viewLastName class="m-0 p-0 d-inline"></p>
            <p class="ml-2 d-inline"><span id="viewUserStatus"></span></p>  
            <p id="viewPhoneNumber" class="m-0 p-0"></p>
          </div>
                               </div>    
                </div> 
          </div>
          </div>
          <div class="col-md-6">
                <div class="card m-1">
            <div class="card-body">
            <h4 class="mb-2">Assigned Mechanic Details:</h4>
            <div class="row mt-3">       
            <div class="col-xl-2 col-lg-2 d-flex">     
                <img id="viewMechanicImage" alt="" class="rounded-circle w-100" style="max-height:80px; max-width: 100px;">
            </div>     
            <div class="col-xl-10 col-lg-10">
            <p id= viewMechanicName class="m-0 p-0 d-inline"></p><p class="d-inline ml-2"><span id="viewMechanicStatus"></span></p>   
            <p id="viewMechanicNumber" class="m-0 p-0"></p>
          </div>
                               </div>    
                </div> 
          </div>
          </div>
          </div>

          <div class="row">
                <div class="col-md-6">
                <div class="card m-1">
            <div class="card-body">
            <h4 class="mb-2">Booking Payment Summary:</h4>
            <div class="row mt-3">
                                <div class="col-md-6">
                                     <p class="m-0 p-0 d-inline">Initial Repair Fee </p>(<p id="viewBookingTypePayment" class="m-0 p-0 d-inline"></p>)
                                </div>
                                <div class="col-md-6 text-right">
                                     <p class="d-inline">₱</p><p id="viewRepairFee" class="d-inline"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                     <p class="m-0 p-0">Transportation Fee</p>
                                </div>
                                <div class="col-md-6 text-right">
                                     <p class="m-0 p-0 d-inline">₱</p><p id="viewTransportationFee" class="m-0 p-0 d-inline"></p>
                                </div>
                            </div>
                            <div class="row" style="border-bottom: 2px solid; padding-bottom: 12px;">
                                <div class="col-md-8">
                                     <p class="m-0 p-0">Additional Fee</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <p class="d-inline m-0 p-0">₱</p><p id="viewAdditionalFee" class="m-0 p-0 d-inline"></p>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 12px;">
                                <div class="col-md-6">
                                    <p>Payment Total</p>
                                </div>
                                <div class="col-md-6 text-right">
                                <p class="d-inline">₱</p><p id="viewTotalFee" class="d-inline"></p>
                                </div>
                            </div>         
          </div>
          </div>
          </div>
          <div class="col-md-6">
                <div class="card m-1">
            <div class="card-body">
            <h4 class="mb-2">Notes to mechanic:</h4>
            <div class="row mt-3"> 
            <div class="col-md-12">      
            <p id="viewNotes" class="text-justify"></p> 
                               </div>    
                </div> 
                </div>
          </div>
          </div>
         
        </div>

        </div>
         </div>
        </div> 
        </div>     

@endsection

@section('js')
<script src="{{ asset('js/admin/modals.js') }}"></script>
<script>

$(document).ready(function (e) {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#submit_edit_mechanic').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/bookings/updateMechanic') }}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: function(result){
                if(result.errors)
                {
                    $('.modal-errors').html('');
    
                    $.each(result.errors, function(key, value){
                        $('.modal-errors').show();
                        $('.modal-errors').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    $('.modal-errors').hide();
                    $('editMechanicModal').modal('hide');
                    window.location = "{{ url('/admin/bookings/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_booking').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/bookings/modify') }}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: function(result){
                if(result.errors)
                {
                    $('.modal-errors').html('');
    
                    $.each(result.errors, function(key, value){
                        $('.modal-errors').show();
                        $('.modal-errors').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    $('.modal-errors').hide();
                    $('#editModal').modal('hide');
                    window.location = "{{ url('/admin/bookings/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#editMechanicModal').on('hidden.bs.modal', function () {
    $("#editMechanic").val("");
      });
});

</script>

@endsection


