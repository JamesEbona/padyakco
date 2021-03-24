<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/member/padyak_logo.png') }}" />
    <title>Padyak.Co - Admin</title>
   
 <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/datatable.css') }}"/>
 
  

    <!-- Custom fonts for this template-->
  <link href="{{ asset('css/admin/all.min.css') }}" rel="stylesheet" type="text/css"> 
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <style>
    #description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}

#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

.pac-card {
  margin: 10px 10px 0 0;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  background-color: #fff;
  font-family: Roboto;
}

#pac-container {
  padding-bottom: 12px;
  margin-right: 12px;
}

div.pac-container {
   z-index: 1050 !important;
}

.pac-controls {
  display: inline-block;
  padding: 5px 11px;
}

.pac-controls label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

#searchInput {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 400px;
}

#searchInput:focus {
  border-color: #4d90fe;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}

#target {
  width: 345px;
}

    .table-image {
      height: 3rem; 
      width: 3rem;
    }

    .account-links:hover{
	color: #f95c11;
	background-color: transparent;
}
    </style>
    
    <link href="{{ asset('css/admin/sb-admin-2.min.css') }}" rel="stylesheet">
    @yield('css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
       
        <img src="{{ asset('images/member/padyak_logo.png') }}" height="50" width="50" alt=""/>
     
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

     
     <!-- Nav Item - Dashboard -->
      <li class="nav-item {{{ (Route::current()->getName() == "adminDashboard" ? 'active' : '') }}}">
        <a class="nav-link" href="/admin">
          <i class="fa fa-columns"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      

       @if (auth()->user()->role == 1) 
      <!-- Heading -->
      <div class="sidebar-heading">
        Users
      </div>

  
            <li class="nav-item {{{ (Route::current()->getName() == "memberUsers" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('memberUsers')}}">
          <i class="fas fa-fw fa-address-book"></i>
          <span>Members</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "adminUsers" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('adminUsers')}}">
          <i class="fas fa-fw fa-user-shield"></i>
          <span>Admins</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "mechanicUsers" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('mechanicUsers')}}">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Mechanics</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">
      @endif

      <!-- Heading -->
      <div class="sidebar-heading">
        STORE
      </div>

  
            <li class="nav-item {{{ (Route::current()->getName() == "products" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('products')}}">
          <i class="fas fa-fw fa-bicycle"></i>
          <span>Products</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "categories" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('categories')}}">
          <i class="fas fa-fw fa-folder-open"></i>
          <span>Categories</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "subCategories" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('subCategories')}}">
          <i class="fas fa-fw fa-folder"></i>
          <span>Sub Categories</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "couriers" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('couriers')}}">
          <i class="fas fa-fw fa-shipping-fast"></i>
          <span>Logistic Partners</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "adminOrders" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('adminOrders')}}">
          <i class="fas fa-fw fa-receipt"></i>
          <span>Orders</span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        REPAIR SERVICE
      </div>

      <li class="nav-item {{{ (Route::current()->getName() == "adminBookings" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('adminBookings')}}">
          <i class="fas fa-fw fa-calendar"></i>
          <span>Bookings</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "adminBookingsCalendar" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('adminBookingsCalendar')}}">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span>Calendar</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "adminPrices" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('adminPrices')}}">
          <i class="fas fa-fw fa-tags"></i>
          <span>Prices</span></a>
      </li>

       <!-- Divider -->
     <hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  VOUCHERS
</div>



<li class="nav-item {{{ (Route::current()->getName() == "coupons.index" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('coupons.index')}}">
          <i class="fas fa-fw fa-percent"></i>
          <span>Coupons</span></a>
      </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  CYCLING TRIP GUIDE
</div>



<li class="nav-item {{{ (Route::current()->getName() == "guide.index" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('guide.index')}}">
          <i class="fas fa-fw fa-map"></i>
          <span>Guides</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "guide.create" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('guide.create')}}">
          <i class="fas fa-fw fa-plus-square"></i>
          <span>Create Guide</span></a>
      </li>

      <li class="nav-item {{{ (Route::current()->getName() == "guideCategories" ? 'active' : '') }}}">
        <a class="nav-link" href="{{route('guideCategories')}}">
          <i class="fas fa-fw fa-folder-open"></i>
          <span>Categories</span></a>
      </li>

       <!-- Divider -->
     <hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  INQUIRIES
