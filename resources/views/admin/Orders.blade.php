@extends('layouts.admin.admin')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Orders List</h1>
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
      <table id="orderstable" class="table text-center">
<thead>
<tr>
  <th>Order Number</th>
  <th>Member Name</th>
  <th>Email</th>
  <th>Phone Number</th>
  <th>Province</th>
  <th>Item Quantity</th>
  <th>Total Price</th>
  <th>Date Purchased</th>
  <th>Status</th>
  <th class="w-25">Action</th>
</tr>
</thead>
<tbody>
<!-- <tr>
  <td>Row 1 Data 1</td>
</tr> -->
@foreach ($orders as $order)
  <tr>
      <td>{{$order->id}}</td>
      <td>{{$order->first_name}} {{$order->last_name}}</td>
      <td>{{$order->email}}</td>
      <td>{{$order->phone_number}}</td>
      <td>{{$order->province}}</td>
      <td>{{$order->quantity_total}}</td>
      <td>₱{{$order->grand_total}}</td>
      <td>{{$order->created_at}}</td>
      @if($order->status =="paid")
        <td><span class="badge badge-primary justify-content-center">{{$order->status}}</span></td>
        @elseif($order->status =="in-transit")
        <td><span class="badge badge-info justify-content-center">{{$order->status}}</span></td>
        @elseif($order->status =="delivered")
        <td><span class="badge badge-success justify-content-center">{{$order->status}}</span></td>
        @elseif($order->status =="cancelled")
        <td><span class="badge badge-danger justify-content-center">{{$order->status}}</span></td>
        @endif
      <td><div class="row justify-content-center">
      <div class="col-md-4 ">
      <button @if($order->status == "cancelled" || $order->status == "delivered") disabled @endif class="btn btn-dark" data-id="{{$order->id}}" data-address1="{{$order->address1}}" data-address2="{{$order->address2}}" data-city="{{$order->city}}" data-province="{{$order->province}}" data-postalcode="{{$order->postal_code}}" data-phonenumber="{{$order->phone_number}}" onclick="editOrder(this);" ><i class="fa fa-edit" aria-hidden="true"></i></button>
      </div>
      <div class="col-md-4">
      <a class="btn btn-warning" href="{{route('adminOrderView', ['id' => $order->id])}}"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
      </div>
      <div class="col-md-4 ">
      <button @if($order->status == "cancelled" || $order->status == "delivered") disabled @endif class="btn btn-info " data-id="{{$order->id}}" data-status="{{$order->status}}" data-track="{{$order->tracking_number}}" data-courier="{{$order->courier_id}}" onclick="updateStatus(this);"><i class="fas fa-shipping-fast" aria-hidden="true"></i></button>
      </div></div> </td> 
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
            <form enctype="multipart/form-data"  id="submit_edit_order" action="javascript:void(0)" >
            @CSRF
           
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Order Delivery Details</h5>
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
                        <label>Address 1</label>
                        <input class="form-control" type="text" id="editAddress1" name="address1" required="" >
                    </div>
                    <div class="form-group">
                        <label>Address 2</label>
                        <input class="form-control" type="text" id="editAddress2" name="address2" required="" >
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input class="form-control" type="text" id="editCity" name="city" required="" >
                    </div>
                    <div class="form-group">
                        <label>Province</label>
                        <select class="form-control" name="province" id="editProvince">
                        <option value="Abra">Abra</option>
                        <option value="Albay">Albay</option>
                        <option value="Apayao">Apayao</option>
                        <option value="Aurora">Aurora</option>
                        <option value="Bataan">Bataan</option>
                        <option value="Batangas">Batangas</option>
                        <option value="Benguet">Benguet</option>
                        <option value="Bulacan">Bulacan</option>
                        <option value="Cagayan">Cagayan</option>
                        <option value="Camarines Norte">Camarines Norte</option>
                        <option value="Camarines Sur">Camarines Sur</option>
                        <option value="Cavite">Cavite</option>
                        <option value="Ifugao">Ifugao</option>
                        <option value="Ilocos Norte">Ilocos Norte</option>
                        <option value="Ilocos Sur">Ilocos Sur</option>
                        <option value="Isabela">Isabela</option>
                        <option value="Kalinga">Kalinga</option>
                        <option value="La Union">La Union</option>
                        <option value="Laguna">Laguna</option>
                        <option value="Metro Manila">Metro Manila</option>
                        <option value="Mountain Province">Mountain</option>
                        <option value="Nueva Ecija">Nueva Ecija</option>
                        <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                        <option value="Pampanga">Pampanga</option>
                        <option value="Pangasinan">Pangasinan</option>
                        <option value="Quezon">Quezon</option>
                        <option value="Quirino">Quirino</option>
                        <option value="Rizal">Rizal</option>
                        <option value="Tarlac">Tarlac</option>
                        <option value="Zambales">Zambales</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input class="form-control" type="text" id="editPostalCode" name="postal_code" required="" >
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input class="form-control" type="tel" id="editPhoneNumber" name="phone_number" required="" >
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

        <div class="modal fade crud" id="editStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_status" action="javascript:void(0)" >
            @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="editStatusId" name="editId">
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
            <div class="form-group">
                <label>Order Number</label>
                <input class="form-control" type="text" id="viewId" disabled >
                    </div>
      
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="editStatus">
                        <option value="paid">Paid</option>
                        <option value="in-transit">In-transit</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Logistic Partner</label>
                        <select class="form-control" name="courier_id" id="editCourier">
                        @foreach($couriers as $courier)
                        <option value="{{$courier->id}}">{{$courier->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tracking Number</label>
                        <input class="form-control" type="text" id="editTrackingNumber" name="tracking_number">
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

  <div class="modal fade crud" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method = "POST" enctype="multipart/form-data" id="submit_add_admin" action="javascript:void(0)">
                @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle">Add Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control @error('first_name') is-invalid @enderror" id="user_add_first_name" type="text" name="first_name" required="" minlength="2" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control @error('last_name') is-invalid @enderror" id="user_add_last_name" type="text" name="last_name" required="" minlength="2" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="user_add_email"  type="email" name="email" required="" maxlength="100">
                    </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" id="user_add_password"  type="password" name="password" required="" minlength="8" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" id="user_add_confirm_password"  type="password" name="password_confirmation" required="" minlength="8" maxlength="15">
                    </div>
                    <div class="form-group @error('image') is-invalid @enderror">
                        <label>Image (optional)</label>
                        <input type="file" id="user_add_image"  class="form-control" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add_submit" type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
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
$('#submit_edit_status').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/orders/updateStatus') }}",
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
                    $('editStatusModal').modal('hide');
                    window.location = "{{ url('/admin/orders/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_order').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/orders/modify') }}",
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
                    window.location = "{{ url('/admin/orders/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

// $('.modal-close').on('click', function () {
//     $('.admin-edit-errors').hide();   
//       });


    

});


</script>
@endsection


