@extends('layouts.member.account')
@section('content')

		 <div class="col-md-9 cart-items my-account-content" style="border-left: 1px solid; padding-left: 16px; ">
     <form class="form-horizontal mt-5" method="post" action="/member/updateaddress">
			 <h2>Update Delivery Details:<a href="javascript:$('form').submit();" class="account-links"><i class="fas fa-fw fa-save pull-right"></i></a></h2>
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
          <option value="Agusan del Norte">Agusan del Norte</option>
          <option value="Agusan del Sur">Agusan del Sur</option>
          <option value="Aklan">Aklan</option>
          <option value="Albay">Albay</option>
          <option value="Antique">Antique</option>
          <option value="Apayao">Apayao</option>
          <option value="Aurora">Aurora</option>
          <option value="Basilan">Basilan</option>
          <option value="Bataan">Bataan</option>
          <option value="Batanes">Batanes</option>
          <option value="Batangas">Batangas</option>
          <option value="Benguet">Benguet</option>
          <option value="Biliran">Biliran</option>
          <option value="Bohol">Bohol</option>
          <option value="Bukidnon">Bukidnon</option>
          <option value="Bulacan">Bulacan</option>
          <option value="Cagayan">Cagayan</option>
          <option value="Camarines Norte">Camarines Norte</option>
          <option value="Camarines Sur">Camarines Sur</option>
          <option value="Camiguin">Camiguin</option>
          <option value="Capiz">Capiz</option>
          <option value="Catanduanes">Catanduanes</option>
          <option value="Cavite">Cavite</option>
          <option value="Cebu">Cebu</option>
          <option value="Cotabato">Cotabato</option>
          <option value="Davao Occidental">Davao Occidental</option>
          <option value="Davao Oriental">Davao Oriental</option>
          <option value="Davao de Oro">Compostela Valley</option>
          <option value="Davao del Norte">Davao del Norte</option>
          <option value="Davao del Sur">Davao del Sur</option>
          <option value="Dinagat Islands">Dinagat Islands</option>
          <option value="Eastern Samar">Eastern Samar</option>
          <option value="Guimaras">Guimaras</option>
          <option value="Ifugao">Ifugao</option>
          <option value="Ilocos Norte">Ilocos Norte</option>
          <option value="Ilocos Sur">Ilocos Sur</option>
          <option value="Iloilo">Iloilo</option>
          <option value="Isabela">Isabela</option>
          <option value="Kalinga">Kalinga</option>
          <option value="La Union">La Union</option>
          <option value="Laguna">Laguna</option>
          <option value="Lanao del Norte">Lanao del Norte</option>
          <option value="Lanao del Sur">Lanao del Sur</option>
          <option value="Leyte">Leyte</option>
          <option value="Maguindanao">Maguindanao</option>
          <option value="Marinduque">Marinduque</option>
          <option value="Masbate">Masbate</option>
          <option value="Metro Manila">Metro Manila</option>
          <option value="Misamis Occidental">Misamis Occidental</option>
          <option value="Misamis Oriental">Misamis Oriental</option>
          <option value="Mountain Province">Mountain</option>
          <option value="Negros Occidental">Negros Occidental</option>
          <option value="Negros Oriental">Negros Oriental</option>
          <option value="Northern Samar">Northern Samar</option>
          <option value="Nueva Ecija">Nueva Ecija</option>
          <option value="Nueva Vizcaya">Nueva Vizcaya</option>
          <option value="Occidental Mindoro">Occidental Mindoro</option>
          <option value="Oriental Mindoro">Oriental Mindoro</option>
          <option value="Palawan">Palawan</option>
          <option value="Pampanga">Pampanga</option>
          <option value="Pangasinan">Pangasinan</option>
          <option value="Quezon">Quezon</option>
          <option value="Quirino">Quirino</option>
          <option value="Rizal">Rizal</option>
          <option value="Romblon">Romblon</option>
          <option value="Samar">Samar</option>
          <option value="Sarangani">Sarangani</option>
          <option value="Siquijor">Siquijor</option>
          <option value="Sorsogon">Sorsogon</option>
          <option value="South Cotabato">South Cotabato</option>
          <option value="Southern Leyte">Southern Leyte</option>
          <option value="Sultan Kudarat">Sultan Kudarat</option>
          <option value="Sulu">Sulu</option>
          <option value="Surigao del Norte">Surigao del Norte</option>
          <option value="Surigao del Sur">Surigao del Sur</option>
          <option value="Tarlac">Tarlac</option>
          <option value="Tawi-Tawi">Tawi-Tawi</option>
          <option value="Zambales">Zambales</option>
          <option value="Zamboanga Sibugay">Zamboanga Sibugay</option>
          <option value="Zamboanga del Norte">Zamboanga del Norte</option>
          <option value="Zamboanga del Sur">Zamboanga del Sur</option>
          </select>
    </div>
  </div>
  <div class="form-group @error('phone_number') has-error @enderror">
    <label class="col-sm-3 control-label">Phone Number</label>
    <div class="col-sm-9">
    <input type="tel" class="form-control" name="phone_number" value="@if($errors->any()){{ old('phone_number')}}@elseif(auth()->user()->address->phone_number != NULL){{auth()->user()->address->phone_number}}@endif" required>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 mt-2">
      <button type="submit" class="btn-update">UPDATE ADDRESS</button>
    </div>
  </div>
</form>
<div  style="margin-top: 65px;"></div>
				  </div>
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



