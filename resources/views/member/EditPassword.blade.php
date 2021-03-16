@extends('layouts.member.account')
@section('content')

		 <div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
     <form class="form-horizontal mt-5" method="post" action="/member/updatepassword">
			 <h2>Change Password:<a href="javascript:$('form').submit();" class="account-links"><i class="fas fa-fw fa-save pull-right"></i></a></h2>
			 <div class="cart-header">
				
				 <div class="cart-sec">
         @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="ml-4">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
               
                 @CSRF
                @method('PATCH')
  <div class="form-group @error('old_password') has-error @enderror ">
    <label class="col-sm-3 control-label">Current Password</label>
    <div class="col-sm-9">
      <input type="password" id="old_pass" class="form-control" name="old_password" placeholder="Current Password" required>
    <i id="old_icon" class="fa fa-eye ml-1 account-links"  aria-hidden="true"></i>
    </div>
  </div>
  
  
  <div class="form-group  @error('password') has-error @enderror">
    <label class="col-sm-3 control-label">New Password</label>
    <div class="col-sm-9">
      <input type="password" id="new_pass" class="form-control" name="password" placeholder="New Password" required min="8" max="15">
     <i id="new_icon" class="fa fa-eye ml-1 account-links"  aria-hidden="true"></i>
    </div>
   
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Confirm New Password</label>
    <div class="col-sm-9">
      <input type="password" id="confirm_pass" class="form-control"  name="password_confirmation" placeholder="Confirm New Password" required>
      <i id="confirm_icon" class="fa fa-eye ml-1 account-links"  aria-hidden="true"></i>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 mt-2">
      <button type="submit" class="btn-update">UPDATE PASSWORD</button>
    </div>
  </div>
</form>
<div  style="margin-top: 65px;"></div>
				  </div>
			 </div>
			
		 </div>
	
		
		 
	
	 </div>
				</div>

<!---->
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