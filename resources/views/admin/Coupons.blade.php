@extends('layouts.admin.admin')
@section('title')
Padyak.Co Admin - Coupons
@endsection
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Coupons List</h1>
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
                <button class="btn btn-primary mb-3" onclick="addRow()"><i class="fa fa-plus" aria-hidden="true"></i> Coupon</button>
                <div class="table-responsive">
                <table id="couponstable" class="table text-center">
    <thead>
        <tr>
            <th>Title</th>
            <th>Code</th>
            <th>Type</th>
            <th>Category</th>
            <th>Value</th>
            <th>Percent</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- <tr>
            <td>Row 1 Data 1</td>
        </tr> -->
        @foreach ($coupons as $coupon)
            <tr>
                <td>{{$coupon->title}}</td>
                <td>{{$coupon->code}}</td>
                <td>{{$coupon->type}}</td>
                <td>{{$coupon->category ?? ''}}</td>
                <td>{{$coupon->value ?? ''}}</td>
                <td>{{$coupon->percent_off ?? ''}}</td>
                @if($coupon->status == "active")
                <td> <span class="badge badge-success justify-content-center ">{{$coupon->status}}</span></td>
                @else
                <td> <span class="badge badge-danger">{{$coupon->status}}</span></td>
                @endif
                <td><div class="row justify-content-center">
                <button class="btn btn-dark" data-id="{{$coupon->id}}" data-title="{{$coupon->title}}" data-code="{{$coupon->code}}" data-type="{{$coupon->type}}" data-category="{{$coupon->category}}" data-value="{{$coupon->value}}" data-percent="{{$coupon->percent_off}}"  onclick="editCoupon(this)"><i class="fa fa-edit" aria-hidden="true"></i></button>
                @if ($coupon->status == 'active')        
                <a class="btn btn-warning ml-2" href="/admin/coupons/deactivate/{{ $coupon->id }}"><i class="fa fa-eye-slash" aria-hidden="true"></i></a> 
                @else                
                <a class="btn btn-success ml-2" href="/admin/coupons/activate/{{ $coupon->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>              
                @endif
                <button class="btn btn-danger ml-2" data-id="{{$coupon->id}}" onclick="deleteCoupon(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
        <!-- /.container-fluid -->       
       
@endsection

@section('modals')
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Coupon will be deleted.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteCouponButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade crud" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_coupon" action="javascript:void(0)" >
            @CSRF
           
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Coupon</h5>
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
                        <label>Title</label>
                        <input class="form-control @error('title') is-invalid @enderror" id="editTitle" type="text" name="title" required="" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input class="form-control @error('code') is-invalid @enderror" id="editCode" type="text" name="code" required="" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select class="form-control" id="editType" name="type">
                        <option value="Fixed" selected>Fixed</option>
                        <option value="Percent">Percent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="editCategory" name="category">
                        <option value="Store" selected>Store</option>
                        <option value="Repair">Repair</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fixed Discount Value</label>
                        <input class="form-control" id="editValue" type="number" name="value"  min="1" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Percent Discount</label>
                        <input class="form-control" id="editPercent" type="number" name="percent_off" max="100"  min="1" step="1">
                    </div>
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
            <form method = "POST" enctype="multipart/form-data" id="submit_add_coupon" action="javascript:void(0)">
                @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle">Add Coupon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" required="" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Code</label>
                        <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" required="" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select class="form-control" id="type" name="type">
                        <option value="Fixed" selected>Fixed</option>
                        <option value="Percent">Percent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category" name="category">
                        <option value="Store" selected>Store</option>
                        <option value="Repair">Repair</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fixed Discount Value</label>
                        <input class="form-control @error('value') is-invalid @enderror" type="number" name="value"  min="1" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Percent Discount</label>
                        <input class="form-control @error('percent_off') is-invalid @enderror" type="number" name="percent_off"  min="1" max="100" step="1">
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
$('#submit_add_coupon').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/coupons/store') }}",
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
                    $('#addModal').modal('hide');
                    window.location = "{{ url('/admin/coupons/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_coupon').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/coupons/update') }}",
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
                    window.location = "{{ url('/admin/coupons/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

});
</script>
@endsection


