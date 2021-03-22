@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products List</h1>
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

                @if(session()->has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session()->get('error_message') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
        </div>
      @endif
                <button class="btn btn-primary mb-3" onclick="addRow()"><i class="fa fa-plus" aria-hidden="true"></i> Product</button>
                <div class="table-responsive">
                <table id="producttable" class="table text-center">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Image</th>
                          <th>Title</th>
                          <th>Brand</th>
                          <th>Category</th>
                          <th>Sub Category</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <!-- <th>Rating</th> -->
                          <th>Created At</th>
                          <th>Status</th>
                          <th style="column-width:600px;">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                 @foreach ($products as $product)
                     <tr>
                          <td>{{$product->id}}</td>
                          <td class="py-1"><a data-image1="{{$product->image1}}" data-image2="{{$product->image2}}" data-image3="{{$product->image3}}" onclick="viewProductPicture(this);"><img class="img-profile rounded-circle table-image" src="/storage/{{$product->image1}}"></a></td>
                          <td>{{$product->title}}</td>
                          <td>{{$product->brand}}</td>
                          <td>{{$product->category->title}}</td>
                          <td>{{$product->subcategory->title ?? ''}}</td>
                          <td>{{$product->quantity}}</td>
                          <td>{{$product->price}}</td>
                          <!-- <td> <i class="fa fa-star" aria-hidden="true"></i></td> -->
                          <td>{{$product->created_at ?? 'Not Found'}}</td>
                          @if($product->status == "active")
                          <td> <span class="badge badge-success justify-content-center ">{{$product->status}}</span></td>
                          @else
                          <td> <span class="badge badge-danger">{{$product->status}}</span></td>
                          @endif
                          <td><div class="row justify-content-center">
                         
                          <button class="btn btn-dark" data-id="{{$product->id}}" data-title="{{$product->title}}" data-brand="{{$product->brand}}" data-category_id="{{$product->category_id}}"  data-subcategory_id="{{$product->subcategory_id}}" 
                          data-quantity="{{$product->quantity}}" data-price="{{$product->price}}" data-delivery="{{$product->delivery_fee}}" data-provincial="{{$product->provincial_delivery_fee}}"  data-description="{{$product->description}}" data-image1="{{$product->image1}}" data-image2="{{$product->image2}}" onclick="editProduct(this)"
                          data-image3="{{$product->image3}}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        
                          @if ($product->status == 'active')
                        
                          <a class="btn btn-warning ml-2" href="/admin/products/deactivate/{{ $product->id }}"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                       
                          @else
                         
                          <a class="btn btn-success ml-2" href="/admin/products/activate/{{ $product->id }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        
                          @endif
                         
                          <button class="btn btn-danger ml-2" data-id="{{$product->id}}" onclick="deleteProduct(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
                         
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
        <div class="modal-body">A deleted product cannot be recovered anymore.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteUserButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade crud" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_edit_product" action="javascript:void(0)" >
            @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="editId" name="editId">
                <div class="modal-body">
                <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
               <!-- <div class="form-group">
                <div class="row justify-content-center">
                  <a id="viewEditImageLink" target="_blank">
              <img id="viewEditImage" alt="" class="rounded-circle w-100" style="max-width: 200px;">
            </a>
            </div>
            </div> -->
            <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <div id="productEditCarousel" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#productEditCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#productEditCarousel" data-slide-to="1"></li>
                <li data-target="#productEditCarousel" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" id="editImage1" alt="First slide" style="width: 400px; height: 200px;">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>First Image</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" id="editImage2" alt="Second slide" style="width: 400px; height: 200px;">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Second Image</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" id="editImage3" alt="Third slide" style="width: 400px; height: 200px;">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Third Image</h5>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#productEditCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#productEditCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            </div>
            <div class="col-md-4"></div>
            </div>
                    <div class="form-group mt-3">
                        <label>Title</label>
                        <input class="form-control" id="editTitle" type="text" name="title" required="" >
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <input class="form-control" id="editBrand" type="text" name="brand" required="" >
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subcategory</label>
                        <select class="form-control" id="subcategory_id" name="subcategory_id">
                        @foreach ($subcategories as $subcategory)
                        <option value="{{$subcategory->id}}">{{$subcategory->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control" type="number" id="editQuantity" name="quantity" required="" min="0">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" type="number" id="editPrice" name="price" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Delivery Fee</label>
                        <input class="form-control" type="number" id="editDelivery" name="delivery_fee" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Provincial Delivery Fee</label>
                        <input class="form-control" type="number" id="editProvincial" name="provincial_delivery_fee" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="5" id="editDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Image 1 (optional)</label>
                        <input type="file" class="form-control" name="image1">
                    </div>
                    <div class="form-group">
                        <label>Image 2 (optional)</label>
                        <input type="file" class="form-control" name="image2">
                    </div>
                    <div class="form-group">
                        <label>Image 3 (optional)</label>
                        <input type="file" class="form-control" name="image3">
                    </div>
                   
                      <div class="pt-2">
              </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
        </div>
        </div>
         </div>
        </div>

  <div class="modal fade crud" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" id="submit_add_product" action="javascript:void(0)">
                @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="title" required="" minlength="2" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Brand</label>
                        <input class="form-control" type="text" name="brand" required="" minlength="2" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="add_category_id" name="category_id">
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subcategory</label>
                        <select class="form-control" id="add_subcategory_id" name="subcategory_id">
                        @foreach ($subcategories as $subcategory)
                        <option value="{{$subcategory->id}}">{{$subcategory->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control" type="number" name="quantity" required="" min="0">
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control" type="number" name="price" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Delivery Fee</label>
                        <input class="form-control" type="number" name="delivery_fee" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Provincial Delivery Fee</label>
                        <input class="form-control" type="number" name="provincial_delivery_fee" required="" min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" rows="5" name="description"></textarea>
                    </div>
                    <div class="form-group @error('image') is-invalid @enderror">
                        <label>Image 1 (optional)</label>
                        <input type="file" class="form-control" name="image1">
                    </div>
                    <div class="form-group @error('image') is-invalid @enderror">
                        <label>Image 2 (optional)</label>
                        <input type="file" class="form-control" name="image2">
                    </div>
                    <div class="form-group @error('image') is-invalid @enderror">
                        <label>Image 3 (optional)</label>
                        <input type="file" class="form-control" name="image3">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="add_submit" type="submit" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div>
        </div>
        </div>
         </div>
        </div>      

  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalTitle">View Product Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div id="productViewCarousel" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#productViewCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#productViewCarousel" data-slide-to="1"></li>
                <li data-target="#productViewCarousel" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" id="viewImage1" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>First Image</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" id="viewImage2" alt="Second slide">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Second Image</h5>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" id="viewImage3" alt="Third slide">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Third Image</h5>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#productViewCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#productViewCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
        </div>


    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/admin/modals.js') }}"></script>
<script>

$(document).ready(function (e) {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#submit_add_product').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/products/store') }}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: function(result){
                if(result.errors)
                {
                    $('.modal-errors').html('');
    
                    $.each(result.errors, function(key, value){
                        $('.modal-errors').show();
                        $('.modal-errors').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    $('.modal-errors').hide();
                    $('#addModal').modal('hide');
                    window.location = "{{ url('/admin/products/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

$('#submit_edit_product').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/products/edit') }}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: function(result){
                if(result.errors)
                {
                    $('.modal-errors').html('');
    
                    $.each(result.errors, function(key, value){
                        $('.modal-errors').show();
                        $('.modal-errors').append('<li>'+value+'</li>');
                    });
                }
                else
                {
                    $('.modal-errors').hide();
                    $('#editModal').modal('hide');
                    window.location = "{{ url('/admin/products/') }}";
                    // $('.alert-success').html('');
                    // $('.alert-success').show();
                    // $('.alert-success').append('Member added.');
                    // $('.alert-success').css('display', '');
                }
            }
});
});

// $("#add_category_id").change(function () {
//         var val = $(this).val();
//         if (val == "item1") {
//             $("#size").html("<option value='test'>item1: test 1</option><option value='test2'>item1: test 2</option>");
//         } else if (val == "item2") {
//             $("#size").html("<option value='test'>item2: test 1</option><option value='test2'>item2: test 2</option>");
//         } else if (val == "item3") {
//             $("#size").html("<option value='test'>item3: test 1</option><option value='test2'>item3: test 2</option>");
//         } else if (val == "item0") {
//             $("#size").html("<option value=''>--select one--</option>");
//         }
//     });

 });


</script>
@endsection


