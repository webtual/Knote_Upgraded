@extends('layouts._comman')
@section('title', 'Create Email Template - Knote')
@section('styles')
<style>
 
</style>
<!-- Summernote css -->
<link href="{{ asset('comman/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
@section('content')
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('emailtemplates.index')}}">Email Templates</a></li>
                    <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
               <h4 class="page-title">Create New Email Template</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">
            <form action="{{ url()->current() }}" name="admin/emailtemplates/create" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box" style="overflow-y: auto;height: calc(100vh - 225px);">
                    <div class="row">  
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Title<span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Subject<span class="text-danger">*</span></label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subject">
                                @error('subject')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Body<span class="text-danger">*</span></label>
                                <textarea id="body" name="body" class="form-control summernote-editor" rows="4" placeholder="Body">{{ old('body') }}</textarea>
                                @error('body')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <hr>
                            <button class="btn btn-success mt-3" type="submit" id="template-add">Save</button>
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
<script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
<script>
   $('#template-add').click(function(){
        var url = $('#template-add').closest('form').attr('action');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $('#template-add').closest('form').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 200){
                    $('#template-add').closest('form')[0].reset();
                    toaserMessage(response.status, response.message);
                    setTimeout(function(){ window.location.href = "{{ url('admin/emailtemplates') }}"; }, 2000);
                }
            },
            error: function (reject) {
                if (reject.status === 422) {
                    var errors = reject.responseJSON.errors;
    
                    // Clear previous error messages
                    $('.text-danger').remove(); 
    
                    // Loop through the errors and display them below the respective input fields
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