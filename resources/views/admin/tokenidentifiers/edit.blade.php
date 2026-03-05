@extends('layouts._comman')
@section('title', 'Edit Token Identifiers - Knote')
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
                    <li class="breadcrumb-item"><a href="{{route('tokenidentifiers.index')}}">Token Identifiers</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
               <h4 class="page-title">Edit Token Identifiers</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">
            <form action="{{ url('admin/tokenidentifiers/update') }}" name="admin/tokenidentifiers/edit" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box" style="overflow-y: auto;height: calc(100vh - 225px);">
                    <div class="row">  
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Token Key<span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{ $result->title }}" class="form-control" placeholder="Title" readonly="">
                                <input type="hidden" id="id" name="id" value="{{ $result->id }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="description">Token Description<span class="text-danger">*</span></label>
                                <input type="text" id="description" name="description" value="{{ $result->description }}" class="form-control" placeholder="Token Description">
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <hr>
                            <button class="btn btn-success mt-3" type="submit" id="tokenidentifiers-edit">Update</button>
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
    $('#tokenidentifiers-edit').click(function() {
        var url = $('#tokenidentifiers-edit').closest('form').attr('action');
        var formData = new FormData($('#tokenidentifiers-edit').closest('form')[0]);
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,  // Important: Prevent jQuery from processing the data
            contentType: false,  // Important: Let the browser set the content type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    $('#tokenidentifiers-edit').closest('form')[0].reset();
                    toaserMessage(response.status, response.message);
                    setTimeout(function() {
                        window.location.href = "{{ url('admin/tokenidentifiers') }}";
                    }, 2000);
                }
            },
            error: function(reject) {
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