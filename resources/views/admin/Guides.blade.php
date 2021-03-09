@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Trip Guides List</h1>
          </div>
          <!-- Content Row -->
          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">    
                <!-- Card Body -->
                <div class="card-body">
                @if(session()->has('message'))
                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ session()->get('message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                     </div>
                @endif
                <a class="btn btn-primary mb-3" href="{{ route('guide.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Guide</a>
                <div class="table-responsive">
                <table id="guidestable" class="table text-center">
                  <thead>
                      <tr>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Category</th>
                          <th>Created At</th>
                          <th>Updated At</th>
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                 @foreach ($guides as $guide)
                     <tr>
                          <td>{{$guide->title}}</td>
                          <td>{{$guide->author}}</td>
                          <td>{{$guide->category->title}}</td>
                          <td>{{$guide->created_at}}</td>
                          <td>{{$guide->updated_at}}</td>
                          @if($guide->status == "active")
                          <td> <span class="badge badge-success justify-content-center ">{{$guide->status}}</span></td>
                          @else
                          <td> <span class="badge badge-danger">{{$guide->status}}</span></td>
                          @endif
                          <td><div class="row justify-content-center">
                          <a class="btn btn-dark" href="/admin/guides/edit/{{ $guide->id }}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                          @if ($guide->status == 'active')
                          <a class="btn btn-warning ml-2" href="/admin/guides/deactivate/{{ $guide->id }}"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                          @else                        
                          <a class="btn btn-success ml-2" href="/admin/guides/activate/{{ $guide->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>                         
                          @endif                       
                          <button class="btn btn-danger ml-2" data-id="{{$guide->id}}" onclick="deleteGuide(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div> </td>     
                    </tr>
                 @endforeach
                </tbody>
              </table>
              </div>        
            </div>
          </div>
        </div>
     </div>
   </div>
@endsection

@section('modals')
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">A deleted guide cannot be recovered anymore.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteUserButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 
@endsection

@section('js')
<script src="{{ asset('js/admin/modals.js') }}"></script>
@endsection


