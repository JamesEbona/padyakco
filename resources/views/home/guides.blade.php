@extends('layouts.member.general')
@section('tite')
Padyak.Co - Trip Guides
@endsection
@section('content')
<div class="parts">
	 <div class="container">
		 <h1>TRIP GUIDES</h1>
		 <div class="bike-parts-sec">
			 <div class="row">
			 <div class="col-md-8">
		      <div class="guides-list">
			  <!-- @if(session()->has('message'))
						  <div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Ordered!</strong> {{ session()->get('message') }}
							</div>
                            @endif -->
				 <div class="top mb-4">
					 
					 <ul>
						 <li><a href="/">HOME</a></li>
						 <li>/</li>
						 <li><a href="/guides">TRIP GUIDES</a></li>
					 </ul>				 
				 </div>
				 <div class="bike-apparels filter_data">
				 @include('home.guides_data')
					  <div class="row text-center mt-5 mb-5">
			 {{ $guides->links() }}
			 <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                     </div>
				 </div>
			 </div>
</div>
			<div class="col-md-4">
			 <section class="sky-form">
						<h4>Category</h4>
							<div class="row row-type">
							     @foreach ($categories as $category)
								 <div class="col col-4">
								<label><input type="checkbox" class="common_selector category" name="checkbox" value="{{$category->id}}" checked>&nbsp;&nbsp;&nbsp;&nbsp;{{$category->title}}</label>
                                 </div>	
							
								 @endforeach
							</div>
				   </section>	
				 <section  class="sky-form">
						<h4>Author</h4>
							<div class="row row1 scroll-pane">
							      @foreach ($authors as $author)
								 <div class="col col-4">
								<label><input type="checkbox" name="checkbox" class="common_selector author" value="{{$author->author}}" checked >&nbsp;&nbsp;&nbsp;&nbsp;{{$author->author}}</label>
                                 </div>	
								 @endforeach
							</div>
				   </section>		              
               </div>	
                </div> 
			 <div class="clearfix"></div>
		 </div>
	  </div>
</div>

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

function filter_data(page)
{
	$('.filter_data').html('<div id="loading" style="" ></div>');
	var action = 'fetch_data';
	var category_id = get_filter('category');
	var author = get_filter('author');
	$.ajax({
		url:"guides/fetch_data?page="+page,
		method:"POST",
		data:{action:action, category_id:category_id, author:author, page:page},
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

});

</script>
@endsection