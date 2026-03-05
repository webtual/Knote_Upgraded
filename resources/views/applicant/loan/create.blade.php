@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
@section('styles')
   @if(request()->is('loan*'))
      <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
      <link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      
      <style type="text/css" media="screen">
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
            top:14px !important;
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
        </style>
   @endif

@endsection
@section('content')

<div class="content loan-form-page">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row my-2">
         <div class="col-lg-5 col-xl-3 cu-applisidebar cleft">
             <div class="card-box color-knote">
               <h3 class="text-white text-uppercase">Start application</h3>
               <div class="tab-content">
                   @include('partials.comman.loan.leftsidebar')
               </div>
            </div> 
           
         </div>
         <div class="col-lg-7 col-xl-6">
            <div class="card-box">
               <h3 class="">Business Information</h3>
               <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                     <form action="{{ url('create/business-information') }}" id="loan-application-first" name="loan-application-first" method="post" onsubmit="return false;">
                         
                        
                        @if(isset($application))
                            @php
                                $apply_for = $application->apply_for;
                            @endphp
                        @else
                            @php
                                $initial_session_obj = session('otp_verification_obj');
                                $request_information = json_decode($initial_session_obj->request_information);
                                $apply_for = $request_information->apply_for;
                            @endphp
                        @endif
                       
                        <div class="row mb-3">
                           <div class="col-md-12">
                              <!--<div class="form-group">
                                 <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>
                                 <input id="price-loan" class="form-control" data-max="{{ ($apply_for == 1) ? '500000' : '2000000' }}" data-from="{{ ($application) ? $application->amount_request : '1' }}"
                                  type="text" name="" value="{{ ($application) ? $application->amount_request : '' }}" />
                                  <div>
                                      <a class="add-manual-amount-btn text-white" title="Add Manual" href="javascript:;"><i class="fe-edit text-right"></i></a>
                                  </div>
                              </div>-->
                              
                              <!--<div class="form-group input-pos-relative">-->
                              <!--   <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>-->
                              <!--   <input type="text" maxlength="15" class="form-control currency-input" id="m_loan_amount" placeholder="Amount" value="{{ ($application) ? number_format($application->amount_request) : '' }}" type="text" name="m_loan_amount" data-max="{{ ($apply_for == 1) ? '100000' : '10000000' }}">-->
                              <!--   <span class="currency-symbol">$</span>-->
                              <!--</div>-->
                              
                              
                                <div class="form-group ">
                                    <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>
                                    <div class="input-group flex-nowrap gap-2">
                                        <div class="input-pos-relative w-100">
                                        <input type="text" maxlength="15" class="form-control currency-input h-100" id="m_loan_amount" placeholder="Amount" value="{{ ($application) ? number_format($application->amount_request) : '' }}" name="m_loan_amount" data-max="{{ ($apply_for == 1) ? '100000' : '10000000' }}">
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
                        </div>
                        
                        
                         <div class="row">
                           <div class="col-md-6">
                              <div class="form-group mb-3">
                                 <label>ABN OR ACN <span class="text-danger">*</span></label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="abn_acn" placeholder="ABN OR ACN" aria-label="" data-action="{{ url('search/abn-acn') }}" maxlength="11" value="{{ ($application) ? $application->abn_or_acn : '' }}">
                                 </div>
                              </div>
                           </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="bs">Year Established <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="year_established">
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
                        </div>

                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="bs">Business Structure <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="business_structure" >
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
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Business Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="business_name" id="" placeholder="Business Name" value="{{ ($application) ? $application->business_name : '' }}">
                              </div>
                           </div>
                        </div>
                       
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Business Address <span class="text-danger">*</span></label>
                                 <input type="text" name="business_address" class="form-control" id="business_address" placeholder="Business Address" value="{{ ($application) ? $application->business_address : '' }}" >
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="bs">Business Email <span class="text-danger">*</span></label>
                                 <input type="text" name="business_email" class="form-control" id="" placeholder="Business Email" value="{{ ($application) ? $application->business_email : '' }}" >
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="bs">Your industry of trade <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="trade" >
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
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Mobile <span class="text-danger">*</span></label>
                                 <input type="text" name="mobile" class="form-control phone-field" id="" placeholder="Mobile" value="{{ ($application) ? $application->business_phone : '' }}">
                              </div>
                           </div>
                          
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="bs">Landline</label>
                                 <input type="text" name="landline" data-mask="99 9999 9999" value="{{ ($application) ? $application->landline_phone : '' }}" class="form-control landline-field" id="" placeholder="Landline">
                              </div>
                           </div>
                           
                           {{--
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Fax</label>
                                 <input type="text" name="fax" value="{{ ($application) ? $application->fax : '' }}" class="form-control" id="" placeholder="Fax">
                              </div>
                           </div>
                           --}}
                           
                        </div>
                        
                        <input type="hidden" name="postcode" value="{{ ($application) ? $application->postcode : '' }}">
                        
                        
                        <input type="hidden" name="loan_amount_requested" value="{{ ($application) ? $application->amount_request : '90000' }}">
                        <input type="hidden" name="application_id" value="{{ ($application) ? $application->id : '' }}">
                        
                        <input type="hidden" name="apply_for" value="{{$apply_for}}">
                        
                        <div class="text-center">
                            @if($enc_id == "")
                               <button type="submit" data-url="{{ url()->current() }}" data-redirect="{{ url('loan/create/people') }}" id="pr-first" class="btn btn-success waves-effect waves-light mt-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                            @else
                               <button type="submit" data-url="{{ url('loan/create/business-information') }}" data-redirect="{{ url('loan/edit/people/'.$enc_id) }}" id="pr-first" class="btn btn-success waves-effect waves-light mt-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                            @endif   
                        </div>
                     </form>
                  </div>
                  <!-- end settings content-->
               </div>
               <!-- end tab-content -->
            </div>
         </div>
         <div class="col-lg-7 col-xl-3 cu-applisidebar cright">
            @include('partials.comman.loan.right_cardbox', ['application' => $application])
         </div>
      </div>
   </div>
   <!-- container -->
