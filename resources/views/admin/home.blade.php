@extends('layouts.admin.admin')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/chartjs/Chart.min.css') }}"/>
@endsection
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Number of Members</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $member_count }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-address-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pending Store Orders</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending_orders_count }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-store fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Repair Bookings</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $pending_bookings_count }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-tools fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Inquiries</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$inquiries_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">SALES BY PRODUCT TYPE</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="productCategoryChart"></canvas>   
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6">
              <div class="card shadow">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">BOOKINGS BY REPAIR CATEGORY</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="bookingCategoryChart"></canvas> 
                </div>
              </div>
            </div>

           
          </div>

        
          <div class="row mt-4">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 flex-row">
                <div class="col-md-8 float-left">
                  <h6 class="m-0 font-weight-bold text-primary mt-2">TOTAL SALES</h6>
                  </div>
                 
                  <div class="col-md-2 col-sm-3 float-right">
                  <select class="form-control" id="sales_order">
                     <option value="daily" selected>Daily</option>
                     <option value="monthly">Monthly</option>
                     <option value="yearly">Yearly</option>
                  </select>
                  </div>
                  <div class="col-md-2 col-sm-3 float-right">
                  <select class="form-control" id="sales_type">
                     <option selected value="store">Store</option>
                     <option value="repair">Repair Service</option>
                  </select>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" id="sales">
                <canvas id="salesChart" ></canvas>  
                </div>
              </div>
            </div>
        
            </div>

         
        </div>
      <!-- /.container-fluid -->
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
<script src="{{ asset('js/chartjs/Chart.min.js') }}" ></script>
<!-- <script src="{{ asset('js/chartjs/chartjs-plugin-colorschemes.min') }}" ></script> -->

<script>

var product = document.getElementById('productCategoryChart');
let labels1 = [@foreach($productCategories as $productCategory)'{{$productCategory->title}}',@endforeach];
let colorHex1 = ['#003f5c', '#ffa600', '#bc5090','#a05195','#f95d6a','#2f4b7c','#d45087','#ff7c43'];

let myChart1 = new Chart(product, {
  type: 'pie',
  data: {
    datasets: [{
      data: [@foreach($productCategories as $productCategory)'{{$productCategory->number}}',@endforeach],
      backgroundColor: colorHex1
    }],
    labels: labels1
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom'
    },
    plugins: {
      datalabels: {
        color: '#fff',
        anchor: 'end',
        align: 'start',
        offset: -10,
        borderWidth: 2,
        borderColor: '#fff',
        borderRadius: 25,
        backgroundColor: (context) => {
          return context.dataset.backgroundColor;
        },
        font: {
          weight: 'bold',
          size: '10'
        },
        formatter: (value) => {
          return value + ' %';
        }
      }
    }
  }
})

var ctx = document.getElementById('bookingCategoryChart');
let labels = ['Basic Repair', 'Expert repair', 'Upgrade'];
let colorHex = ['#003f5c', '#ffa600', '#bc5090'];

let myChart2 = new Chart(ctx, {
  type: 'pie',
  data: {
    datasets: [{
      data: [{{$basic_count}},{{$expert_count}},{{$upgrade_count}}],
      backgroundColor: colorHex
    }],
    labels: labels
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom'
    },
    plugins: {
      datalabels: {
        color: '#fff',
        anchor: 'end',
        align: 'start',
        offset: -10,
        borderWidth: 2,
        borderColor: '#fff',
        borderRadius: 25,
        backgroundColor: (context) => {
          return context.dataset.backgroundColor;
        },
        font: {
          weight: 'bold',
          size: '10'
        },
        formatter: (value) => {
          return value + ' %';
        }
      }
    }
  }
})

