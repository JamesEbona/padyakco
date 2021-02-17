@extends('layouts.member.account')
@section('content')

		 <div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
     <form class="form-horizontal mt-5" method="post" enctype="multipart/form-data" action="/member/updateprofile">
			 <h2>Update Profile:<a href="javascript:$('form').submit();" class="account-links"><i class="fas fa-fw fa-save pull-right"></i></a></h2>
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
  <div class="form-group @error('first_name') has-error @enderror ">
    <label class="col-sm-3 control-label">First Name</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="first_name" value="@if ($errors->has('first_name')) {{ old('first_name') }} @else {{  auth()->user()->first_name }} @endif " required min="2" max="30">
    </div>

  </div>
  
  
  <div class="form-group  @error('last_name') has-error @enderror">
    <label class="col-sm-3 control-label">Last Name</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" name="last_name" value="@if ($errors->has('last_name')) {{ old('last_name') }} @else {{  auth()->user()->last_name }} @endif" required min="2" max="30"> 
    </div>
   
  </div>
  <div class="form-group @error('email') has-error @enderror">
    <label class="col-sm-3 control-label">E-mail</label>
    <div class="col-sm-9">
    <input type="email" class="form-control" name="email" value="@if ($errors->has('email')) {{ old('email') }} @else {{  auth()->user()->email }} @endif" required max="50">
    </div>
  </div>

  <div class="form-group @error('image') has-error @enderror">
    <label class="col-sm-3 control-label">Avatar (optional)</label>
    <div class="col-sm-9">
    <input type="file" class="form-control" name="image">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 mt-2">
      <button type="submit" class="btn-update">UPDATE PROFILE</button>
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