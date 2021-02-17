@extends('layouts.member.general')
@section('content')
<style>
#loading
{
 text-align:center; 
 background: url('loader.gif') no-repeat center; 
 height: 150px;
}
</style>
<div class="parts">
	 <div class="container">
		 <h2>BICYCLES</h2>
		 <div class="bike-parts-sec">
		      <div class="bike-parts">
				 <div class="top">
					 <ul>
						 <li><a href="/">HOME</a></li>
						 <li>/</li>
						 <li><a href="/bicycles">BICYCLES</a></li>
					 </ul>				 
				 </div>
				 <div class="bike-apparels filter_data">
				      @include('home.bicycles_data')
					  <div class="row text-center mt-5 mb-5">
			 {{ $products->links() }}
			 <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                     </div>
				 </div>
			 </div>
			 <div class="rsidebar span_1_of_left">
			 <section class="sky-form">
						<h4>Bicycle Type</h4>
							<div class="row row-type">
							     @foreach ($subcategories as $subcategory)
								 <div class="col col-4">
								<label><input type="checkbox" class="common_selector bicycle_type" name="checkbox" value="{{$subcategory->id}}" checked>&nbsp;&nbsp;&nbsp;&nbsp;{{$subcategory->title}}</label>
                                 </div>	
								 <!-- <input type="hidden" name="hidden_{{$subcategory->title}}" id="hidden_{{$subcategory->title}}" value="1" /> -->
								 @endforeach
							</div>
				   </section>	
				   <section  class="sky-form">
						<h4>Price</h4>
							<div class="row row1 scroll-pane">
								<div class="col col-4">
								<div class="form-check">
								<input class="form-check-input common_selector price" type="radio" name="price" id="priceRadio1" value="10000">
								<label class="form-check-label" for="priceRadio1">
								    ₱10,000 and under
								</label>
								</div>
								<div class="form-check">
								<input class="form-check-input common_selector price" type="radio" name="price" id="priceRadio2" value="20000">
								<label class="form-check-label" for="priceRadio2">
								    ₱20,000 and under
								</label>
								</div>
								<div class="form-check">
								<input class="form-check-input common_selector price" type="radio" name="price" id="priceRadio3" value="30000">
								<label class="form-check-label" for="priceRadio3">
							    	₱30,000 and under
								</label>
								</div>
								<div class="form-check">
								<input class="form-check-input common_selector price" type="radio" name="price" id="priceRadio4" value="50000">
								<label class="form-check-label" for="priceRadio4">
							        ₱50,000 and under
								</label>
								</div>
								<div class="form-check">
								<input class="form-check-input common_selector price" type="radio" name="price" id="priceRadio5" value="100000" checked>
								<label class="form-check-label" for="priceRadio5">
								    ₱100,000 and under
								</label>
								</div>
								</div>
							</div>
				   </section>		 	
				 <section  class="sky-form">
						<h4>Brand</h4>
							<div class="row row1 scroll-pane">
							      @foreach ($brands as $brand)
								 <div class="col col-4">
								<label><input type="checkbox" name="checkbox" class="common_selector brand" value="{{$brand->brand}}" checked >&nbsp;&nbsp;&nbsp;&nbsp;{{$brand->brand}}</label>
                                 </div>	
								 @endforeach
							</div>
				   </section>		      
				        
			 </div>			 
			 <div class="clearfix"></div>
		 </div>
	  </div>
</div>

<!-- <input type="hidden" name="hidden_page" id="hidden_page" value="1" /> -->
@endsection

@section('js')
<!-- <script src="{{ asset('js/member/filters.js') }}"></script>      -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){

	filter_data(1);

//   $(document).on('click', '.pagination a', function(event){
//   event.preventDefault(); 
//   $('li').removeClass('active');
//    $(this).parent().addClass('active');
//   var page = $(this).attr('href').split('page=')[1];

//   filter_data(page);
//  });


function filter_data(page)
{
	$('.filter_data').html('<div id="loading" style="" ></div>');
	var action = 'fetch_data';
	// var minimum_price = $('#hidden_minimum_price').val();
	// var maximum_price = $('#hidden_maximum_price').val();
	var price = get_filter('price');
	var bicycle_type = get_filter('bicycle_type');
	var brand = get_filter('brand');
	// var ram = get_filter('ram');
	// var storage = get_filter('storage');
	$.ajax({
		url:"bicycles/fetch_data?page="+page,
		method:"POST",
		data:{action:action, subcategory_id:bicycle_type, brand:brand, price:price, page:page},
		success:function(data){
			$('.filter_data').html('');
			$('.filter_data').html(data);
		}
	});
}

function get_filter(class_name)
{
	var filter = [];
	$('.'+class_name+':checked').each(function(){
		filter.push($(this).val());
	});
	return filter;
}

$('.common_selector').click(function(){
	var page = 1;
	filter_data(page);
});

// $('#price_range').slider({
// 	range:true,
// 	min:1000,
// 	max:65000,
// 	values:[1000, 65000],
// 	step:500,
// 	stop:function(event, ui)
// 	{
// 		$('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
// 		$('#hidden_minimum_price').val(ui.values[0]);
// 		$('#hidden_maximum_price').val(ui.values[1]);
// 		filter_data();
// 	}
// });

});

</script>
@endsection