$(document).ready(function () {

storeSalesDay();

function storeSalesMonth(){
  var sales = document.getElementById('salesChart');
    var myTimeChart = new Chart(sales, {
      type: 'line',
      data: {
        labels: [@foreach($store_month_sales as $store_month_sale)'{{$store_month_sale->month}}',@endforeach],
        datasets: [{ 
            data: [@foreach($store_month_sales as $store_month_sale){{$store_month_sale->profit}},@endforeach],
            label: "Monthly Store Sales",
            borderColor: "#f95d6a",
            fill: false
          },
        ]
      },
    });
}

function storeSalesYear(){
  var sales = document.getElementById('salesChart');
      var myTimeChart = new Chart(sales, {
        type: 'line',
        data: {
          labels: [@foreach($store_year_sales as $store_year_sale)'{{$store_year_sale->year}}',@endforeach],
          datasets: [{ 
              data: [@foreach($store_year_sales as $store_year_sale){{$store_year_sale->profit}},@endforeach],
              label: " Yearly Store Sales",
              borderColor: "#f95d6a",
              fill: false
            }, 
          ]
        },
      });
}

function storeSalesDay(){
  var sales = document.getElementById('salesChart');
      var myTimeChart = new Chart(sales, {
        type: 'line',
        data: {
          labels: [@foreach($store_day_sales as $store_day_sale)'{{$store_day_sale->day}}',@endforeach],
          datasets: [{ 
              data: [@foreach($store_day_sales as $store_day_sale){{$store_day_sale->profit}},@endforeach],
              label: " Daily Store Sales",
              borderColor: "#f95d6a",
              fill: false
            }, 
          ]
        },
      });
}

function bookingSalesMonth(){
  var sales = document.getElementById('salesChart');
    var myTimeChart = new Chart(sales, {
      type: 'line',
      data: {
        labels: [@foreach($booking_month_sales as $booking_month_sale)'{{$booking_month_sale->month}}',@endforeach],
        datasets: [{ 
            data: [@foreach($booking_month_sales as $booking_month_sale){{$booking_month_sale->profit}},@endforeach],
            label: "Monthly Repair Sales",
            borderColor: "#8e5ea2",
            fill: false
          },
        ]
      },
    });
}

function bookingSalesYear(){
  var sales = document.getElementById('salesChart');
      var myTimeChart = new Chart(sales, {
        type: 'line',
        data: {
          labels: [@foreach($booking_year_sales as $booking_year_sale)'{{$booking_year_sale->year}}',@endforeach],
          datasets: [{ 
              data: [@foreach($booking_year_sales as $booking_year_sale){{$booking_year_sale->profit}},@endforeach],
              label: " Yearly Repair Sales",
              borderColor: "#8e5ea2",
              fill: false
            }, 
          ]
        },
      });
}

function bookingSalesDay(){
  var sales = document.getElementById('salesChart');
      var myTimeChart = new Chart(sales, {
        type: 'line',
        data: {
          labels: [@foreach($booking_day_sales as $booking_day_sale)'{{$booking_day_sale->day}}',@endforeach],
          datasets: [{ 
              data: [@foreach($booking_day_sales as $booking_day_sale){{$booking_day_sale->profit}},@endforeach],
              label: " Daily Repair Sales",
              borderColor: "#8e5ea2",
              fill: false
            }, 
          ]
        },
      });
}


$('#sales_order').on('change', function() {
  var sales_type = $('#sales_type').find(":selected").text();
  
  document.getElementById('sales').innerHTML = "";
  document.getElementById('sales').innerHTML = "<canvas id='salesChart' ></canvas>";

  if(this.value == "monthly"){
    if(sales_type == "Store"){
      storeSalesMonth();
    }
    else{
      bookingSalesMonth();
    }
  } 

  else if(this.value == "yearly"){
    if(sales_type == "Store"){
      storeSalesYear();
    }
    else{
      bookingSalesYear();
    }
  } 

  else if(this.value == "daily"){
    if(sales_type =="Store"){
      storeSalesDay();
    }
    else{
      bookingSalesDay();
    } 
  } 

});

$('#sales_type').on('change', function() {
  var sales_order = $('#sales_order').find(":selected").text();
  
  document.getElementById('sales').innerHTML = "";
  document.getElementById('sales').innerHTML = "<canvas id='salesChart' ></canvas>";

  if(this.value == "store"){
    if(sales_order == "Monthly"){
      storeSalesMonth();
    }
    else if (sales_order == "Yearly"){
      storeSalesYear();
    }
    else if (sales_order == "Daily"){
      storeSalesDay();
    }
  } 

  else if(this.value == "repair"){
    if(sales_order == "Monthly"){
      bookingSalesMonth();
    }
    else if (sales_order == "Yearly"){
      bookingSalesYear();
    }
    else if (sales_order == "Daily"){
      bookingSalesDay();
    }
  } 

});

});
</script>
@endsection
