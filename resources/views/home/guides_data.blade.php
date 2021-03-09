@foreach($guides as $guide)
<div class="card mb-4">
           <a href="{{route('viewGuide', $guide->id)}}">
          <img class="card-img-top" src="/storage/{{$guide->thumbnail}}" width="750" height="250" alt="Article Image">
           </a>
          <div class="card-body">
            <h3 class="card-title">{{$guide->title}}</h3>
            <p class="card-text">{{$guide->description}}</p>
            <a href="{{route('viewGuide', $guide->id)}}" class="btn btn-info mt-4">Read More &rarr;</a>
          </div>
          <div class="card-footer text-muted">
            Posted on {{ date('F j, Y', strtotime($guide->created_at))}} by
            <a >{{$guide->author}}</a>
          </div>
        </div>
@endforeach

