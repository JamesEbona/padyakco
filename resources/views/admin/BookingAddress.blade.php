@section('title')
Padyak.Co Admin - View Booking Address
@endsection

@extends('layouts.admin.admin')


@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Booking Address</h1>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
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
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="d-inline">Booking # {{$booking->id}}</h4>
                            @if($booking->status =="pending")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-warning">{{$booking->status}}</span></h4>
                            @elseif($booking->status =="confirmed")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-info">{{$booking->status}}</span></h4>
                            @elseif($booking->status =="en route")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-primary">{{$booking->status}}</span></h4>
                            @elseif($booking->status =="done")
                            <h4 class="d-inline ml-2"><span class="badge badge-pill badge-success">{{$booking->status}}</span></h4>
                            @elseif($booking->status =="cancelled")
                                <h4 class="d-inline ml-2"><span class="badge badge-pill badge-danger">{{$booking->status}}</span></h4>
                            @endif  
                            @if($booking->status != "cancelled" && $booking->status != "done")  
                            <a href="javascript:$('#updateAddressForm').submit();" class="account-links"><h4 class="d-inline"><i class="fas fa-fw fa-save float-right"></i></h4></a>
                            @endif     
                        </div>
                    </div>
                    <div class="row border-bottom mt-3">
                        <div class="col-md-12">
                            <p>Current booking location: {{$booking->location}}</p>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                    <form enctype="multipart/form-data" id="updateAddressForm" method="post" action="{{route('adminBookingUpdateAddress')}}">
                    @method('PATCH')
                    @CSRF
                    <div class="form-group">
                        @if($booking->status != "cancelled" && $booking->status != "done")  
                        <input id="searchInput" class="controls mt-3 form-control" type="text" placeholder="Enter new booking location">
                        @endif
                        <div id="map" style="height:500px;"></div>
                        <input type="hidden" name="booking_id" value="{{$booking->id}}">
                        <input type="hidden" id="location" name="location" value="{{$booking->location}}">
                        <input type="hidden" id="city" name="city">
                        <input type="hidden" id="region" name="region">
                        <input type="hidden" id="lng" name="longhitude">
                        <input type="hidden" id="lat" name="latitude">
                    </div>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>
function initMap() {
  
    var latlng = new google.maps.LatLng({{$booking->latitude}},{{$booking->longhitude}});

  var map = new google.maps.Map(document.getElementById('map'), {
    center: latlng,
    zoom: 16,
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
//     if (navigator.geolocation) {
//      navigator.geolocation.getCurrentPosition(function (position) {
//          initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
//          map.setCenter(initialLocation);
//      });
//  }

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
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRpg8ZlzcJmaK8AYYf3-dPS-DyYnJBiqA&callback=initMap&libraries=places"
    async defer
  ></script>

@endsection