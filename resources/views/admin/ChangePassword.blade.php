@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
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
            @if ($errors->any())
              <div class="alert alert-danger">
               <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                   @endforeach
              </ul>
              </div>
            @endif
                  <form  method="post" action="/admin/submitchangepassword" >
                @CSRF
                @method('PATCH')
<!--             
                 <div class="form-group">
                        <label>Old Password</label>
                        <input class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" required>
                    </div> -->
                    <div class="form-group">
                        <label>Old Password</label>
                        <div class="input-group">
                          <input id="old_pass" class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" required>
                             <div class="input-group-append">
                               <span class="input-group-text">
                                  <i id="old_icon" class="fa fa-eye"></i>
                               </span>
                             </div>
                         </div>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <div class="input-group">
                          <input id="new_pass" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required min="8" max="15">
                             <div class="input-group-append">
                               <span class="input-group-text">
                                  <i id="new_icon" class="fa fa-eye"></i>
                               </span>
                             </div>
                         </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <div class="input-group">
                          <input id="confirm_pass" class="form-control" type="password" name="password_confirmation" required>
                             <div class="input-group-append">
                               <span class="input-group-text">
                                  <i id="confirm_icon" class="fa fa-eye"></i>
                               </span>
                             </div>
                         </div>
                    </div>
                      <div class="row">&nbsp;</div>
                    
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                   
                  </form>  
                  
                          
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       
    
@endsection

@section('js')
<script>
document.getElementById('old_icon').onclick = toggleOld;
document.getElementById('confirm_icon').onclick = toggleConfirm;
document.getElementById('new_icon').onclick = toggleNew;

function toggleOld(){
  var old = document.getElementById("old_pass");
    if (old.type === "password") {
      old.type = "text";
      $("#old_icon").attr("class"," fa fa-eye-slash ml-1 account-links");
    } else {
      old.type = "password";
      $("#old_icon").attr("class"," fa fa-eye ml-1 account-links");
    }
}

function toggleConfirm(){
  var confirm = document.getElementById("confirm_pass");
    if (confirm.type === "password") {
      confirm.type = "text";
      $("#confirm_icon").attr("class"," fa fa-eye-slash ml-1 account-links");
    } else {
      confirm.type = "password";
      $("#confirm_icon").attr("class"," fa fa-eye ml-1 account-links");
    }
}

function toggleNew(){
  var newpass = document.getElementById("new_pass");
    if (newpass.type === "password") {
      newpass.type = "text";
      $("#new_icon").attr("class"," fa fa-eye-slash ml-1 account-links");
    } else {
      newpass.type = "password";
      $("#new_icon").attr("class"," fa fa-eye ml-1 account-links");
    }
}
</script>
@endsection