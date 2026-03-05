@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
@section('styles')
   @if(request()->is('loan*'))
        <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
        <link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style type="text/css" media="screen">
           .loan-form-page .select2-container--default .select2-selection--single{height:calc(1.5em + 0.9rem + 2px);padding:5px;border:1px solid #ccc}
           .loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow{top:5px}
           .loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered{color:#444444b8}
           .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{background-color:#2eab99!important;color:white}
           .d-fin-wrapper,.d-property-sec{border:1px solid #eee;padding:20px;border-radius:5px;margin-bottom:20px}
           hr{border-top:2px solid #1369589e}
        </style>
   @endif

@endsection
@section('content')
<div class="content loan-form-page">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row mt-4">
          <div class="col-md-5 col-xl-3 cu-applisidebar cleft">
             <div class="card-box color-knote">
               <h3 class="text-white text-uppercase">Start application</h3>
               <div class="tab-content">
                   @include('partials.comman.loan.leftsidebar')
               </div>
            </div> 
           
         </div>
         <div class="col-md-7 col-xl-6">
            <div class="card-box">
                @php
                    $titles_vals = [
                        1 => 'Business Financial Information',
                        2 => 'Property/Security',
                        3 => 'Crypto/Security',
                    ];
                @endphp
               <h3>{{ $titles_vals[$application->apply_for] ?? '' }}</h3>
               <div class="tab-content pt-0">
                  <div class="tab-pane active" id="settings">

                     <form action="{{ url()->current() }}" id="loan-application-third" name="loan-application-third" method="post" onsubmit="return false;">
                        
                        @if($application->apply_for == 2)
                        @php
                            $property_loan_types = config('constants.property_loan_types');
                            $type_of_property = config('constants.type_of_property');
                        @endphp
                        <div id="property-sections-container">
                            @forelse($application->property_securities as $key_property => $property)
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
                                                    <div class="radio mt-1">
                                                        <input type="radio" class="purpose" value="{{ $key }}" id="plt_{{ $key }}_{{ $key_property }}" name="purpose_{{ $key_property }}[]" {{ ($property->purpose == $key) ? 'checked="checked"' : '' }}>
                                                        <label for="plt_{{ $key }}_{{ $key_property }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="hidden_purpose[]" class="hidden_purpose" value="{{ $property->purpose }}">
                                                     
                                                    <div class="mt-3">
                                                        <h5 class="text-black">Property Type:</h5>
                                                    </div>
                                                    
                                                    
                                                    @foreach($type_of_property as $key => $value)
                                                    <div class="radio  mt-1">
                                                        <input type="radio" class="property_type" value="{{ $key }}" id="tofp_{{ $key }}_{{ $key_property }}" value="{{ $key }}" name="property_type_{{ $key_property }}[]" {{ ($property->property_type == $key) ? 'checked="checked"' : '' }}>
                                                        <label for="tofp_{{ $key }}_{{ $key_property }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    
                                                    <input type="hidden" name="hidden_property_type[]" class="hidden_property_type" value="{{ $property->property_type }}">
                                                    
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="">Property Address <span class="text-danger">*</span></label>
                                             <input type="text" name="property_address[]" class="form-control property_address" id="business_address" placeholder="Property Address" value="{{ $property->property_address }}" >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Property Value <span class="text-danger">*</span></label>
                                             <input type="text" name="property_value[]" class="form-control currency-input" id="property_value" placeholder="Property Value" value="{{ $property->property_value }}" maxlength="15" >
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript: void(0);" id="" class="{{ ($loop->last) ? 'd-none' : '' }} remove-property btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                            </a> 
                                           
                                            <a href="javascript: void(0);" id="" class="{{ (!$loop->last) ? 'd-none' : '' }} add-more-property mr-2  btn btn-xs btn-info float-right text-white">  <i class="mdi mdi-plus"></i> Add more Property/Security
                                            </a> 
                                            
                                        </div>
                                    </div>
                                </div>
                            @empty
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
                                             <input type="text" name="property_address[]" class="form-control property_address" id="business_address" placeholder="Property Address" value="{{ isset($application->finance_information) ? $application->finance_information->property_address : '' }}" >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Property Value <span class="text-danger">*</span></label>
                                             <input type="text" name="property_value[]" class="form-control currency-input" id="property_value" placeholder="Property Value" value="{{ isset($application->finance_information) ? number_format($application->finance_information->property_value) : '' }}" maxlength="15" >
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
                            @endforelse
                        </div>
                        @endif
                        
                        @if($application->apply_for == 3)
                        @php
                            $type_of_property = config('constants.type_of_crypto');
                        @endphp
                        <div id="property-sections-container">
                            @forelse($application->property_securities as $key_property => $property)
                                <div class="d-property-sec">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type of Crypto / Security? <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="hidden" name="hidden_purpose[]" class="hidden_purpose" value="1">
                                                    <input type="hidden" name="property_address[]" class="form-control property_address" id="business_address" value="VIC" >
                                                    <div class="mt-3">
                                                        <h5 class="text-black">Crypto Type:</h5>
                                                    </div>
                                                    @foreach($type_of_property as $key => $value)
                                                    <div class="radio  mt-1">
                                                        <input type="radio" class="property_type" value="{{ $key }}" id="tofp_{{ $key }}_{{ $key_property }}" value="{{ $key }}" name="property_type_{{ $key_property }}[]" {{ ($property->property_type == $key) ? 'checked="checked"' : '' }}>
                                                        <label for="tofp_{{ $key }}_{{ $key_property }}"> {{ ucfirst($value) }} </label>
                                                    </div>
                                                    @endforeach
                                                    <input type="hidden" name="hidden_property_type[]" class="hidden_property_type" value="{{ $property->property_type }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group input-pos-relative">
                                             <label for="">Crypto Value <span class="text-danger">*</span></label>
                                             <input type="text" name="property_value[]" class="form-control currency-input" id="property_value" placeholder="Crypto Value" value="{{ $property->property_value }}" maxlength="15" >
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript: void(0);" id="" class="{{ ($loop->last) ? 'd-none' : '' }} remove-property btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                            </a> 
                                           
                                            <a href="javascript: void(0);" id="" class="{{ (!$loop->last) ? 'd-none' : '' }} add-more-property mr-2  btn btn-xs btn-info float-right text-white">  <i class="mdi mdi-plus"></i> Add more Crypto/Security
                                            </a> 
                                            
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="d-property-sec">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Type of Crypto / Security? <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="hidden" name="hidden_purpose[]" class="hidden_purpose" value="1">
                                                    <input type="hidden" name="property_address[]" class="property_address" value="VIC">
                                                    <div class="mt-3">
                                                        <h5 class="text-black">Crypto Type:</h5>
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
                                          <div class="form-group input-pos-relative">
                                             <label for="">Crypto Value <span class="text-danger">*</span></label>
                                             <input type="text" name="property_value[]" class="form-control currency-input" id="property_value" placeholder="Crypto Value" value="{{ isset($application->finance_information) ? number_format($application->finance_information->property_value) : '' }}" maxlength="15" >
                                             <span class="currency-symbol">$</span>
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="javascript: void(0);" id="" class="remove-property d-none btn btn-xs btn-danger float-right text-white">  <i class="mdi mdi-minus"></i>
                                            </a> 
                                            <a href="javascript: void(0);" id="" class="add-more-property mr-2  btn btn-xs btn-info float-right text-white">  <i class="mdi mdi-plus"></i> Add more Crypto/Security
                                            </a> 
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @endif
                        
                        
                        @if($application->apply_for == 1)
                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group">

                                 <label for="" class="">&nbsp;</label>
                                 @php
                                 $finance_periods = config('constants.finance_periods');
                                 @endphp
                                 @foreach($finance_periods as $key => $value)
                                 <div class="radio form-check-inline">
                                    <input type="radio" id="inlineRadio{{ $key }}" value="{{ $key }}" name="finance_periods" 
                                    @if(!empty($application->finance_information))
                                       {{ ($application->finance_information->finance_periods == $key) ? 'checked="checked"' : '' }} 
                                    @else
                                       {{ ($key == 1) ? 'checked="checked"' : '' }}
                                    @endif
                                    >
                                    <label for="inlineRadio{{ $key }}"> {{ ucfirst($value) }} </label>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Business Trade Year <span class="text-danger">*</span></label>
                                 <select class="custom-select" name="business_trade_year">
                                    <option value="">Select..</option>
                                    @for($i= (date('Y') - 3); $i<=date('Y'); $i++)
                                       <option value="{{ $i }}" 
                                       @if(!empty($application->finance_information))
                                       {{ ($application->finance_information->business_trade_year == $i) ? 'selected' : '' }}
                                       @endif
                                      >{{ $i }}</option>
                                    @endfor
                                 </select>
                              </div>
                           </div>
                           
                           
                        </div>
                        <div class="row">
                           
                           <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Gross Income <span class="text-danger">*</span></label>
                                 <input type="text" class="form-control currency-input" name="gross_income" id="" placeholder="Gross Income" value="@if(!empty($application->finance_information)){{ number_format($application->finance_information->gross_income) }}
                                 @endif">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                           
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Total Expenses <span class="text-danger">*</span></label>
                                 <input type="text" name="total_expenses" class="form-control currency-input" id="" placeholder="Total Expenses" value="@if(!empty($application->finance_information)){{ number_format($application->finance_information->total_expenses) }}@endif">
                                 <span class="currency-symbol">$</span>
                                 <span class="help-block"><small>Including contractor, stock and sale</small></span>
                              </div>
                           </div> 
                           <div class="col-md-6">
                              <div class="form-group input-pos-relative">
                                 <label for="">Net Income <span class="text-danger">*</span></label>
                                 <input type="text" name="net_income" class="form-control currency-input" id="" placeholder="Net Income" value="@if(!empty($application->finance_information)){{ number_format($application->finance_information->net_income) }}@endif">
                                 <span class="currency-symbol">$</span>
                              </div>
                           </div>
                        </div>
                        @endif
                        
                        
                        <!--<h4 class="header-title mt-4 font-22">Directors Personal Financial information</h4>-->
                        <!--<hr>-->
                        
                        @forelse($application->team_sizes as $key_team => $team)
                            <h4 class="header-title mb-2 font-22">Personal statement of {{ $team->position }}</h4>
                            @php
                                $f_exp_row = App\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
                            @endphp
                            <div class="d-fin-wrapper">
                                <h4 class="text-left">
                                   Assets
                                </h4>
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group input-pos-relative">
                                         <label for="">Property (Residential Property)</label>
                                         <input type="text" name="asset_property_primary_residence[]" class="form-control currency-input" value="@if($f_exp_row != null){{ number_format($f_exp_row->asset_property_primary_residence) }}@endif" id="" placeholder="Property (Residential Property)">
                                         <span class="currency-symbol">$</span>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                      <div class="form-group input-pos-relative">
                                         <label for="">Property (Other)</label>
                                         <input type="text" name="asset_property_other[]" class="form-control currency-input" id="" value="@if($f_exp_row != null){{ number_format($f_exp_row->asset_property_other) }}@endif" placeholder="Property (Other)">
                                         <span class="currency-symbol">$</span>
                                      </div>
                                   </div>
                                </div>
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group input-pos-relative">
                                         <label for="">Bank Account Balance</label>
                                         <input type="text" name="asset_bank_account[]" class="form-control currency-input" id="" placeholder="Bank Account Balance" value="@if($f_exp_row != null){{ number_format($f_exp_row->asset_bank_account) }}@endif">
                                         <span class="currency-symbol">$</span>
                                      </div>
                                   </div>
                                   <div class="col-md-6">
                                      <div class="form-group input-pos-relative">
                                         <label for="">Super (s)</label>
                                         <input type="text" name="asset_super[]" class="form-control currency-input" id="" placeholder="Super (s)" value="@if($f_exp_row != null){{ number_format($f_exp_row->asset_super) }}@endif">
                                         <span class="currency-symbol">$</span>
                                      </div>
                                   </div>
                                </div>
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group input-pos-relative">
                                         <label for="">Other Assets</label>
                                         <input type="text" name="asset_other[]" class="form-control currency-input" id="" placeholder="Other Assets" value="@if($f_exp_row != null){{ number_format($f_exp_row->asset_other) }}@endif">
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
                                            <td>Home Loan Liabilities</td>
                                            <td class="input-pos-relative"> 
                                               <input type="text" name="liability_homeloan_limit[]" class="form-control currency-input" id="" placeholder="Limit Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_homeloan_limit) }}@endif">
                                               <span class="currency-symbol">$</span>
                                            </td>
                                            <td class="input-pos-relative">
                                               <input type="text" name="liability_homeloan_repayment[]" class="form-control currency-input" id="" placeholder="Repayment/Month Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_homeloan_repayment) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other Loan Liabilities</td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_otherloan_limit[]" id="" placeholder="Limit Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_otherloan_limit) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_otherloan_repayment[]" id="" placeholder="Repayment/Month Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_otherloan_repayment) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Credit Card (All Cards)</td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_all_card_limit[]" id="" placeholder="Limit Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_all_card_limit) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_all_card_repayment[]" id="" placeholder="Repayment/Month Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_all_card_repayment) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Car/Personal Loans (All Loans)</td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" id="" name="liability_car_personal_limit[]" placeholder="Limit Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_car_personal_limit) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" id="" name="liability_car_personal_repayment[]" placeholder="Repayment/Month Amount" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_car_personal_repayment) }}@endif">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Any Other Expense</td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_living_expense_limit[]" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_living_expense_limit) }}@endif" id="" placeholder="Limit Amount">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                            <td class="input-pos-relative">
                                               <input type="text" class="form-control currency-input" name="liability_living_expense_repayment[]" value="@if($f_exp_row != null){{ number_format($f_exp_row->liability_living_expense_repayment) }}@endif" id="" placeholder="Repayment/Month Amount">
                                                <span class="currency-symbol">$</span>
                                            </td>
                                        </tr>
                                         </tbody>
                                    </table>
                                </div>
    
                            </div>
                            
                            <input type="hidden" id="team-{{ $team->id }}" name="team_size_id[]" value="{{ $team->id }}">
                        @endforeach


                        <input type="hidden" name="application_id" value="{{ $application->id }}" >
                        <input type="hidden" name="finance_id" value="{{ !empty($application->finance_information) ? $application->finance_information->id : '' }}" >


                        @if($enc_id == "")
                           <div class="text-center">
                              <a href="{{ route('loan.create.people') }}" class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>
                                &nbsp; Previous
                                 </a>
                              <button type="submit" data-url="{{ url()->current() }}" data-redirect="{{ url('loan/create/document') }}" id="pr-third" class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                           </div>
                        @else
                           <div class="text-center">
                              <a href="{{ url('loan/edit/people/'.$enc_id) }}" class="btn btn-light waves-effect waves-light mt-2"><i class="fe-arrow-left"></i>&nbsp; Previous
                                 </a>
                              <button type="submit" data-url="{{ url('loan/create/finance') }}" data-redirect="{{ url('loan/edit/document/'.$enc_id) }}" id="pr-third" class="btn btn-success waves-effect waves-light mt-2 ml-2">Next<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                           </div>
                        @endif
                     </form>

                  </div>
                  <!-- end settings content-->
               </div>
               <!-- end tab-content -->
            </div>
         </div>
         <div class="col-md-7 col-xl-3 cu-applisidebar cright">
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
        $('select').select2();
        
        // var options = {
        //   types: ['geocode'],
        //   componentRestrictions: { country: 'AU' }
        // };
        
        // var autocomplete = new google.maps.places.Autocomplete($("#business_address")[0], options);
        
        // google.maps.event.addListener(autocomplete, 'place_changed', function() {
        //     var place = autocomplete.getPlace();
        // });
        
        function initializeAutocomplete() {
            $('.property_address').each(function() {
                var options = {
                    types: ['geocode'],
                    componentRestrictions: { country: 'AU' }
                };
    
                var autocomplete = new google.maps.places.Autocomplete(this, options);
                
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    // Process the place object if needed
                });
            });
        }

        // Initialize autocomplete for existing address inputs
        initializeAutocomplete();
            
    </script>
   @endif
@endsection