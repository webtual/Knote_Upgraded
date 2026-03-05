@extends('layouts._comman')
@section('title', 'Create Token Identifiers - Knote')
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
                    <li class="breadcrumb-item active">Create</li>
                  </ol>
               </div>
               <h4 class="page-title">Create New Token Identifiers</h4>
            </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">
            <form action="{{ url()->current() }}" name="admin/tokenidentifiers/create" method="post" onsubmit="return false;" enctype="multipart/form-data">
               <div class="card-box" style="overflow-y: auto;height: calc(100vh - 225px);">
                    <div class="row">  
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="title">Token Key<span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Token Key">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="description">Token Description<span class="text-danger">*</span></label>
                                <input type="text" id="description" name="description" value="{{ old('description') }}" class="form-control" placeholder="Token Description">
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12 text-right">
                            <hr>
                            <button class="btn btn-success mt-3" type="submit" id="tokenidentifiers-add">Save</button>
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
   $('#tokenidentifiers-add').click(function(){
        var url = $('#tokenidentifiers-add').closest('form').attr('action');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $('#tokenidentifiers-add').closest('form').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 200){
                    $('#tokenidentifiers-add').closest('form')[0].reset();
                    toaserMessage(response.status, response.message);
                    //setTimeout(function(){ window.location.href = "{{ url('admin/tokenidentifiers') }}"; }, 2000);
                    location.reload();
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