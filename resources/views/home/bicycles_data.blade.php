<?php
$i = 1;
?>
@foreach($products as $product)
@if ($i == 1)
<div class="items">
@endif
    <a href="{{route('viewBicycle', $product->id)}}"><div class="part-sec">					 
        <img src="/storage/{{$product->image1}}" alt=""/>
        <div class="part-info">
            <a href="{{route('viewBicycle', $product->id)}}"><h5>{{$product->title}}<span>₱{{$product->price}}</span></h5></a>
            <a class="add-cart" href="{{route('viewBicycle', $product->id)}}">View Bicycle</a>
            <a class="qck" href="{{route('viewBicycle', $product->id)}}">BUY NOW</a>
        </div>
    </div></a>
<?php
$i++;
?>
@if ($i == 5 || $loop->last)
    <div class="clearfix"></div>
</div>
<?php 
$i = 1;
?>
@endif
@endforeach

