@section('title')
Padyak.Co - Book Mechanic
@endsection

@extends('layouts.member.general')
@section('content')
<div class="cart" >
	 <div class="container style="min-height:160vh"">
		 <div class="col-md-9 cart-items" style="border-right: 1px solid; padding-right: 16px; ">
			 <h1 class="mb-3">Book Mechanic</h1>
			 <div class="cart-header">
				 <div class="cart-sec">
                    <form  method="post" action="{{route('bookProcess')}}">
                    @csrf
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
                        <div class="form-group @error('location') has-error @enderror @error('region') has-error @enderror">
                            <label>Location</label>
                            <input id="searchInput" class="controls mt-3 form-control" type="text" placeholder="Enter your location">
                            <div id="map" style="height:300px;"></div>
                            <input type="hidden" name="memberId" value="{{auth()->id()}}">
                            <input type="hidden" id="location" name="location">
                            <input type="hidden" id="city" name="city">
                            <input type="hidden" id="region" name="region">
                            <input type="hidden" id="lng" name="longhitude">
                            <input type="hidden" id="lat" name="latitude">
                        </div>
                        <div class="form-group @error('booking_time') has-error @enderror">
                            <label>Date and time</label><br>
                            <input type="datetime-local"  min="{{$minDate}}" max="{{$maxDate}}" value="@if($errors->any()){{old('booking_time')}}@else{{$minDate}}@endif" name="booking_time"  class="form-control" required>
                        </div>
                        <div class="form-group  @error('repair_type') has-error @enderror">
                            <label>Type of repair</label><br>
                            <select class="form-control" name="repair_type" id="repair_type">
                                <option value="Basic">Basic</option>
                                <option value="Expert">Expert</option>
                                <option value="Upgrade">Upgrade</option>
                            </select>
                        </div>
                        <div class="form-group @error('phone_number') has-error @enderror">
                            <label>Phone Number</label><br>
                            <input type="tel" class="form-control" name="phone_number" value="@if($errors->any()){{ old('phone_number')}}@elseif(auth()->user()->address->phone_number != NULL){{auth()->user()->address->phone_number}}@endif" required>
                        </div>
                        <div class="form-group  @error('notes') has-error @enderror">
                            <label>Notes to mechanic</label><br>
                            <textarea class="form-control" name="notes" rows="4">@if($errors->any()){{ old('notes')}}@endif</textarea>
                        </div>       
                 </div>
             </div>	
		 </div>
		  
		 <div class="col-md-3 cart-total">
             <button class=" btn btn-continue" type="submit" >Book</button>
             </form>
			 <div class="price-details">
				 <h3>Price Estimate Details</h3>
				 <span>Initial repair fee</span>
				 <span id="initial_fee" class="total">₱ {{number_format($repair->basic_fee,2)}}</span>
				 <span>Transportation fee</span>
				 <span id="transportation_fee" class="total">₱ 0.00</span>
                 <!-- <span>Discount</span>
				 <span class="total">---</span> -->
				 <div class="clearfix"></div>				 
			 </div>	
			 <h4 class="last-price">TOTAL</h4>
			 <span id="total_fee" class="total final">₱ {{number_format($repair->basic_fee,2)}}</span>
			 <div class="clearfix"></div>
			
			 <!-- <div class="total-item">
				 <h3>OPTIONS</h3>
				 <h4>COUPONS</h4>
				 <a class="cpns" href="#">Apply Coupons</a>
			 </div> -->
             <div class="total-item">
				 <h3>REMINDERS</h3>
				 <P>This estimate is an approximation and is not guaranteed. 
                    The estimate is based on information provided from the member regarding 
                    the location and type of repair. Actual cost may change once the repair is accomplished
                    . Prior to any changes of cost, the member will be notified.</p>
			 </div>
			</div>
	
	 </div>
</div>

