@extends('layouts.mechanic.mechanic')

@section('title')
Padyak.Co Mechanic - View Profile
@endsection
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Profile</h1>
          </div>


          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
               
                <!-- Card Body -->
                <div class="card-body">
                  <div class="form-group">
                <div class="row justify-content-center">
                   <a href="/storage/{{auth()->user()->image}}" target="_blank">   
              <img src="/storage/{{auth()->user()->image}}" alt="" class="rounded-circle w-100" style="max-width: 100px;">
            </a>
            </div>
            </div>
                 <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" type="text" value="{{auth()->user()->first_name}} {{auth()->user()->last_name}}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" value="{{auth()->user()->email}}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Joined at</label>
                        <input class="form-control" type="text" value="{{ date('F j, Y', strtotime(auth()->user()->created_at))}}"  disabled>
                    </div>
                          
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       
      

    



@endsection