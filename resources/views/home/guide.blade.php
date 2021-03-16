@extends('layouts.member.general')
@section('title')
Padyak.Co Guides - {{$guide->title}}
@endsection
@section('content')


<div class="parts">
	 <div class="container">
		
		
			 <div class="row">
			 <div class="col-md-9">
		      <div class="guides-list">
			  <!-- @if(session()->has('message'))
						  <div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Ordered!</strong> {{ session()->get('message') }}
							</div>
                            @endif -->
				 <div class="top mb-4">
					 
					 <ul>
						 <li><a class="account-links" href="/">Home</a></li>
						 <li>/</li>
						 <li><a class="account-links" href="/guides">Trip guides</a></li>
                         <li>/</li>
                         <li><a class="account-links" href="{{route('viewGuide', $guide->id)}}">{{$guide->title}}</a></li>
					 </ul>				 
				 </div>
				 <div class="bike-apparels filter_data">
                     <div class="row ">
                         <div class="col-md-12">
                          <h1>{{$guide->title}}</h1>
                          </div>
                        </div>
                        <div class="row mt-1 mb-5">
                            
                         <div class="col-md-12">
                          <p>By: {{$guide->author}} • {{ date('F j, Y', strtotime($guide->created_at))}}</p>
                          </div>
                        </div>
			     {!!$guide->content!!}	 
				 </div>
			 </div>
</div>
			<div class="col-md-3">
			 <section class="sky-form">
						<h4>Most popular</h4>
                           
							<div class="row row-guide">
                            @foreach($popular_guides as $popular_guide)
                            <a class="account-links" href="{{route('viewGuide', $popular_guide->id)}}">
                            <div class="row">
                            <img class="img-responsive" src="/storage/{{$popular_guide->thumbnail}}" alt="Article Image">
                            </div>
                            <div class="row mt-2 mb-5">
                            <p>{{$popular_guide->title}}</p>
                            </div>
                            </a>
                            @endforeach
							</div>           
				   </section>	
					              
               </div>	
                </div> 
			 <div class="clearfix"></div>
		 </div>

</div>
@endsection