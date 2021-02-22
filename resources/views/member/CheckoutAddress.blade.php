@section('title')
Padyak.Co - Checkout
@endsection

@extends('layouts.member.general')
@section('content')
<div class="cart" >
	 <div class="container style="min-height:160vh"">
		 <div class="cart-top">
			<a href="{{ route('memberCart') }}">CART / </a>
			<a style="text-decoration: underline;" href="{{ route('checkoutAddress') }}">DELIVERY</a> /
			<a style="color: grey;">REVIEW & PAY /</a>
			<a style="color: grey;">ORDER PLACED</a>
		 </div>	
			
		 <div class="col-md-9 cart-items">
			<h2>Delivery Address</h2>

		    <form class="form-horizontal mt-5" method="post" action="{{ route('saveAddress') }}">
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

			<div class="form-group @error('address1') has-error @enderror ">
    <label class="col-sm-3 control-label">Address 1</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="address1" value="@if($errors->any()){{old('address1')}}@elseif(auth()->user()->address->address1 != NULL){{auth()->user()->address->address1}}@endif" required max="100">
    </div>

  </div>
  
  
  <div class="form-group  @error('address2') has-error @enderror">
    <label class="col-sm-3 control-label">Address 2</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" name="address2" value="@if($errors->any()){{old('address2')}}@elseif(auth()->user()->address->address2 != NULL){{auth()->user()->address->address2}}@endif" max="100"> 
    </div>
   
  </div>
  <div class="form-group @error('postal_code') has-error @enderror">
    <label class="col-sm-3 control-label">Postal Code</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" name="postal_code" value="@if($errors->any()){{old('postal_code')}}@elseif(auth()->user()->address->postal_code != NULL){{auth()->user()->address->postal_code}}@endif" required>
    </div>
  </div>
  <div class="form-group @error('city') has-error @enderror">
    <label class="col-sm-3 control-label">City</label>
    <div class="col-sm-9">
    <input type="text" class="form-control" name="city" value="@if($errors->any()){{old('city')}}@elseif(auth()->user()->address->city != NULL){{auth()->user()->address->city}}@endif" required min="2" max="30">
    </div>
  </div>
  <div class="form-group @error('province') has-error @enderror">
    <label class="col-sm-3 control-label">Province</label>
    <div class="col-sm-9">
          <!-- <select id="address_province_3918575173702" class="address_form" name="address[province]" data-default="Metro Manila"> -->
          <select class="form-control" name="province" id="province">
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
  </div>
  <div class="form-group @error('phone_number') has-error @enderror">
    <label class="col-sm-3 control-label">Phone Number</label>
    <div class="col-sm-9">
    <input type="tel" class="form-control" name="phone_number" value="@if($errors->any()){{ old('phone_number')}}@elseif(auth()->user()->address->phone_number != NULL){{auth()->user()->address->phone_number}}@endif" required>
    </div>
  </div>
		 </div>
		  
		 <div class="col-md-3 cart-total" style="border-left: 1px solid; padding-left: 16px; ">
			 <button class=" btn btn-continue" type="submit" >Review & Pay</button>
       </form>
			 <div class="clearfix"></div>
			 <div class="total-item">
				 <h3>DELIVERY</h3>
                 <p>It will take 1-3 business days ship out your order for delivery. Depending on your delivery address, it will take another 5 to 15 business days for our carrier to deliver the parcel to you.</p>
				 <h3 class="mt-4">ADDRESS</h3>
				 <p>Address will be saved to your account for faster process next time you checkout.</p>
			 </div>
			</div>
            
	 </div>
</div>
@if ($errors->any()) 
<script>
document.getElementById('province').value = '{{old('province')}}';
</script>
@elseif (auth()->user()->address->province != NULL) 
<script>
document.getElementById('province').value = '{{auth()->user()->address->province}}';
</script>
@else 
<script>
document.getElementById('province').value = 'Metro Manila'; 
</script>
@endif
@endsection
