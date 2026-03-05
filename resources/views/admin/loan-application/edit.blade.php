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
     .irs--flat .irs-line {
        height: 20px;
     }
     .irs--flat .irs-bar {
        height: 20px;
     }   
     .irs--flat .irs-handle {
        height: 25px;
     }
     .irs--flat .irs-min, .irs--flat .irs-max {
        font-size: 12px;
     }
     .irs--flat .irs-from, .irs--flat .irs-to, .irs--flat .irs-single {
        font-size: 12px;
     }
     
    .loan-form-page .select2-container--default .select2-selection--single {
		height: calc(1.5em + 0.9rem + 2px);
		padding: 5px;
		border: 1px solid #ccc;
	}
	
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow{
		top: 5px;
	}
	
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #444444b8;
	}

   .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #2eab99 !important;
        color: white;
    }
    .currency-symbol-one{
        top:8px !important;
    }
    .text-nowrap{
        text-wrap: nowrap;
    }
    .gap-2{
        gap: 8px;
    }
    .plus-minus-btn{
        padding-top: 0 !important;
        padding-bottom: 0!important;
        width: 40px;
        line-height: normal;
        height: 14px;
          line-height: 14px;
          display: block;
    }
    .plus-minus-btn.mb-1{
     margin-bottom: 2px !important;   
    }
    .plus-minus-btn-wrapper{
        display: flex;
        align-items: center;
        border:1px solid #ced4da;
        border-radius: 3px;
        padding: 2px;
    }
    .plus-minus-btn-wrapper > div{
        width: 50px;
    }
    .new-select .select2-container--default .select2-selection--single{
      display: block;
      width: 100%;
      height: calc(1.5em + .9rem + 2px);
      padding: 5px .9rem;
      font-size: .875rem;
      font-weight: 400;
      line-height: 1.5;
      color: #6c757d;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: .2rem;
      -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
      transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    }
    .new-select .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: calc(1.5em + .9rem + 2px);
    }