</div>

@endsection
@section('scripts')
   @if(request()->is('loan*'))
    
    <script src="{{ asset('comman/js/pages/ion.rangeSlider.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      
      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_api_key') }}&libraries=places"></script>
    
    <script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>
    
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
        
        var options = {
          types: ['geocode'],
          componentRestrictions: { country: 'AU' }
        };
        
        var autocomplete = new google.maps.places.Autocomplete($("#business_address")[0], options);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            //console.log(place.address_components);
        });
        
        
        $('.add-manual-amount-btn').click(function(){
            $(this).closest('.form-group').next('.form-group').removeClass('d-none');
            $(this).closest('.form-group').remove();
        })
        
        /*$('#m_loan_amount').on('input', function() {
            var loan_amount = $(this).val();
            loan_amount = loan_amount.replace(/[^0-9]/g, '');
            $('input[name="loan_amount_requested"]').val(loan_amount);
            //alert($apply_for);
            $('.error-block').remove();
            @if($apply_for == 1)
                if (loan_amount < 1 || loan_amount > 100000) {
                    $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $100,000</small></span>'); 
                }
            @else
                if (loan_amount < 1 || loan_amount > 10000000) {
                    $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $1,000,000</small></span>'); 
                }
            @endif
        })*/
        
        $('#m_loan_amount').on('keyup', function() {
            var loan_amount = $(this).val();
            loan_amount = loan_amount.replace(/[^0-9]/g, '');
            $('input[name="loan_amount_requested"]').val(loan_amount);
            $('.error-block').remove();
        
            @if($apply_for == 1)
                if (loan_amount < 1 || loan_amount > 100000) {
                    $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $100,000</small></span>'); 
                }
            @else
                if (loan_amount < 1 || loan_amount > 10000000) {
                    $('input[id="m_loan_amount"]').after('<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $10,000,000</small></span>'); 
                }
            @endif
        });

    </script>
        
   @endif
@endsection