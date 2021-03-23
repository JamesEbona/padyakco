@extends('layouts.admin.admin')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Admins List</h1>
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
  
      <button class="btn btn-primary mb-3" onclick="addRow()"><i class="fa fa-plus" aria-hidden="true"></i> Admin</button>
      <div class="table-responsive">
      <table id="adminstable" class="table text-center">
<thead>
<tr>
  <th>Image</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Email</th>
  <th>Date Joined</th>
  <th>Status</th>
  <th>Action</th>
</tr>
</thead>
<tbody>
<!-- <tr>
  <td>Row 1 Data 1</td>
</tr> -->
@foreach ($users as $user)
  <tr>
      <td class="py-1"><a data-image="{{$user->image}}" onclick="viewUserPicture(this);"><img class="img-profile rounded-circle table-image" src="/storage/{{$user->image}}"></a></td>
      <td>{{$user->first_name}}</td>
      <td>{{$user->last_name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->created_at}}</td>
      @if($user->status == "active")
      <td> <span class="badge badge-success justify-content-center ">{{$user->status}}</span></td>
      @else
      <td> <span class="badge badge-danger justify-content-center ">{{$user->status}}</span></td>
      @endif
      <td><div class="row justify-content-center">
      <button class="btn btn-dark" data-id="{{$user->id}}" data-firstname="{{$user->first_name}}" data-lastname="{{$user->last_name}}" data-email="{{$user->email}}" data-role="{{$user->role}}"
       data-image="{{$user->image}}" onclick="editUser(this)"><i class="fa fa-edit" aria-hidden="true"></i></button>
      @if ($user->status == 'active')
      <a class="btn btn-warning ml-2" href="/admin/users/deactivate/{{ $user->id }}"><i class="fa fa-ban" aria-hidden="true"></i></a>
      @else
      <a class="btn btn-success ml-2" href="/admin/users/activate/{{ $user->id }}"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
      @endif
      <button class="btn btn-danger ml-2" data-id="{{$user->id}}" onclick="deleteUser(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">A deleted user cannot be recovered anymore.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteUserButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade crud" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_admin" action="javascript:void(0)" >
            @CSRF
           
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Admin</h5>
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
                <div class="row justify-content-center">
                  <a id="viewEditImageLink" target="_blank">
              <img id="viewEditImage" alt="" class="rounded-circle w-100" style="max-width: 200px;">
            </a>
            </div>
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
                        <label>Email</label>
                        <input class="form-control" type="email" id="editEmail" name="email" required="" >
                    </div>
                      <div class="form-group">
                        <label>Image (Minimum: 100 x 100)</label>
                        <input type="file" class="form-control" id="image" name="image">
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
                        <label>Optional Image (Minimum: 100 x 100)</label>
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

  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalTitle">View User Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
               <div class="form-group">
                <div class="row justify-content-center">
                  <a id="viewImageLink" target="_blank">
              <img id="viewImage" alt="" class="rounded-circle w-100" style="max-width: 200px;">
            </a>
            </div>
            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
$('#submit_add_admin').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/users/adminstore') }}",
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
                    window.location = "{{ url('/admin/adminusers/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_admin').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/users/modifyAdmin') }}",
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
                    window.location = "{{ url('/admin/adminusers/') }}";
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


