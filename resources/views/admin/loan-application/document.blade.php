@extends('layouts._comman')
@section('title', 'Edit Loan Application - Knote')
@section('styles')
<link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('comman/css/bootstrap-datepicker.css') }}" rel="stylesheet">
<style type="text/css" media="screen">
 #sidebar-menu ul li:hover {
      background-color: transparent!important;
      /*color: white;*/
    }
    #sidebar-menu ul li.active{
        background-color: transparent!important;
    }
.document-page .gallery{
    background: #2eab990a;
    padding: 25px;
    border-radius: 5px;
    margin: 0px 0px;
}

.document-page .gallery .item img{
    /*height: 150px;*/
    /*object-fit: contain;*/
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.document-page .gallery .item{
    text-align: center;
    background: #2eab9917;
    padding: 15px;
    border-radius: 5px;
    cursor: pointer;
    height: 185px;
    border: 1px solid #ccc;
}

.document-page .gallery .remove-document-img, .document-page .gallery .hard-remove-document-image-new{
    margin: 0px;
    position: absolute;
    top: -8px;
    right: -2px;
    background: #136958;
    color: #fff;
    width: 24px;
    height: 24px;
    border-radius: 50%;
}

.document-page .gallery .remove-document-img i, .document-page .gallery .hard-remove-document-image-new i{
    font-size: 16px;
    position: absolute;
    left: 4px;    
}
.loanapplication .col-3{
    flex:inherit !important;
    max-width: inherit !important;
    width: auto;
}
</style>
@endsection

@section('content')
<div class="content application-form">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('user.list')}}">Customers</a></li>
                            @php
                            $url = url('admin/loan/details/'.\Crypt::encrypt($application_id));
                            @endphp
                            <li class="breadcrumb-item"><a href="{{$url}}">{{$application->application_number}}</a></li>
                            <li class="breadcrumb-item active">Edit Loan Application</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Loan Application</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('loan.details.update.document') }}" name="form_loan_application_update" id="form_loan_application_update" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    <div class="card-box">
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="text-success"><b>Application No:</b> {{$application->application_number}}</h5>
                            <h5 class="text-success"><b>Customer No:</b> {{$application->user->customer_no}}</h5>
                            <h5 class="text-success"><b>Name:</b> {{$application->user->name}}</h5>
                            <h5 class="text-success"><b>Email Address:</b> {{$application->user->email}}</h5>
                            <h5 class="text-success"><b>Phone:</b> {{$application->user->phone}}</h5>
                            
                            <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                            <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                        </div>
                        
                        <div class="row document-page">
                            <div class="col-lg-12">
                                <h3 class="text-success">Document</h3>
                            </div>
                            
                            @php
                            $document_types = config('constants.document_types');
                                if($application->apply_for == 1){
                                    unset($document_types['3']);
                                }
                            @endphp
                            
                            <div class="col-lg-12">
                                @foreach($document_types as $key => $value)
                                    <div class="row mt-{{ ($key == 0) ? 0 : 3 }}">
                                       <div class="col-12">
                                          <div class="card">
                                             <div class="card-body border">
                                                <h4 class="header-title">{{ $value }} {!! ($value == "Proof of Identity") ? '<span class="text-danger">*</span>' : '' !!}</h4>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-documents" id="{{ $key }}" multiple="multiple" accept="application/pdf, image/*" data-pdf-placeholder="{{ asset('storage/document/pdf-placeholder.png') }}">
                                                        <label class="custom-file-label" for="">Choose file</label>
                                                    </div>
                                                </div>
                                                
                                                @if($value == "Proof of Identity")
                                                <div class="mt-2">
                                                    <p class="mb-0"><b>Example:</b></p>
                                                    <p class="mb-0"><b>Must one of them:</b> Driving licence ,Passport</p>
                                                    <p class="mb-0"><b>Supporting:</b> Medicare and any Gov Card</p>
                                                </div>
                                                @endif
                                                
                                             </div> 
                                          </div>
                                       </div>
                                    </div>
        
                              
                                    <div class="row gallery loanapplication" id="position-{{ $key }}">
                                        @if(!empty($application->get_documents_by_type($key)))
                                          @foreach($application->get_documents_by_type($key) as $document)
                                            <div class="position-relative col-3 fetch-documents">
                                              <div class="item">
                                                  <input type="hidden" name="image[]" value="{{ $document->file }}"
                                                  >
                                                  <input type="hidden" name="document_type[]" value="{{ $document->type }}">
                                                  @php
                                                  $ext = pathinfo(asset('storage/'.$document->file), PATHINFO_EXTENSION);
                                                  @endphp
                                                  @if($ext == 'pdf')
                                                  <a href="{{ asset('storage/'.$document->file) }}" target="blank">
                                                    <img class="rounded" src="{{ asset('storage/document/pdf-placeholder.png') }}">
                                                  </a>
                                                  @else
                                                  <img class="rounded" src="{{ asset('storage/'.$document->file) }}">
                                                  @endif
                                                  <p class="hard-remove-document-image-new text-left font-20" data-id="{{ $document->id }}" data-url="{{ url('admin/loan/details/document/delete') }}" data-application-id="{{ $document->application_id }}" >
                                                    <i class="mdi mdi-delete-outline"></i>
                                                  </p>
                                              </div>
                                            </div>
                                          @endforeach
                                        @endif
                                    </div>
                                 
                                @endforeach
                            </div>                            
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 text-right">
                            <hr>
                                <button class="btn btn-success mt-3" type="submit" id="form_loan_application_update_btn">Update</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   $('#form_loan_application_update_btn').click(function(){
        var url = $('#form_loan_application_update').closest('form').attr('action');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $('#form_loan_application_update').closest('form').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 200){
                    toaserMessage(response.status, response.message);
                    setTimeout(function(){ 
                        @php
                            $url = url('admin/loan/details/'.Crypt::encrypt($application->id));
                        @endphp
                        window.location.href = "{{ $url }}"; 
                    }, 2000);
                }
            },
            error: function (reject) {
                if( reject.status === 422 ) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    toaserMessage(422, Object.values(errors)[0]);
                }
            }
        });
    });
    
    $('.hard-remove-document-image-new').click(function(){
        var url = $(this).data('url');
        var document_id = $(this).attr('data-id');
        var application_id = $(this).attr('data-application-id');
        
        // Add confirmation dialog
        var confirmation = confirm("Are you sure you want to delete this document?");
        
        if (confirmation) {
            $(this).closest('div.col-3').remove(); // Remove the element from the DOM
    
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: {document_id: document_id, application_id: application_id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    if (response.status == 201) {
                        toaserMessage(response.status, response.message);
                    }
                },
                error: function(reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        toaserMessage(422, Object.values(errors)[0]);
                    }
                }
            });
        } else {
            // Do nothing if the user cancels the deletion
            return false;
        }
    });
</script>
@endsection