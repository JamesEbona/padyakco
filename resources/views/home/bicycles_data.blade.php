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
            <a href="{{route('viewBicycle', $product->id)}}"><h5>{{$product->title}}<span>₱{{number_format($product->price,2)}}</span></h5></a>
            <a class="add-cart" href="{{route('viewBicycle', $product->id)}}">View Bicycle</a>
            @if ($product->quantity != 0)
            <a class="qck" href="{{route('viewBicycle', $product->id)}}">BUY NOW</a>
            @else
            <a class="qck cartDisabled" >SOLD OUT</a>
            @endif
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

