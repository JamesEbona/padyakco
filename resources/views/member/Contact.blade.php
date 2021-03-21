@extends('layouts.member.account')
@section('content')

		 <div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
     <form class="form-horizontal mt-5" method="post" enctype="multipart/form-data" action="/member/contact/send">
			 <h2>Contact Us:<a href="javascript:$('form').submit();" class="account-links"><i class="fas fa-fw fa-paper-plane pull-right"></i></a></h2>
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
               
  <div class="form-group @error('subject') has-error @enderror mt-4">
    <label class="col-sm-2 control-label">Subject</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="subject" value="{{ old('subject') }}" required min="2" max="30">
    </div>

  </div>

  <div class="form-group @error('message') has-error @enderror ">
    <label class="col-sm-2 control-label">Message</label>
    <div class="col-sm-10">
      <textarea rows="5" class="form-control" name="message">{{ old('message') }}</textarea>
    </div>

  </div>
  
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 mt-2">
      <button type="submit" class="btn-update">SEND INQUIRY</button>
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