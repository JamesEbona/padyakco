@extends('layouts.admin.admin')

@section('css')
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' /> -->
<link href="{{ asset('css/calendar/main.css') }}" rel="stylesheet">
<style>
.tooltipevent{
    width:200px;/*
    height:100px;*/
    background:#ccc;
    position:absolute;
    z-index:10001;
    transform:translate3d(-50%,-100%,0);
    font-size: 0.8rem;
    box-shadow: 1px 1px 3px 0px #888888;
    line-height: 1rem;
}
.tooltipevent div{
    padding:10px;
}
.tooltipevent div:first-child{
    font-weight:bold;
    color:White;
    background-color:#888888;
    border:solid 1px black;
}
.tooltipevent div:last-child{
    background-color:whitesmoke;
    position:relative;
}
.tooltipevent div:last-child::after, .tooltipevent div:last-child::before{
    width:0;
    height:0;
    border:solid 5px transparent;/*
    box-shadow: 1px 1px 2px 0px #888888;*/
    border-bottom:0;
    border-top-color:whitesmoke;
    position: absolute;
    display: block;
    content: "";
    bottom:-4px;
    left:50%;
    transform:translateX(-50%);
}
.tooltipevent div:last-child::before{
    border-top-color:#888888;
    bottom:-5px;
}
</style>
@endsection


@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">@if(isset($mechanic))Mechanic {{$mechanic->first_name}} {{$mechanic->last_name}}'s @endif Booking Calendar</h1>
          </div>


          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
               
                <!-- Card Body -->
                <div class="card-body"> 
                <div id='calendar'></div> 
                </div>      
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       

@endsection


@section('js')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script> -->
<script src="{{ asset('js/calendar/main.js') }}" ></script>
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },
          nowIndicator: true,
          dayMaxEvents: true,
          themeSystem: 'bootstrap',
          height: 800,
          
          events : [
                @foreach($bookings as $booking)
                {
                    title : '# {{ $booking->id }} @if(isset($mechanic))- {{$booking->location}} @else - {{$booking->mechanic->first_name ?? "Not"}} {{$booking->mechanic->last_name ?? "assigned"}} @endif',
                    description: "Repair Type: {{$booking->repair_type}}",
                    description2: "Member: {{$booking->first_name}} {{$booking->last_name}}",
                    description3: "Location: {{$booking->location}}",
                    start : '{{ $booking->booking_time }}',
                    @if($booking->status == 'confirmed')
                    color: 'purple',
                    @elseif($booking->status == 'en route')
                    color: 'orange',
                    @elseif($booking->status == 'done')
                    color: 'green',
                    @elseif($booking->status == 'cancelled')
                    color: 'red',
                    @endif 
                },
                @endforeach
                
            ],
            eventMouseEnter: function(info) {
            var tis=info.el;
            var popup=info.event;
            var tooltip = '<div class="tooltipevent" style="top:'+($(tis).offset().top-5)+'px;left:'+($(tis).offset().left+($(tis).width())/2)+'px"><div>Booking ' + popup.title + '</div><div style="background-color:whitesmoke;">' + popup.extendedProps.description + '</div><div style="background-color:whitesmoke;">' + popup.extendedProps.description2 +  @if(!isset($mechanic))'</div><div style="background-color:whitesmoke;">' + popup.extendedProps.description3 +@endif '</div></div>';
            var $tooltip = $(tooltip).appendTo('body');

//            If you want to move the tooltip on mouse movement then you can uncomment it
//            $(tis).mouseover(function(e) {
//                $(tis).css('z-index', 10000);
//                $tooltip.fadeIn('500');
//                $tooltip.fadeTo('10', 1.9);
//            }).mousemove(function(e) {
//                $tooltip.css('top', e.pageY + 10);
//                $tooltip.css('left', e.pageX + 20);
//            });
},

eventMouseLeave: function(info) {
  console.log('eventMouseLeave');
            $(info.el).css('z-index', 8);
            $('.tooltipevent').remove();
},
           
        });
        calendar.render();

      

        
      });

</script>


@endsection