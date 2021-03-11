@extends('layouts.admin.admin')
@section('title')
Padyak.Co Admin - Inquiries
@endsection
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Inquiries List</h1>
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
                <div class="table-responsive">
                <table id="inquiriestable" class="table text-center">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>E-mail</th>
                          <th>Subject</th>
                          <th>Sent At</th>
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                 @foreach ($inquiries as $inquiry)
                     <tr>
                          <td>{{$inquiry->name}}</td>
                          <td>{{$inquiry->email}}</td>
                          <td>{{$inquiry->subject}}</td>
                          <td>{{$inquiry->created_at}}</td>
                          @if($inquiry->status == "replied")
                          <td> <span class="badge badge-success justify-content-center ">{{$inquiry->status}}</span></td>
                          @else
                          <td> <span class="badge badge-warning">{{$inquiry->status}}</span></td>
                          @endif
                          <td><div class="row justify-content-center">
                          <button class="btn btn-dark" data-id="{{$inquiry->id}}" data-subject="{{$inquiry->subject}}" onclick="replyInquiry(this);"><i class="fa fa-envelope" aria-hidden="true"></i></button>  
                          <button class="btn btn-info ml-2" data-message="{{$inquiry->message}}" onclick="viewMessage(this);"><i class="fa fa-eye" aria-hidden="true"></i></button>        
                          <button class="btn btn-danger ml-2" data-id="{{$inquiry->id}}" onclick="deleteInquiry(this);"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
        <div class="modal-body">A deleted inquiry cannot be recovered anymore.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" id="DeleteUserButton">Delete
          </a>
        </div>
      </div>
    </div>
  </div> 

  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="viewModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalTitle">View Inquiry Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                      <div class="card ">
            <div class="card-body">
                        <p id="viewMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
          </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade crud" id="replyInquiryModal" tabindex="-1" role="dialog" aria-labelledby="editStatusModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data"  id="submit_reply_inquiry" action="javascript:void(0)" >
            @CSRF
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Reply to Inquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" id="inquiryId" name="inquiryId">
                <div class="modal-body">
                      <div class="card ">
           
            <div class="card-body">
            <div class="alert alert-danger modal-errors" style="display:none"></div>
            <div class="form-group">
                        <label>Subject</label>
                        <input type="text" id="inquirySubject" name="subject" class="form-control @error('subject') is-invalid @enderror">
                    </div>    
                    <div class="form-group">
                        <label>Reply</label>
                        <textarea name="reply" class="form-control @error('reply') is-invalid @enderror" rows="5"></textarea>
                    </div>             
                      <div class="pt-2">
              </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
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
$('#submit_reply_inquiry').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('/admin/inquiries/reply') }}",
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
                    $('replyInquiryModal').modal('hide');
                    window.location = "{{ url('/admin/inquiries/') }}";
                }
            }
});
});

});
</script>
@endsection