</div>


<li class="nav-item {{{ (Route::current()->getName() == "inquiries" ? 'active' : '') }}}">
  <a class="nav-link" href="{{route('inquiries')}}">
    <i class="fas fa-fw fa-envelope"></i>
    <span>Manage</span></a>
</li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) 
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
      -->

    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

     

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <!-- <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a> -->
              <!-- Dropdown - Messages -->
              <!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li> -->


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  @if (auth()->user()->is_superadmin == 1)
                  Super Admin
                  @else
                  Admin
                  @endif
                  {{ Auth::user()->first_name }}</span>
                <img class="img-profile rounded-circle" src="/storage/{{ Auth::user()->image }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/admin/viewUser">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  View Profile
                </a>
                <a class="dropdown-item" href="/admin/editUser">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Edit Profile
                </a>
                <a class="dropdown-item" href="/admin/changePassword">
                  <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>
         
        </nav>
         <!-- Main Content -->
      <div id="content">
        <!-- End of Topbar -->

            @yield('content')

     <!-- Footer 
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; FightCovidPH 2020</span>
          </div>
        </div>
      </footer>
      End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
 
     <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}</a>
                                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
        </div>
      </div>
    </div>
  </div> 

  @yield('modals')


<!-- Scripts -->
    <script src="{{ asset('js/admin/jquery.min.js') }}" ></script>
    <script src="{{ asset('js/admin/bootstrap.bundle.min.js') }}" ></script>
    <script src="{{ asset('js/admin/jquery.easing.min.js') }}" ></script>
    <script src="{{ asset('js/admin/sb-admin-2.min.js') }}" ></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/b-1.6.5/b-html5-1.6.5/b-print-1.6.5/r-2.2.7/datatables.min.js"></script>

 
<script>
$('#memberstable').DataTable( {
  order: [[6, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: [0,8] }
  ]
} );

$('#adminstable').DataTable( {
  order: [[4, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: [0,6] }
  ]
} );

$('#mechanicstable').DataTable( {
  order: [[5, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: [0,7] }
  ]
} );

   $('#producttable').DataTable( {
  columnDefs: [
    {searchable: false, orderable: false, targets: [1,10] }
  ]
} );

$('#categorytable').DataTable( {
  columnDefs: [
    {searchable: false,  orderable: false, targets: 4 }
  ]
  
} );

$('#guidecategorytable').DataTable( {
  columnDefs: [
    {searchable: false,  orderable: false, targets: 2 }
  ]
  
} );

$('#subcategorytable').DataTable( {
  columnDefs: [
    {searchable: false, orderable: false, targets: 4 }
  ]
} );

$('#orderstable').DataTable( {
  dom: 'lBfrtip',
  order: [[7, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: 9 }
  ],
  buttons: [
            {
           extend: 'print',
           exportOptions: {
           columns: [ 0, 1, 2, 3, 4, 5, 6,7,8 ] 
               }
             },
             {
              extend: 'excel',
              exportOptions: {
              columns: [ 0, 1, 2, 3, 4 ,5, 6,7,8 ] 
             }
           },
           {
              extend: 'pdf',
              exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6,7,8 ] 
             }
           },
         ],
} );

$('#guidestable').DataTable( {
  order: [[3, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: 6}
  ]
} );

$('#inquiriestable').DataTable( {
  order: [[3, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: 5}
  ]
} );

$('#bookingstable').DataTable( {
  
  dom: 'lBfrtip',
  order: [[6, 'desc']],
  columnDefs: [
    {searchable: false, orderable: false, targets: 8 }
  ],
  buttons: [
            {
           extend: 'print',
           exportOptions: {
           columns: [ 0, 1, 2, 3, 4, 5, 6,7] 
               }
             },
             {
              extend: 'excel',
              exportOptions: {
              columns: [ 0, 1, 2, 3, 4 ,5, 6,7] 
             }
           },
           {
              extend: 'pdf',
              exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5, 6,7] 
             }
           },
         ],

} );

$('#courierstable').DataTable( {
  order: [[1, 'asc']],
  columnDefs: [
    {searchable: false,  orderable: false, targets: [0,4] }
  ]
  
} );

$('#couponstable').DataTable( {
  columnDefs: [
    {searchable: false,  orderable: false, targets: 7}
  ]
  
} );

</script>
   @yield('js')
   
</body>
</html>
