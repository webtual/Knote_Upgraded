@extends('layouts._comman')
@section('title', 'Create Conditionally Approved Documents - Knote')
@section('styles')
<style>
 
</style>
@section('content')
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('approveddocuments.index')}}">Approved Documents</a></li>
                    <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
               <h4 class="page-title">Create New Approved Documents</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">
            <form action="{{ url()->current() }}" name="admin/approveddocuments/create" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box" style="overflow-y: auto;height: calc(100vh - 225px);">
                    <div class="row">  
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Document Name<span class="text-danger">*</span></label>
                                <input type="text" id="document_name" name="document_name" value="{{ old('document_name') }}" class="form-control" placeholder="Title">
                                @error('document_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Upload Document File<span class="text-danger">*</span></label>
                                <input type="file" id="document_file" name="document_file" value="{{ old('document_file') }}" class="form-control" placeholder="Document File">
                                @error('document_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="text-danger">Note: Token Identifiers should be used as follows: abn_or_acn becomes ${abn_or_acn}.</p>
                        </div>
                        <div class="col-lg-12 text-right">
                            <hr>
                            <button class="btn btn-success mt-3" type="submit" id="approveddocuments-add">Save</button>
                        </div>
                    </div>
                    <div class="row">  
                        
                    </div>
               </div>
            </form>
            <!-- end card-box -->
         </div>
         <div class="col-lg-4">
            
         </div>
      </div>
      <!-- container -->

   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#approveddocuments-add').click(function(){
    var url = $('#approveddocuments-add').closest('form').attr('action');
    var formData = new FormData($('#approveddocuments-add').closest('form')[0]); // Use FormData

    $.ajax ({
        type: 'POST',
        url: url,
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 200){
                $('#approveddocuments-add').closest('form')[0].reset();
                toaserMessage(response.status, response.message);
                setTimeout(function(){ window.location.href = "{{ url('admin/approveddocuments') }}"; }, 2000);
            }
        },
        error: function (reject) {
            if (reject.status === 422) {
                var errors = reject.responseJSON.errors;
    
                $('.text-danger').remove(); 
    
                $.each(errors, function(key, message) {
                    var inputField = $('input[name=' + key + ']');
                    inputField.after('<span class="text-danger">' + message[0] + '</span>');
                });
            }
        }
    });
});
</script>
@endsection