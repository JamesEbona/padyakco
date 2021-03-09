@extends('layouts.admin.admin')

@section('title')
Padyak.Co Admin - Create Guide
@endsection

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Create Trip Guide</h1>
</div>


<!-- Content Row -->

<div class="row">

  <!-- Area Chart -->
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
     
      <!-- Card Body -->
      <div class="card-body">
      <div class="mt-2 ml-2 mr-2 mb-4">
        <form  method="post" id="submitform" enctype="multipart/form-data" action="{{ route('guide.store') }}" >
      @CSRF
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
        <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Title</label>
              <input class="form-control @error('title') is-invalid @enderror"  type="text" name="title" required>
          </div>
          </div>
          </div>
          <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Author</label>
              <input class="form-control @error('author') is-invalid @enderror"  type="text" name="author" required>
          </div>
          </div>
          </div>
          <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Category</label>
              <select class="form-control @error('category_id') is-invalid @enderror"  name="category_id" required>
               @foreach($categories as $category)
               <option value="{{$category->id}}">{{$category->title}}</option>
               @endforeach
              </select>
          </div>
          </div>
          </div>
          <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Short Description</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
          </div>
          </div>
          </div>
          <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Thumbnail</label>
              <input class="form-control @error('thumbnail') is-invalid @enderror"  type="file" name="thumbnail" required>
          </div>
          </div>
          </div>
          <div class="row">
        <div class="col-md-12">
       <div class="form-group">
              <label>Content</label>
              <textarea name="content" id="editor"></textarea>
          </div>
          </div>
          </div>
        
            <div class="row">&nbsp;</div>
            <button type="submit" class="btn btn-primary">Create</button>
         
        </form>  
           </div>     
      </div>
    </div>
  </div>

 
</div>


</div>
<!-- /.container-fluid -->       


@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        filebrowserUploadUrl: "{{route('guide.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form', 
    });


    // $(document).ready(function(){

    //     $('body').on('submit', '#submitform', function(e){
    //         e.preventDefault();

    //         $.ajax({
    //             url: $(this).attr('action'),
    //             data: new FormData(this),
    //             type: 'POST',
    //             contentType: false,
    //             cache: false,
    //             processData: false,
    //             success: function(data){
    //                 alert(data.msg);
    //             }
    //         });
    //     });
    // });

</script>
@endsection