</style>
<style type="text/css" media="screen">
    .loan-form-page .select2-container--default .select2-selection--single {height: calc(1.5em + 0.9rem + 2px);padding: 5px;border: 1px solid #ccc;}
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow{top: 5px;}
	.loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered {color: #444444b8;}
   .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {background-color: #2eab99 !important;color: white;}
    hr {border-top: 2px solid #1369589e;}
    .datepicker td, .datepicker th{width: 32px;height: 30px;}
    .d-fin-wrapper,.d-property-sec{border:1px solid #eee;padding:20px;border-radius:5px;margin-bottom:20px}
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
                <form action="{{ route('loan.details.update.business.information') }}" name="form_loan_application_update" id="form_loan_application_update" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    <div class="card-box">
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="text-success"><b>Application No:</b> {{$application->application_number}}</h5>
                            <h5 class="text-success"><b>Customer No:</b> {{$application->user->customer_no}}</h5>
                            <h5 class="text-success"><b>Name:</b> {{$application->user->name}}</h5>
                            <h5 class="text-success"><b>Email Address:</b> {{$application->user->email}}</h5>
                            <h5 class="text-success"><b>Phone:</b> {{$application->user->phone}}</h5>
                            
                            <input type="hidden" id="user_id" name="user_id" value="{{$application->user_id}}">
                            <input type="hidden" id="loan_amount_requested" name="loan_amount_requested" value="{{ ($application) ? $application->amount_request : '90000' }}">
                            <input type="hidden" name="postcode" value="{{ ($application) ? $application->postcode : '' }}">
                            <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                            <input type="hidden" name="apply_for" value="{{ ($application) ? $application->apply_for : '1' }}">
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="text-success">Business Information</h3>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>
                                    <div class="input-group flex-nowrap gap-2">
                                        <div class="input-pos-relative w-100">
                                        <input type="text" maxlength="15" class="form-control currency-input" id="m_loan_amount" placeholder="Amount" value="{{ ($application) ? number_format($application->amount_request) : '' }}" name="m_loan_amount" data-max="100000}}">
                                        <span class="currency-symbol currency-symbol-one">$</span>
                                        </div>
                                        <span class="input-group-btn plus-minus-btn-wrapper">
                                            <div>
                                            <button class="btn btn-success plus-minus-btn text-nowrap  mb-1" type="button" id="increment-amount">+</button>
                                            <button class="btn btn-success plus-minus-btn text-nowrap" type="button" id="decrement-amount">-</button>
                                            </div>
                                            <b>$10K</b>
                                        </span>
                                    </div>
                                </div>
                           </div>
                           
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>ABN OR ACN <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="abn_acn" name="abn_acn" placeholder="ABN OR ACN" aria-label="" data-action="{{ url('search/abn-acn') }}" maxlength="11" value="{{ ($application) ? $application->abn_or_acn : '' }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                              <div class="form-group new-select">
                                 <label for="bs">Year Established <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="year_established" id="year_established">
                                    <option value="" selected>Select..</option>
                                    @for($i=1970; $i<=date('Y'); $i++)
                                    <option value="{{ $i }}" 
                                    @if($application)
                                       {{ ($application->years_of_established == $i) ? 'selected' : '' }}
                                    @endif
                                    >{{ $i }}</option>
                                    @endfor
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group new-select">
                                 <label for="bs">Business Structure <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="business_structure" id="business_structure">
                                    <option value="" selected>Select..</option>
                                    @foreach($business_structures as $bs)
                                    <option value="{{$bs->id}}"
                                    @if($application)
                                       {{ ($application->business_structures_id == $bs->id) ? 'selected' : '' }}
                                    @endif
                                    >{{ $bs->structure_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">Business Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" value="{{ ($application) ? $application->business_name : '' }}">
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">Business Address <span class="text-danger">*</span></label>
                                 <input type="text" name="business_address" class="form-control business_address" id="business_address" placeholder="Business Address" value="{{ ($application) ? $application->business_address : '' }}" >
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="bs">Business Email <span class="text-danger">*</span></label>
                                 <input type="text" name="business_email" class="form-control" id="business_email" placeholder="Business Email" value="{{ ($application) ? $application->business_email : '' }}" >
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group new-select">
                                 <label for="bs">Your industry of trade <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="trade" id="trade">
                                    <option value="" selected>Select..</option>
                                    @foreach($business_types as $bt)
                                    <option value="{{$bt->id}}"
                                    @if($application)
                                       {{ ($application->business_type_id == $bt->id) ? 'selected' : '' }}
                                    @endif
                                    >{{ $bt->business_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">Mobile <span class="text-danger">*</span></label>
                                 <input type="text" name="mobile_no" class="form-control phone-field" id="mobile_no" placeholder="Mobile" value="{{ ($application) ? $application->business_phone : '' }}">
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="bs">Landline</label>
                                 <input type="text" name="landline_phone" data-mask="99 9999 9999" value="{{ ($application) ? $application->landline_phone : '' }}" class="form-control landline-field" id="landline_phone" placeholder="Landline">
                              </div>
                           </div>
                           
                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Add Brief notes (What’s the loan for , give us a little background of requirement and proposal)<span class="text-danger">*</span></label>
                                    <textarea name="brief_notes" class="form-control" id="brief_notes" placeholder="Add Brief notes">{{ ($application) ? $application->brief_notes : '' }}</textarea>
                                </div>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_api_key') }}&libraries=places"></script>
<script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>
<script src="{{ asset('comman/js/pages/bootstrap-datepicker.js') }}"></script>

<script>
$(document).ready(function() {
    
    const incrementValue = 10000; // $10K

    // Increment button
    $('#increment-amount').on('click', function() {
        let currentAmount = parseInt($('#m_loan_amount').val().replace(/[^0-9]/g, ''), 10) || 0;
        let newAmount = currentAmount + incrementValue;
        $('#m_loan_amount').val(newAmount.toLocaleString());
        var loan_amount = newAmount.toLocaleString();
        loan_amount = loan_amount.replace(/[^0-9]/g, '');
        $('input[name="loan_amount_requested"]').val(loan_amount);
    });

    // Decrement button
    $('#decrement-amount').on('click', function() {
        let currentAmount = parseInt($('#m_loan_amount').val().replace(/[^0-9]/g, ''), 10) || 0;
        let newAmount = Math.max(0, currentAmount - incrementValue); // Ensure amount doesn't go below 0
        $('#m_loan_amount').val(newAmount.toLocaleString());
        var loan_amount = newAmount.toLocaleString();
        loan_amount = loan_amount.replace(/[^0-9]/g, '');
        $('input[name="loan_amount_requested"]').val(loan_amount);
    });
});

$('select').select2();

function initializeAutocomplete() {
    $('.business_address').each(function() {
        var options = {
            types: ['geocode'],
            componentRestrictions: { country: 'AU' }
        };

        var autocomplete = new google.maps.places.Autocomplete(this, options);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
        });
    });
}

initializeAutocomplete();
$('.add-manual-amount-btn').click(function(){
    $(this).closest('.form-group').next('.form-group').removeClass('d-none');
    $(this).closest('.form-group').remove();
})

$('#m_loan_amount').on('keyup', function() {
    var loan_amount = $(this).val();
    loan_amount = loan_amount.replace(/[^0-9]/g, '');
    $('input[name="loan_amount_requested"]').val(loan_amount);
    $('.error-block').remove();
    var apply_for = $('#apply_for').val();
    
    if(apply_for == 1){
        if (loan_amount < 1 || loan_amount > 100000) {
            $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $100,000</small></span>'); 
        }
    }else{
        if (loan_amount < 1 || loan_amount > 10000000) {
            $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $10,000,000</small></span>'); 
        }
    }
});
</script>

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
                if (reject.status === 422) {
                    var errors = $.parseJSON(reject.responseText);
                    var errors = errors['errors'];
                    
                    $('.help-block').text('');
                    
                    $.each(errors, function (field_name, error) {
                        var string = error[0];
                        var modifiedError = string.replace(/\.\d\s?/, ' ');
                        var error_text = modifiedError.replace(/_/g, ' ');
        
                        if (field_name === "business_trade_year" || field_name == "year_established" || field_name == "business_structure" || field_name == "trade") {
                            $('select[name="'+field_name+'"]').next('span').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }else if (field_name == "brief_notes") {
                            $('textarea[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }else if (field_name == "mobile_no" || field_name == "business_email" || field_name == "business_address" || field_name == "business_name" || field_name == "abn_acn" || field_name == "m_loan_amount" || field_name === "finance_periods" || field_name === "gross_income" || field_name === "total_expenses" || field_name === "net_income") {
                            $('input[name="'+field_name+'"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }else {
                            var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                            var number = field_name.replace(/\D/g, "");
                            
                            if (field === "title" || field === "residential_status" || field === "marital_status" || field === "time_in_business" || field === "time_at_business") {
                                $('.additional_clone').eq(number).find('select[name="'+field+'[]"]').next('span').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                            } else {
                                //alert(field);
                                $('.additional_clone').eq(number).find('input[name="'+field+'[]"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                                
                                $('.d-property-sec').eq(number).find('input[name="'+field+'[]"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                                
                                $('.assets-members').eq(number).find('input[name="'+field+'[]"]').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                            }
                        }

                    });
                }
            }
        });
    });
</script>
@endsection