@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
          </div>


          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
               
                <!-- Card Body -->
                <div class="card-body">
                  <form  method="post" enctype="multipart/form-data" action="/admin/updateUser" >
                @CSRF
                @method('PATCH')
                  <div class="form-group">
                <div class="row justify-content-center">
              <a href="/storage/{{auth()->user()->image}}" target="_blank">   
              <img src="/storage/{{auth()->user()->image}}" alt="" class="rounded-circle w-100" style="max-width: 100px;">
            </a>
            </div>
            </div>
            @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
        </div>
      @endif
            @if ($errors->any())
              <div class="alert alert-danger">
               <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                   @endforeach
              </ul>
              </div>
            @endif
              
                 <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" value="@if ($errors->has('first_name')) {{ old('first_name') }} @else {{  auth()->user()->first_name }} @endif " required min="2" max="30">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" value="@if ($errors->has('last_name')) {{ old('last_name') }} @else {{  auth()->user()->last_name }} @endif" required min="2" max="30" >
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="@if ($errors->has('email')) {{ old('email') }} @else {{  auth()->user()->email }} @endif" required max="50">
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    </div>
                      <div class="row">&nbsp;</div>
                    
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                   
                  </form>  
                          
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       
      

    



@endsection