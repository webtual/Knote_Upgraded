@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
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
    .loanapplication .col-3{
        flex:inherit !important;
        max-width: inherit !important;
        width: auto;
    }
    .document-page .gallery.loanapplication .item{
        height: 185px;
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
                            $url = url('admin/users/loan-applications/'.\Crypt::encrypt($user_id));
                            use App\User;
                            @endphp
                            <li class="breadcrumb-item"><a href="{{$url}}">{{$user_data->customer_no}}</a></li>
                            <li class="breadcrumb-item active">Create New Loan Application</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create New Loan Application</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('users.new.loan.application.store') }}" name="form_loan_application_create" id="form_loan_application_create" method="post" onsubmit="return false;" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-box">
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="text-success"><b>Customer No:</b> {{$user_data->customer_no}}</h5>
                            <h5 class="text-success"><b>Name:</b> {{$user_data->name}}</h5>
                            <h5 class="text-success"><b>Email Address:</b> {{$user_data->email}}</h5>
                            <h5 class="text-success"><b>Phone:</b> {{$user_data->phone}}</h5>
                            <input type="hidden" id="user_id" name="user_id" value="{{$user_id}}">
                            <input type="hidden" id="loan_amount_requested" name="loan_amount_requested" value="">
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="text-success">Business Information</h3>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="form-group new-select">
                                    <label for="apply_for">Application Type <span class="text-danger">*</span></label>
                                    <select class="custom-select" name="apply_for" id="apply_for">
                                        <!--<option value="">Select..</option>-->
                                        @foreach($application_types as $bt)
                                        <option value="{{$bt['id']}}" {{ $bt['id'] == 2 ? 'selected' : '' }}>{{ $bt['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label for="">How much you would like to borrow? <span class="text-danger">*</span></label>
                                    <div class="input-group flex-nowrap gap-2">
                                        <div class="input-pos-relative w-100">
                                        <input type="text" maxlength="15" class="form-control currency-input" id="m_loan_amount" placeholder="Amount" value="" name="m_loan_amount" data-max="100000}}">
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
                                        <input type="text" class="form-control" id="abn_acn" name="abn_acn" placeholder="ABN OR ACN" aria-label="" data-action="{{ url('search/abn-acn') }}" maxlength="11" value="">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                              <div class="form-group new-select">
                                 <label for="bs">Year Established <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="year_established" id="year_established">
                                    <option value="" selected>Select..</option>
                                    @for($i=1970; $i<=date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
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
                                    <option value="{{$bs->id}}">{{ $bs->structure_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">Business Name <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" value="">
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="">Business Address <span class="text-danger">*</span></label>
                                 <input type="text" name="business_address" class="form-control business_address" id="business_address" placeholder="Business Address" value="" >
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="bs">Business Email <span class="text-danger">*</span></label>
                                 <input type="text" name="business_email" class="form-control" id="business_email" placeholder="Business Email" value="" >
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group new-select">
                                 <label for="bs">Your industry of trade <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="trade" id="trade">
                                    <option value="" selected>Select..</option>
                                    @foreach($business_types as $bt)
                                    <option value="{{$bt->id}}">{{ $bt->business_type }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="">Mobile <span class="text-danger">*</span></label>
                                 <input type="text" name="mobile_no" class="form-control phone-field" id="mobile_no" placeholder="Mobile" value="">
                              </div>
                           </div>
                           
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="bs">Landline</label>
                                 <input type="text" name="landline_phone" data-mask="99 9999 9999" value="" class="form-control landline-field" id="landline_phone" placeholder="Landline">
                              </div>
                           </div>
                           
                           <div class="col-md-3">
                                <div class="form-group new-select">
                                    <label for="">How did you know about us?<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="know_about_us" id="know_about_us">
                                        <option value="" selected>Select..</option>
                                        @foreach (User::KNOW_ABOUT_US_VAL as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                     </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group input-pos-relative">
                                    <label for="know_about_us_others">Please Specify</label>
                                    <input type="text" name="know_about_us_others" class="form-control know_about_us_others" id="know_about_us_others" placeholder="Please Specify" value="" maxlength="100" autocomplete="off" >
                                </div>
                            </div>
                           
                           
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Add Brief notes (What’s the loan for , give us a little background of requirement and proposal)<span class="text-danger">*</span></label>
                                    <textarea name="brief_notes" class="form-control" id="brief_notes" placeholder="Add Brief notes"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row loan-form-page">
                            <div class="col-lg-12">
                                <h3 class="text-success">Applicant/Director/Proprietor</h3>
                            </div>
                            
                            <div class="col-lg-12">
                                <fieldset id="team_member">
                                    @include('partials.comman.loan.team_member_add_new')
                                </fieldset>
                            </div>
                        </div>
                        
                        @php
                            $property_loan_types = config('constants.property_loan_types');
                            $type_of_property = config('constants.type_of_property');
                            $property_loan_types_1 = config('constants.type_of_crypto');
                        @endphp
                        
                        <div class="inqtype-1 loan-form-page" style="display:none;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="text-success">Business Financial Information</h3>
                                </div>
                            </div>
                            
                            <div class="row">
                           
                               <div class="col-md-12">
                                  <div class="form-group">
    
                                     <label for="" class="">&nbsp;</label>
                                     @php
                                     $finance_periods = config('constants.finance_periods');
                                     @endphp
                                     @foreach($finance_periods as $key => $value)
                                     <div class="radio form-check-inline">
                                        <input type="radio" id="inlineRadio{{ $key }}" value="{{ $key }}" name="finance_periods" {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                        <label for="inlineRadio{{ $key }}"> {{ ucfirst($value) }} </label>
                                     </div>
                                     @endforeach
                                  </div>
                               </div>
                               
                               <div class="col-md-6">
                                  <div class="form-group new-select">
                                     <label for="">Business Trade Year <span class="text-danger">*</span></label>
                                     <select class="custom-select" name="business_trade_year">
                                        <option value="">Select..</option>
                                        @for($i= (date('Y') - 3); $i<=date('Y'); $i++)
                                           <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                     </select>
                                  </div>
                               </div>
                               
                               <div class="col-md-6">
                                  <div class="form-group input-pos-relative">
                                     <label for="">Gross Income <span class="text-danger">*</span></label>
                                     <input type="text" class="form-control currency-input" name="gross_income" id="" placeholder="Gross Income" value="">
                                     <span class="currency-symbol">$</span>
                                  </div>
                               </div>
                               
                            </div>
                            <div class="row">
                               <div class="col-md-6">
                                  <div class="form-group input-pos-relative">
                                     <label for="">Total Expenses <span class="text-danger">*</span></label>
                                     <input type="text" name="total_expenses" class="form-control currency-input" id="" placeholder="Total Expenses" value="">
                                     <span class="currency-symbol">$</span>
                                     <span class="help-block"><small>Including contractor, stock and sale</small></span>
                                  </div>
                               </div> 
                               <div class="col-md-6">
                                  <div class="form-group input-pos-relative">
                                     <label for="">Net Income <span class="text-danger">*</span></label>
                                     <input type="text" name="net_income" class="form-control currency-input" id="" placeholder="Net Income" value="">
                                     <span class="currency-symbol">$</span>
                                  </div>
                               </div>
                            </div>
                        </div>
                        
                        <div class="row inqtype-2 loan-form-page">
                            <div class="col-lg-12">
                                <h3 class="text-success">Property/Security</h3>
                            </div>
                            
                            <div class="col-lg-12" id="property-sections-container">
                                <div class="d-property-sec">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type of Property / Security? <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <div>
                                                        <h5 class="text-black">Purpose:</h5>
                                                    </div>
                                                    @foreach($property_loan_types as $key => $value)
                                                    <div class="radio  mt-1">
                                                        <input type="radio" id="plt{{ $key }}" class="purpose"  value="{{ $key }}" name="purpose_0[]" {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                                        <label for="plt{{ $key }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="hidden_purpose[]" class="hidden_purpose" value="1">
                                                    
                                                    <div class="mt-3">
                                                        <h5 class="text-black">Property Type:</h5>
                                                    </div>
                                                    
                                                    @foreach($type_of_property as $key => $value)
                                                    <div class="radio  mt-1">
                                                        <input type="radio" id="tofp{{ $key }}" class="property_type"  value="{{ $key }}" name="property_type_0[]" {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                                        <label for="tofp{{ $key }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="hidden_property_type[]" class="hidden_property_type" value="1">
                                                    
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Property Address <span class="text-danger">*</span></label>
                                             <input type="text" name="property_address[]" class="form-control property_address" id="property_address" placeholder="Property Address" value="" >
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Property Value <span class="text-danger">*</span></label>
                                             <input type="text" name="property_value[]" class="form-control currency-input" id="property_value" placeholder="Property Value" value="" maxlength="15" >
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript: void(0);" id="" class="remove-property d-none btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                            </a> 
                                            <a href="javascript: void(0);" id="" class="add-more-property mr-2  btn btn-xs btn-info float-right text-white">  <i class="mdi mdi-plus"></i> Add more Property/Security
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row inqtype-3 loan-form-page" style="display:none;">
                            <div class="col-lg-12">
                                <h3 class="text-success">Crypto/Security</h3>
                            </div>
                            
                            <div class="col-lg-12" id="crypto-sections-container">
                                <div class="d-crypto-sec">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type of Crypto / Security? <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="hidden" name="crypto_hidden_purpose[]" class="crypto_hidden_purpose" value="1">
                                                    <input type="hidden" id="crypto_property_address" name="crypto_property_address[]" class="crypto_property_address" value="VIC">
                                                    
                                                    <div class="mt-3">
                                                        <h5 class="text-black">Crypto Type:</h5>
                                                    </div>
                                                    
                                                    @foreach($property_loan_types_1 as $key => $value)
                                                    <div class="radio mt-1">
                                                        <input type="radio" id="tofp-{{ $key }}" class="crypto_property_type"  value="{{ $key }}" name="crypto_property_type_0[]" {{ ($key == 1) ? 'checked="checked"' : '' }}>
                                                        <label for="tofp-{{ $key }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="crypto_hidden_property_type[]" class="crypto_hidden_property_type" value="1">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Crypto Value <span class="text-danger">*</span></label>
                                             <input type="text" name="crypto_property_value[]" class="form-control currency-input" id="crypto_property_value" placeholder="Crypto Value" value="" maxlength="15" >
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript: void(0);" id="" class="remove-crypto d-none btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                            </a> 
                                            <a href="javascript: void(0);" id="" class="add-more-crypto mr-2  btn btn-xs btn-info float-right text-white">  <i class="mdi mdi-plus"></i> Add more Crypto/Security
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="text-success">Applicant/Director/Proprietor Personal Financial Information</h3>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="d-fin-wrapper assets-members">
                                    <h4 class="text-left">
                                       Assets
                                    </h4>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Property (Residential Property) <span class="text-danger">*</span></label>
                                             <input type="text" name="asset_property_primary_residence[]" class="form-control currency-input" value="" id="asset_property_primary_residence" placeholder="Property (Residential Property)">
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Property (Other) <span class="text-danger">*</span></label>
                                             <input type="text" name="asset_property_other[]" class="form-control currency-input" id="asset_property_other" value="" placeholder="Property (Other)">
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Bank Account Balance <span class="text-danger">*</span></label>
                                             <input type="text" name="asset_bank_account[]" class="form-control currency-input" id="asset_bank_account" placeholder="Bank Account Balance" value="">
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Super (s) <span class="text-danger">*</span></label>
                                             <input type="text" name="asset_super[]" class="form-control currency-input" id="asset_super" placeholder="Super (s)" value="">
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Other Assets <span class="text-danger">*</span></label>
                                             <input type="text" name="asset_other[]" class="form-control currency-input" id="asset_other" placeholder="Other Assets" value="">
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <h4 class="text-left">
                                       Liabilities
                                    </h4>
            
                                    <div class="table-responsive mb-2" style="overflow-x: inherit;">
                                        <table class="table table-bordered mb-0 table-borderless">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Limit</th>
                                                <th>Repayment/Month</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Home Loan Liabilities <span class="text-danger">*</span></td>
                                                <td class="input-pos-relative"> 
                                                   <input type="text" name="liability_homeloan_limit[]" class="form-control currency-input" id="liability_homeloan_limit" placeholder="Limit Amount" value="">
                                                   <span class="currency-symbol">$</span>
                                                </td>
                                                <td class="input-pos-relative">
                                                   <input type="text" name="liability_homeloan_repayment[]" class="form-control currency-input" id="liability_homeloan_repayment" placeholder="Repayment/Month Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Other Loan Liabilities <span class="text-danger">*</span></td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_otherloan_limit[]" id="liability_otherloan_limit" placeholder="Limit Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_otherloan_repayment[]" id="liability_otherloan_repayment" placeholder="Repayment/Month Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Credit Card (All Cards) <span class="text-danger">*</span></td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_all_card_limit[]" id="liability_all_card_limit" placeholder="Limit Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_all_card_repayment[]" id="liability_all_card_repayment" placeholder="Repayment/Month Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Car/Personal Loans (All Loans) <span class="text-danger">*</span></td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" id="liability_car_personal_limit" name="liability_car_personal_limit[]" placeholder="Limit Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" id="liability_car_personal_repayment" name="liability_car_personal_repayment[]" placeholder="Repayment/Month Amount" value="">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Any Other Expense <span class="text-danger">*</span></td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_living_expense_limit[]" value="" id="liability_living_expense_limit" placeholder="Limit Amount">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                                <td class="input-pos-relative">
                                                   <input type="text" class="form-control currency-input" name="liability_living_expense_repayment[]" value="" id="liability_living_expense_repayment" placeholder="Repayment/Month Amount">
                                                    <span class="currency-symbol">$</span>
                                                </td>
                                            </tr>
                                             </tbody>
                                        </table>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        
                        @php
                            $document_types = config('constants.document_types');
                        @endphp
                        <div class="row document-page">
                            <div class="col-lg-12">
                                <h3 class="text-success">Document</h3>
                            </div>
                            
                            <div class="col-lg-12" id="settings">
                                @foreach($document_types as $key => $value)
                                    <div class="row mt-{{ ($key == 0) ? 0 : 3 }} {{ ($key == 3) ? 'inqtype1' : '' }}">
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
                              
                                    <div class="row gallery loanapplication {{ ($key == 3) ? 'inqtype1' : '' }}" id="position-{{ $key }}">
                                        
                                    </div>
                                 
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 text-right">
                            <hr>
                                <button class="btn btn-success mt-3" type="submit" id="form_loan_application_create_btn">Save</button>
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

$(document).ready(function () {
    $('#apply_for').val('2').trigger('change');
    // Clear all fields on load
    //$('input').val('');
    //$('textarea').val('');
    // Disable autocomplete on all inputs
    $('input').attr('autocomplete', 'off');
});


$(document).ready(function () {
    $('#know_about_us').on('change', function () {
        if ($(this).val() == '8') {
            $('#know_about_us_others').closest('.form-group').show();
        } else {
            $('#know_about_us_others').closest('.form-group').hide();
            $('#know_about_us_others').val(''); // Clear input if hidden
        }
    });

    // Trigger change on page load (e.g., for edit form)
    $('#know_about_us').trigger('change');
});
</script>

<script>

$('#apply_for').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue == 1) {
        $('.inqtype-1').show();
        $('.inqtype-2').hide();
        $('.inqtype-3').hide();
        $('.inqtype1').hide();
    }else if (selectedValue == 3) {
        $('.inqtype-3').show();
        $('.inqtype-1').hide();
        $('.inqtype-2').hide();
        $('.inqtype1').show();
    } else {
        $('.inqtype-2').show();
        $('.inqtype-1').hide();
        $('.inqtype-3').hide();
        $('.inqtype1').show();
    }
});

$(document).ready(function() {
    
    
    $('.inqtype-1').hide();
    
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
    $('.property_address').each(function() {
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

function initializeAutocompleteS(inputElement) {
    
    var options = {
        types: ['geocode'],
        componentRestrictions: { country: 'AU' }
    };
        
    var autocomplete = new google.maps.places.Autocomplete(inputElement, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        // Handle place data for both input fields
        console.log(place.address_components);
    });
}

function initializeAutocomplete_team(inputElement) {
    var options = {
        types: ['geocode'],
        componentRestrictions: { country: 'AU' }
    };

    var autocomplete = new google.maps.places.Autocomplete(inputElement, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();

        if (place.address_components) {
            var components = place.address_components;

            var address = {
                street_number: '',
                street_name: '',
                street_type: '',
                locality: '',
                state: '',
                postcode: ''
            };

            components.forEach(function(component) {
                if (component.types.includes("street_number")) {
                    address.street_number = component.long_name;
                }
                if (component.types.includes("route")) {
                    var routeParts = component.long_name.split(' ');
                    address.street_name = routeParts.slice(0, -1).join(' '); // All parts except the last
                    address.street_type = routeParts.slice(-1).join(''); // Last part
                }
                if (component.types.includes("locality")) {
                    address.locality = component.long_name;
                }
                if (component.types.includes("administrative_area_level_1")) {
                    address.state = component.short_name;
                }
                if (component.types.includes("postal_code")) {
                    address.postcode = component.long_name;
                }
            });

            // Populate hidden fields using jQuery
            /*$('#street_number').val(address.street_number);
            $('#street_name').val(address.street_name);
            $('#street_type').val(address.street_type);
            $('#locality').val(address.locality);
            $('#state').val(address.state);
            $('#postcode').val(address.postcode);*/
        }

        console.log('Address Components:', place.address_components);
    });
}


initializeAutocompleteS($(".business_address")[0]);
initializeAutocomplete_team($(".buz_address")[0]);

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
    /*$('#form_loan_application_create_btn').click(function () {
    var url = $('#form_loan_application_create_btn').closest('form').attr('action');
    $.ajax({
        type: 'POST',
        url: url,
        async: false,
        data: $('#form_loan_application_create_btn').closest('form').serialize(),
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (response) {
            if (response.status == 200) {
                $('#form_loan_application_create_btn').closest('form')[0].reset();
                toaserMessage(response.status, response.message);
                setTimeout(function () {
                    @php
                        $url = url('admin/users/loan-applications/'.Crypt::encrypt($user_id));
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

                // To store the first error field
                let firstErrorField = null;

                $.each(errors, function (field_name, error) {
                    var string = error[0];
                    var modifiedError = string.replace(/\.\d\s?/, ' ');
                    var error_text = modifiedError.replace(/_/g, ' ');

                    if (field_name === "business_trade_year" || field_name == "year_established" || field_name == "business_structure" || field_name == "trade") {
                        var field = $('select[name="' + field_name + '"]');
                        field.next('span').after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                        if (!firstErrorField) firstErrorField = field;
                    } else if (field_name == "brief_notes") {
                        var field = $('textarea[name="' + field_name + '"]');
                        field.after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                        if (!firstErrorField) firstErrorField = field;
                    } else if (field_name == "mobile_no" || field_name == "business_email" || field_name == "business_address" || field_name == "business_name" || field_name == "abn_acn" || field_name == "m_loan_amount" || field_name === "finance_periods" || field_name === "gross_income" || field_name === "total_expenses" || field_name === "net_income") {
                        var field = $('input[name="' + field_name + '"]');
                        field.after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                        if (!firstErrorField) firstErrorField = field;
                    } else {
                        var field = null;
                        var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                        var number = field_name.replace(/\D/g, "");

                        if (field === "title" || field === "residential_status" || field === "marital_status" || field === "time_in_business" || field === "time_at_business") {
                            field = $('.additional_clone').eq(number).find('select[name="' + field + '[]"]');
                            field.next('span').after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                        } else {
                            field = $('.additional_clone').eq(number).find('input[name="' + field + '[]"]');
                            field.after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');

                            if (!field.length) {
                                field = $('.d-property-sec').eq(number).find('input[name="' + field + '[]"]');
                                field.after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                            }

                            if (!field.length) {
                                field = $('.assets-members').eq(number).find('input[name="' + field + '[]"]');
                                field.after('<span class="help-block error-block text-danger"><small>' + error_text + '</small></span>');
                            }
                        }

                        if (!firstErrorField && field && field.length) {
                            firstErrorField = field;
                        }
                    }
                });

                // Focus on the first error field
                if (firstErrorField) {
                    $('html, body').animate({ scrollTop: firstErrorField.offset().top - 100 }, 500, function () {
                        firstErrorField.focus();
                    });
                }
            }
        }
    });
});*/

   /*$('#form_loan_application_create_btn').click(function(){
        var url = $('#form_loan_application_create_btn').closest('form').attr('action');
        $.ajax ({
            type: 'POST',
            url: url,
            async: false,
            data: $('#form_loan_application_create_btn').closest('form').serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success : function(response) {
                if(response.status == 200){
                    $('#form_loan_application_create_btn').closest('form')[0].reset();
                    toaserMessage(response.status, response.message);
                    setTimeout(function(){ 
                        @php
                            $url = url('admin/users/loan-applications/'.Crypt::encrypt($user_id));
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
        
                        if (field_name === "business_trade_year" || field_name == "year_established" || field_name == "business_structure" || field_name == "trade" || field_name == "know_about_us") {
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
    });*/
    
$('#form_loan_application_create_btn').click(function(){
    var url = $('#form_loan_application_create_btn').closest('form').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        async: false,
        data: $('#form_loan_application_create_btn').closest('form').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(response.status == 200){
                $('#form_loan_application_create_btn').closest('form')[0].reset();
                toaserMessage(response.status, response.message);
                setTimeout(function(){ 
                    @php
                        $url = url('admin/users/loan-applications/'.Crypt::encrypt($user_id));
                    @endphp
                    window.location.href = "{{ $url }}"; 
                }, 2000);
            }
        },
        error: function (reject) {
            if (reject.status === 422) {
                var errors = $.parseJSON(reject.responseText).errors;
                
                $('.help-block').text('');
                
                let firstErrorField = null; // 🔹 Capture first error field
                
                $.each(errors, function (field_name, error) {
                    let string = error[0];
                    let modifiedError = string.replace(/\.\d\s?/, ' ');
                    let error_text = modifiedError.replace(/_/g, ' ');

                    let fieldElement = null;

                    // SINGLE FIELDS
                    if (field_name === "business_trade_year" || field_name == "year_established" || field_name == "business_structure" || field_name == "trade" || field_name == "know_about_us") {
                        fieldElement = $('select[name="'+field_name+'"]');
                        fieldElement.next('span').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                    }
                    else if (field_name == "brief_notes") {
                        fieldElement = $('textarea[name="'+field_name+'"]');
                        fieldElement.after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                    }
                    else if (field_name == "mobile_no" || field_name == "business_email" || field_name == "business_address" || field_name == "business_name" || field_name == "abn_acn" || field_name == "m_loan_amount" || field_name === "finance_periods" || field_name === "gross_income" || field_name === "total_expenses" || field_name === "net_income") {
                        fieldElement = $('input[name="'+field_name+'"]');
                        fieldElement.after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                    }
                    else {
                        // ARRAY FIELDS
                        var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                        var number = field_name.replace(/\D/g, "");

                        if (field === "title" || field === "residential_status" || field === "marital_status" || field === "time_in_business" || field === "time_at_business") {
                            fieldElement = $('.additional_clone').eq(number).find('select[name="'+field+'[]"]');
                            fieldElement.next('span').after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        } else {
                            fieldElement = $('.additional_clone').eq(number).find('input[name="'+field+'[]"]');

                            if (!fieldElement.length) {
                                fieldElement = $('.d-property-sec').eq(number).find('input[name="'+field+'[]"]');
                            }
                            if (!fieldElement.length) {
                                fieldElement = $('.assets-members').eq(number).find('input[name="'+field+'[]"]');
                            }

                            fieldElement.after('<span class="help-block error-block text-danger"><small>'+error_text+'</small></span>');
                        }
                    }

                    if (firstErrorField === null && fieldElement && fieldElement.length > 0) {
                        firstErrorField = fieldElement;
                    }
                });

                if (firstErrorField) {
                    $('html, body').animate({
                        scrollTop: firstErrorField.offset().top - 100
                    }, 400);
                    firstErrorField.focus();
                }
            }
        }
    });
});
</script>
@endsection