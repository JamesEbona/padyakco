@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Logistic Partners List</h1>
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
                @if(session()->has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session()->get('error_message') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
        </div>
      @endif
                <button class="btn btn-primary mb-3" onclick="addRow()"><i class="fa fa-plus" aria-hidden="true"></i> Logistics Partner</button>
                <div class="table-responsive">
                <table id="courierstable" class="table text-center">
    <thead>
        <tr>
            <th>Name</th>
            <th>Website</th>
            <th>Added at</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- <tr>
            <td>Row 1 Data 1</td>
        </tr> -->
        @foreach ($couriers as $courier)
            <tr>
                <td>{{$courier->name}}</td>
                <td>{{$courier->website ?? 'None'}}</td>
                <td>{{$courier->created_at}}</td>
                <td><div class="row justify-content-center">
                <button class="btn btn-dark" data-id="{{$courier->id}}" data-name="{{$courier->name}}" data-website="{{$courier->website}}"  onclick="editCourier(this)"><i class="fa fa-edit" aria-hidden="true"></i></button>
                <button class="btn btn-danger ml-2" data-id="{{$courier->id}}" onclick="deleteCourier(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
        <div class="modal-body">Logistic partner will be deleted.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteCourierButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade crud" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_courier" action="javascript:void(0)" >
            @CSRF
           
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Logistic Partner</h5>
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
                        <label>Name</label>
                        <input class="form-control" type="text" id="editName" name="name" required="" >
                    </div>

                    <div class="form-group">
                        <label>Delivery Tracker Website Link</label>
                        <textarea class="form-control" id="editWebsite" name="website" rows="2"></textarea>
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
            <form method = "POST" enctype="multipart/form-data" id="submit_add_courier" action="javascript:void(0)">
                @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle">Add Logistic Partner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required="" minlength="2" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Delivery Tracker Website Link</label>
                        <textarea class="form-control" rows="2" name="website"></textarea>
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
$('#submit_add_courier').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/couriers/store') }}",
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
                    window.location = "{{ url('/admin/couriers/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_courier').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/couriers/edit') }}",
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
                    window.location = "{{ url('/admin/couriers/') }}";
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


