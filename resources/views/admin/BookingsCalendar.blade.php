@extends('layouts.admin.admin')

@section('css')
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' /> -->
<link href="{{ asset('css/calendar/main.css') }}" rel="stylesheet">
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
                
            ]
        });
        calendar.render();
      });

</script>


@endsection