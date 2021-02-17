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
      <input type="password" class="form-control" name="old_password" placeholder="Current Password" required>
    </div>
   
  </div>
  
  
  <div class="form-group  @error('password') has-error @enderror">
    <label class="col-sm-3 control-label">New Password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control" name="password" placeholder="New Password" required min="8" max="15">
    </div>
   
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label">Confirm New Password</label>
    <div class="col-sm-9">
      <input type="password" class="form-control"  name="password_confirmation" placeholder="Confirm New Password" required>
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