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
            <div class="form-group ml-2">
                        <label class="font-weight-bold">Name</label>
                        <p>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</p>
                    </div>

                    <div class="form-group ml-2">
                        <label class="font-weight-bold">Email</label>
                        <p>{{auth()->user()->email}}</p>
                    </div>
                    <div class="form-group ml-2">
                        <label class="font-weight-bold">Joined at</label>
                        <p>{{ date('F j, Y', strtotime(auth()->user()->created_at))}}</p>
                    </div>
                          
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       
      

    



@endsection