<script> 
var repair_fee = {{$repair->basic_fee}};
var transportation_fee = 0;
var total_fee = 0;

 function initMap() {
    var latlng = new google.maps.LatLng(14.6091,121.0223);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 9,
      restriction: {
      latLngBounds: {
        east: 122.92314,
        north: 15.04208,
        south: 13.90755,
        west: 119.46245
      },
      strictBounds: true
	  },
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var metroBounds = new google.maps.LatLngBounds(
	new google.maps.LatLng(14.34900, 120.93049),
	new google.maps.LatLng(14.788359, 121.13486));

    var autocomplete = new google.maps.places.Autocomplete(input, {
	  componentRestrictions: {country: 'ph'},
      bounds: metroBounds,
      strictBounds: true,
     });
    // autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Location not found!");
            return;
        }
  
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(1);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(place.address_components,place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {        
              bindDataToForm(results[0].address_components,results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}

function bindDataToForm(address_components,address,lat,lng){
   
    for (var i = 0; i < address_components.length; i++) {
            if(address_components[i].types[0] == 'locality'){
				var city = address_components[i].long_name;
				if(city == 'Caloocan'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->caloocan_fee}}';
                    transportation_fee = {{$repair->caloocan_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Malabon'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->malabon_fee}}';
                    transportation_fee = {{$repair->malabon_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Navotas'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->navotas_fee}}';
                    transportation_fee = {{$repair->navotas_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Valenzuela'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->valenzuela_fee}}';
                    transportation_fee = {{$repair->valenzuela_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Quezon City'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->quezon_fee}}';
                    transportation_fee = {{$repair->quezon_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Marikina'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->marikina_fee}}';
                    transportation_fee = {{$repair->marikina_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Pasig'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->pasig_fee}}';
                    transportation_fee = {{$repair->pasig_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Taguig'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->taguig_fee}}';
                    transportation_fee = {{$repair->taguig_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Makati'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->makati_fee}}';
                    transportation_fee = {{$repair->makati_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Mandaluyong'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->mandaluyong_fee}}';
                    transportation_fee = {{$repair->mandaluyong_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'San Juan'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->sanjuan_fee}}';
                    transportation_fee = {{$repair->sanjuan_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Parañaque'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->paranaque_fee}}';
                    transportation_fee = {{$repair->paranaque_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Las Piñas'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->laspinas_fee}}';
                    transportation_fee = {{$repair->laspinas_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Muntinlupa'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->muntinlupa_fee}}';
                    transportation_fee = {{$repair->muntinlupa_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}
				else if(city == 'Manila'){
					document.getElementById('transportation_fee').innerHTML = '₱ {{$repair->manila_fee}}';
                    transportation_fee = {{$repair->manila_fee}};
                    total_fee = transportation_fee + repair_fee;
                    document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
				}


                document.getElementById('city').value = address_components[i].long_name;
            }
            if(address_components[i].types[0] == 'administrative_area_level_1'){
                document.getElementById('region').value = address_components[i].long_name;
            }


   document.getElementById('searchInput').value = address;
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
}


$('select[id="repair_type"]').change(function(){

 if ($(this).val() == "Basic"){
      document.getElementById('initial_fee').innerHTML = '₱ {{$repair->basic_fee}}';
      repair_fee = {{$repair->basic_fee}};
      total_fee = transportation_fee + repair_fee;
      document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
 }
 if ($(this).val() == "Expert"){
     document.getElementById('initial_fee').innerHTML = '₱ {{$repair->expert_fee}}';
     repair_fee = {{$repair->expert_fee}};
     total_fee = transportation_fee + repair_fee;
     document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
 }   
 if ($(this).val() == "Upgrade"){
     document.getElementById('initial_fee').innerHTML = '₱ {{$repair->upgrade_fee}}';
     repair_fee = {{$repair->upgrade_fee}};
     total_fee = transportation_fee + repair_fee;
     document.getElementById('total_fee').innerHTML = '₱ '+total_fee;
 }           
})
</script>

@endsection
