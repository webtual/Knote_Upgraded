@extends('layouts._comman')
@section('title', 'Consent Your Loan Application - Knote')
@section('styles')
@if(request()->is('loan*'))
<link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
<link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
@endif
@endsection
@section('content')
<div class="content" id="review">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row mt-4">
          <div class="col-md-5 col-xl-3 cu-applisidebar cleft">
             <div class="card-box color-knote">
               <h3 class="text-white text-uppercase">Applicant Details</h3>
                <div class="text-left mt-5">
                    <h2 class="mt-2 mb-1 text-white font-26">{{ $application->application_number }}</h2>
                    <h3 class="mt-2 mb-1 text-white font-20">{{ $application->user->name }}</h3>
                    <h3 class="mt-2 mb-1 text-white font-20">{{ display_aus_phone($application->user->phone) }}</h3>
                    <h3 class="mt-2 mb-1 text-white font-20">{{ $application->user->email }}</h3>
                </div>
            </div> 
         </div>
         <div class="col-md-7 col-xl-6">
            <div class="card-box loan-review">
            	@php
                    use App\User;
                    $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                    $know_about_us_val = $application->know_about_us == 8 ? $application->know_about_us_others : ($KNOW_ABOUT_US_VAL[$application->know_about_us] ?? '');
                @endphp
            	<div class="section-header">
            		<h2 class="header-title">Review [{{ $application->current_status->status }}]</h2>
            	</div>
            	<div class="review-page">
                  <div class="tab-pane active" id="settings">
                     <form action="{{ url('loan/consent-save') }}" id="loan-application-five-consent" name="loan-application-five-consent" method="post" onsubmit="return false;">
                        
                        <div class="mb-3">
                        	<h3 class="header-title font-18 border-bottom border-success pb-2">Business Information</h3>
                        	<div class="table-responsive mt-2">
                        		
                        		<div class="basic-info review-section">
		                        	<div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Business Name : </strong>
		                              <span class="mb-2">{{ $application->business_name }}</span>
		                        	</div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">ABN or ACN : </strong>
		                              <span class="mb-2">{{ $application->abn_or_acn }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Loan Requested : </strong>
		                              <span class="mb-2">{{ $application->loan_request_amount() }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Business Structure : </strong>
		                              <span class="mb-2">{{ $application->business_structure->structure_type }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Year Established : </strong>
		                              <span class="mb-2">{{ $application->years_of_established }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Business Address : </strong>
		                              <span class="mb-2">{{ $application->business_address }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Mailing Address : </strong>
		                              <span class="mb-2">{{ $application->business_email }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Mobile : </strong>
		                              <span class="mb-2">{{ display_aus_phone($application->business_phone) }}</span>
		                           </div>
		
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Landline : </strong>
		                              <span class="mb-2">{{ display_aus_landline($application->landline_phone) }}</span>
		                           </div>
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">Industry : </strong>
		                              <span class="mb-2">{{ $application->business_type->business_type }}</span>
		                           </div>
		                           <div class="mb-0 ">
		                              <strong class="font-13 text-muted  mb-1">How did you know about us? : </strong>
		                              <span class="mb-2">{{ $know_about_us_val }}</span>
		                           </div>
                        		</div>
                        	</div>
                        </div>
                        
                        <div class="mb-3">
                        
                        	<h3 class="header-title font-18 border-bottom border-success pb-2">Applicant/Director/Proprietor</h3>
                        		<div class="basic-info review-section">
			                        @forelse($application->team_sizes as $key_team => $team)
			                        <div class="mb-2 font-15 mt-2 font-weight-bold text-success">Applicant/Director/Proprietor : {{ $key_team+1 }}</div>
			                        
			                           <div class="row">
			                              <div class="col-xl-6">
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Name : </strong>
			                                    <span class="mb-2">{{ config('constants.people_title')[$team->title].' '.$team->firstname.' '.$team->lastname }}</span>
			                                 </div>
			                                 @php
                                                $genderMap = config('constants.gender');
                                                $gender = $team->gender ?? null;
                                             @endphp
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Gender : </strong>
			                                    <span class="mb-2">{{ $genderMap[$gender] ?? '-' }}</span>
			                                 </div>
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Residential Address : </strong>
			                                    <span class="mb-2">{{ $team->address }}</span>
			                                 </div>
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Residential Status : </strong>
			                                    <span class="mb-2">@if($team->residential_status != null)
			                                       {{ config('constants.residential_status')[$team->residential_status] }}
			                                       @endif</span>
			                                 </div>
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Marital Status : </strong>
			                                    <span class="mb-2">@if($team->marital_status != null)
			                                       {{ config('constants.marital_status')[$team->marital_status] }}
			                                       @endif</span>
			                                 </div>
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">Date of Birth : </strong>
			                                    <span class="mb-2">{{ indian_date_format($team->dob) }}</span>
			                                 </div>
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Time at Address : </strong>
			                                    <span class="mb-2">{{ ($team->time_at_business == "") ? '' : $team->time_at_business.' Years' }}</span>
			                                 </div>
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">Time in Business : </strong>
			                                    <span class="mb-2">{{ ($team->time_in_business == "") ? '' : $team->time_in_business.' Years' }}</span>
			                                 </div>
			                              </div>
			
			                              <div class="col-xl-6">
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">Position : </strong>
			                                    <span class="mb-2">{{ $team->position }}</span>
			                                 </div>
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">Email Address : </strong>
			                                    <span class="mb-2">{{ $team->email_address }}</span>
			                                 </div>
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">Mobile : </strong>
			                                    <span class="mb-2">{{ display_aus_phone($team->mobile) }}</span>
			                                 </div>
			
			                                 <div class="mb-0 ">
			                                    <strong class="font-13 text-muted  mb-1">Landline : </strong>
			                                    <span class="mb-2">{{ display_aus_landline($team->landline) }}</span>
			                                 </div>
			
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">License Number : </strong>
			                                    <span class="mb-2">{{ $team->license_number }}</span>
			                                 </div>
			
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">License Expiry Date : </strong>
			                                    <span class="mb-2">{{ indian_date_format($team->license_expiry_date) }}</span>
			                                 </div>
			                                 
			                                 <div class="mb-0">
			                                    <strong class="font-13 text-muted  mb-1">License Card Number : </strong>
			                                    <span class="mb-2">{{ ($team->card_number) }}</span>
			                                 </div>
			                                 
			
			                              </div>
			                           </div>
			                        
			                        @empty
			                        @endforelse
			                    </div>
		                </div> 
		                
		                <div class="mb-3">
		                    
		                    @if($application->apply_for == 1)
	                        <h3 class="header-title font-18 border-bottom border-success pb-2">Business Financial Information @if(!empty($application->finance_information)) {{ '('.config('constants.finance_periods')[$application->finance_information->finance_periods].' - '.$application->finance_information->business_trade_year.')' }} @endif
	                        </h3>
	                        @else
	                         @php
                                $titles_vals = [
                                    1 => 'Business Financial Information',
                                    2 => 'Property/Security',
                                    3 => 'Crypto/Security',
                                ];
                            @endphp
	                        <h3 class="header-title font-18 border-bottom border-success pb-2">{{ $titles_vals[$application->apply_for] ?? '' }}</h3>
	                        @endif
	                        
	                        <div class="basic-info">
	                            
	                            @if($application->apply_for == 1)
    		                        <div class="mb-0 ">
    		                           <strong class="font-13 text-muted  mb-1">Gross Income : </strong>
    		                           <span class="mb-2"> @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->gross_income) }} 
    		                                       @endif</span>
    		                        </div>
    		
    		                        <div class="mb-0 ">
    		                           <strong class="font-13 text-muted  mb-1">Total Expense : </strong>
    		                           <span class="mb-2">  @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->total_expenses) }} 
    		                                       @endif</span>
    		                        </div>
    		
    		                        <div class="mb-0 ">
    		                           <strong class="font-13 text-muted  mb-1">Net Income : </strong>
    		                           <span class="mb-2"> @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->net_income) }} 
    		                                       @endif</span>
    		                        </div>
		                        @else
		                        
    		                        @if($application->property_securities->count() > 0)
        		                        @php
                                            $type_of_property = config('constants.type_of_property');
                                            if($application->apply_for == 2){
                                                $property_loan_types = config('constants.property_loan_types');
                                            }else{
                                                $property_loan_types = config('constants.type_of_crypto');
                                            }
                                        @endphp
                                        
                                        @if($application->apply_for == 2)
            		                        <div class="wrapper-pro-securities">
            		                            @foreach($application->property_securities as $key_property => $property)
            		                            <div class="d-property-sec-review">
            		                                <div class="mb-0 ">
                    		                            <strong class="font-13 text-muted  mb-1">Type of Property / Security : </strong>
                    		                            <span class="mb-2"> 
                    		                                {{ ($property_loan_types[$property->purpose])  }} - {{ ($type_of_property[$property->property_type]) }}
                    		                            </span>
                    		                        </div>
                    		
                    		                        <div class="mb-0">
                    		                           <strong class="font-13 text-muted  mb-1">Property Address : </strong>
                    		                           <span class="mb-2"> {{ ($property->property_address) }} </span>
                    		                        </div>
                    		                        
                    		                        <div class="mb-0">
                    		                           <strong class="font-13 text-muted  mb-0">Property Value : </strong>
                    		                           <span class="mb-0">  {{ money_format_amount($property->property_value) }}</span>
                    		                        </div>
            		                            </div>
            		                            @endforeach
            		                        </div>
        		                        @endif
        		                        
        		                        @if($application->apply_for == 3)
            		                        <div class="wrapper-pro-securities">
            		                            @foreach($application->property_securities as $key_property => $property)
            		                            <div class="d-property-sec-review">
            		                                <div class="mb-0 ">
                    		                            <strong class="font-13 text-muted  mb-1">Type of Crypto / Security : </strong>
                    		                            <span class="mb-2"> 
                    		                                {{ ($property_loan_types[$property->property_type]) }}
                    		                            </span>
                    		                        </div>
                    		                        <div class="mb-0">
                    		                           <strong class="font-13 text-muted  mb-0">Crypto Value : </strong>
                    		                           <span class="mb-0">  {{ money_format_amount($property->property_value) }}</span>
                    		                        </div>
            		                            </div>
            		                            @endforeach
            		                        </div>
        		                        @endif
        		                        
    		                        @endif
		                        
		                        
		                        @endif
		                        
		                        
		                        @forelse($application->team_sizes as $key_team => $team)
                        
                                @php
                                    $f_exp_row = App\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
                                @endphp
                                
                                <div class="mb-2 font-15 mt-2 font-weight-bold text-success">Directors Personal Financial information : {{ $key_team+1 }}</div>
                                
		                        <h4 class="mt-3"><strong>Assets</strong></h4>
		
		                        <div class="mb-0 ">
		                           <strong class="font-13 text-muted  mb-1">Property (Residential Property) : </strong>
		                           <span class="mb-2">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_primary_residence) }}@endif</span>
		                        </div>
		
		                        <div class="mb-0 ">
		                           <strong class="font-13 text-muted  mb-1">Property (Other) : </strong>
		                           <span class="mb-2">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_other) }}@endif</span>
		                        </div>
		
		                        <div class="mb-0 ">
		                           <strong class="font-13 text-muted  mb-1">Bank Account Balance(s) : </strong>
		                           <span class="mb-2">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_bank_account) }}@endif</span>
		                        </div>
		
		                        <div class="mb-0">
		                           <strong class="font-13 text-muted  mb-1">Super(s) : </strong>
		                           <span class="mb-2">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_super) }}@endif</span>
		                        </div>
		
		                        <div class="mb-0">
		                           <strong class="font-13 text-muted  mb-1">Other assets : </strong>
		                           <span class="mb-2">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_other) }}@endif</span>
		                        </div>
		                       
		                        <h4 class="mt-3 mb-0"><strong>Liabilities</strong></h4>
		                        
								<div class="review-liabilities">
    								<div class="row flex-nowrap ">
    									<div class="col-sm-5 col-9" >
    										<h5><strong>&nbsp;</strong></h5>
    				                        <div class="mb-0 ">
    				                           <strong class="font-13 text-muted  mb-1">Home Loan : </strong>
    				                        </div>
    				
    				                        <div class="mb-0">
    				                           <strong class="font-13 text-muted  mb-1">Other Loan : </strong>
    				                        </div>
    				
    				                        <div class="mb-0">
    				                           <strong class="font-13 text-muted  mb-1">Credit Card (All Cards) : </strong>
    				                        </div>
    				
    				                        <div class="mb-0">
    				                           <strong class="font-13 text-muted  mb-1">Car/Personal Loan (All Loan) : </strong>
    				                        </div>
    				
    				                        <div class="mb-0">
    				                           <strong class="font-13 text-muted  mb-1">Any Other Expense : </strong>
    				                        </div>
    				                    </div>
    				                    
    				                    <div class="col-3">
    			                          <h5><strong>Limit</strong></h5>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                        		 @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_limit) }}@endif
    			                        	</span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                            	@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_limit) }}@endif
    			                            </span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1"> 
    			                        		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_limit) }}@endif
    			                        	</span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	 <span class="font-13 mb-1">
    			                          		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_limit) }}@endif
    			                          	 </span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                        		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_limit) }}@endif
    			                        	</span>
    			                          </div>
    			                        </div>
    			                        
    			                        <div class="col-3">
    			                          <h5><strong>Repayment/Month</strong> </h5>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                        		 @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_repayment) }}@endif	
    			                        	</span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                            	@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_repayment) }}@endif
    			                            </span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1"> 
    			                        		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_repayment) }}@endif
    			                        	</span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	 <span class="font-13 mb-1">
    			                          		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_repayment) }}@endif
    			                          	 </span>
    			                          </div>
    			                          <div class="mb-0"> 
    			                        	<span class="font-13 mb-1">
    			                        		@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_repayment) }}@endif
    			                        	</span>
    			                          </div>
    			                        </div>
    				                </div>
				                
				                </div>
		                        
		                        @endforeach
		                    </div>
						</div>

                    	<div class="mb-3">
	                        <h3 class="header-title font-18 border-bottom border-success pb-2">Document</h3>
	                        <div class="table-responsive mt-2">
	                            
	                            
	                           <table class="table borderless mb-0">
	                              <tbody>
	                                  
	                                   @php
                                            $document_types = config('constants.document_types');
                                            if($application->apply_for == 1){
                                                unset($document_types['3']);
                                            }
                                        @endphp
                                        
	                                 @foreach($document_types as $key => $value)
	                                 <tr>
	                                    <td class="review-tab-color-font" rowspan="{{ $application->get_documents_by_type($key)->count() + 1 }}">{{ $value }} : </td>
	                                    <td>
	                                       @if($application->get_documents_by_type($key)->count() != 0)
	                                       <a class="text-success" href="{{ asset('storage/'.$application->get_documents_by_type($key)->first()['file']) }}" target="blank">{{ $value.' - 1' }}</a>
	                                       @endif
	                                    </td>
	                                 </tr>
	                                 @if(!empty($application->get_documents_by_type($key)))
	                                 @php
	                                 $count = 2;
	                                 $skip_count = 1;
	                                 @endphp
	                                 @foreach($application->get_documents_by_type($key) as $doc_key => $document)
	                                 @if($skip_count++ > 1)
	                                 <tr>
	                                    <td><a class="text-success" href="{{ asset('storage/'.$document->file) }}" target="blank">{{ $value.' - '.($count++) }}</a></td>
	                                 </tr>
	                                 @endif
	                                 @endforeach
	                                 @endif
	                              </tbody>
	                              @endforeach
	                           </table>
	                        </div>
                        
                            <div class="mb-3 mt-1">
                                <div class="mb-0">
		                            <strong class="font-13 text-muted  mb-1">Brief Notes : </strong>
		                            <span class="mb-2">{{ $application->brief_notes }}</span>
		                        </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3 mt-1">
                                        <div class="mb-0">
        		                            <strong class="font-13 text-muted  mb-1">IP Address : </strong>
        		                            <span class="mb-2">{{ $team_data->ip_address ?? $client_ip }}</span>
        		                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 mt-1">
                                        <div class="mb-0">
        		                            <strong class="font-13 text-muted  mb-1">Consent By : </strong>
        		                            <span class="mb-2">{{$team_data->firstname}} {{$team_data->lastname}}</span>
        		                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 mt-1">
                                        <div class="mb-0">
        		                            <strong class="font-13 text-muted  mb-1">Date & Time : </strong>
        		                            <span class="mb-2">
                                                {{ $team_data->verified_at ? display_date_format_time($team_data->verified_at) : date('d-m-Y h:i A') }}
                                            </span>
        		                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($team_data->consent_status == 0)
    	                        <h4 class="header-title mt-4 font-20">
    	                           <div class="checkbox checkbox-success mb-2 d-flex">
    	                              <input id="checkbox3" class="my-cu-check-uncheck ml-1" type="checkbox" value="1" name="privacy_policy" {{ ($team_data->consent_status == 1) ? 'checked="checked"' : '' }} >
    	                              <label for="checkbox3">
    	                              <a target="_blank" href="{{ config('constants.wp_privacy_policy') }}"  class="font-13 text-success text-capitalize"><b>I/We, Agree Privacy Information</b></a>
    	                              </label>
    	                           </div>
    	                        </h4>
    	                        <h4 class="header-title mt-1 font-20">
    	                           <div class="checkbox checkbox-success mb-2  d-flex">
    	                              <input id="checkbox4" type="checkbox" class="my-cu-check-uncheck ml-1" value="1" name="authority_to_obtain_credit_information" {{ ($team_data->consent_status == 1) ? 'checked="checked"' : '' }}>
    	                              <label for="checkbox4">
    	                              <a href="javascript:;"  data-toggle="modal" data-target=".bs-example-modal-lg-1" class="font-13 text-success text-capitalize"><b>Authority To Obtain Credit Information</b></a>                                       
    	                              </label>
    	                           </div>
    	                        </h4>
    	                    @endif
	                        
	                        <input type="hidden" name="application_id" value="{{ $application->id }}" >
	                        <input type="hidden" name="team_id" value="{{ $team_id }}" >
	                        <input type="hidden" name="ip_address" value="{{ $client_ip }}" >
	                        
	                        <div class="consent-error ml-3"></div>
	                        
	                        @if($team_data->consent_status == 0)
    	                        <div class="text-center">
    	                             <button type="button" id="pr-five-consent" class="btn btn-success waves-effect waves-light mt-2 ml-2">
    	                                 I Agree <span class="btn-label-right"><i class="fe-thumbs-up"></i></span>
    	                            </button>
    	                        </div>
    	                   @else
    	                        <br>
    	                        <div class="text-left">
    	                           <p class="text-success"><b>Thank you for providing your consent! We appreciate your prompt response. Your action helps us proceed further without delays. If you have any questions or need further assistance, please do not hesitate to reach out.</b></p>
    	                        </div>
    	                        <div class="text-center">
    	                             <a href="{{ config('constants.wp_url')}}" class="btn btn-success waves-effect waves-light mt-2 ml-2 text-white">
    	                                 Go To Home<span class="btn-label-right"><i class="fe-home"></i></span>
    	                            </a>
    	                        </div>
    	                   @endif
	                        
	                        
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7 col-xl-3 cu-applisidebar cright">
            @include('partials.comman.loan.right_cardbox', ['application' => $application, 'is_consent' => 1])
         </div>
      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">Privacy Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p class="slimscroll border p-2" style="max-height: 300px !important;">
                     <b><u>Privacy Information:</u></b>
                     <br> Purpose of collection<br> Information about an identifiable individual and includes facts or an opinion about you which identifies you or by which your identity can be reasonably determined. The collection of your personal information isessential to enable us to conduct our business of offering and providing you with our range of financial products and services. We collect personal information for the purposes of:<br> 1) identifying and protecting you when you do business with us;<br> 2) establishing your requirements and providing the appropriate product or service;<br> 3) setting up,administering and managing our products and services;<br> 4) assessing and investigating, and if accepted, managing a claim made by you under one or more of our products;and<br> 5) training and developing our staff and representatives<br> We may be required by law to collect your personal information. These include, but are not limited to, anti-money laundering and taxation laws.<br> <b>Consequences if personal information is not provided</b><br> If we request personal information about you and you do not provide it,we may not be able to provide you with the financial product or service that you request, or provide you with the full range of services we offer.<br> <b>Disclosure</b><br> We use and disclose your personal information for the purposes we collect edit.<br> We may also use and disclose your personal information for a secondary purpose that is related to the purpose for which we collected it. This would happen in cases where you would reasonably expect us to use or disclose your personal information for that secondary purpose. In the case of sensitive information, any secondary purpose, use or disclosure will be directly related to the purpose of collection.<br> When necessary and in connection with purposes of collection, we may disclose your personal information to and/or collect your personal information from: <br> 1) other companies within the Jass Group (Aus) Pty Ltd ;<br> 2) where required o rauthorised under our relationship with our joint venture companies;<br> 3) information technology providers, including hardware and software vendors and consultants such as programmers;<br> 4) research and development service providers;<br> 5) your advisers, agents or representatives;<br> 6) credit reporting agencies;<br> 7) legal and other professional advisers;<br> 8) printers and mail house service providers;<br> 9) external dispute resolution schemes<br> <b>Access</b><br> You can request access to the personal information we hold about you by contacting us. In some circumstances, we are able to deny your request for access to personal information. If we deny your request for access, we will tell you why.<br> <b>Marketing</b><br> We would like to use and disclose your personal information to keep you up to date with the range of products and services available from Jass Group (Aus) Pty Ltd alla. Generally, our companies in the Jass Group (Aus) Pty Ltd group will use and disclose your personal information for company's marketing purposes. Contact us if you do not wish to.<br> <b>Contact</b><br> Please contact us to:<br> 1) change your mind at any time about receiving marketing material;<br> 2) request access to the personal information we hold about you; or<br> 3) obtain more information about our privacy practices by asking for a copy of our Privacy Policy;;<br> 
                  </p>
               </div>
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-example-modal-lg-1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">Authority To Obtain Credit Information</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class=" border p-2">
                     <p>
                         I/We declare that the credit to be provided to me/us by Knote Group Aus Pty Ltd for this Credit Application is to be applied wholly or predominantly for business purposes; or investment purposes other than investment in residential propertie s , i/we understand consent to all matters in the application. We have no reason to believe any change in Capacity or position in future.<br>
                     </p>
                     
                     <p>
                         I/We understand that by signing this application, consent is given to Knote Group Aus Pty Ltd and it’s related entities to: 
                     </p>
                     
                     
                     <p>
                        1) Disclose to a credit reporting agency certain personal information about me/us including: identity particulars; amount of credit applied for in this application; payments which may become more than 60 days overdue; any serious credit infringement which Knote Group Aus Pty Ltd and it’s related entities believes I/we have committed, advice that payments are no longer overdue and/or that credit provided to me/us has been discharged.
                     </p>
                     <p>
                           2) Obtain from a credit reporting agency a report containing personal credit information about me/us and, a report containing information about my/our commercial activities or commercial credit worthiness, to enable Knote Group Aus Pty Ltd and it’s related entities to assess this application for credit. I/We further consent to and acknowledge that Knote Group Aus Pty Ltd and it’s related entities may at it’s discretion obtain second and/or subsequent credit reports prior to funding (settlement) or withdrawal of this application, in order to reassess my/our application for credit.
                     </p>
                     <p>
                         3) Give and obtain from any credit provider(s) that may be named in this application or in a report held by a credit reporting agency information about my/our credit arrangements, including information about my/our credit worthiness, credit standing, credit history, credit capacity for the purpose of assessing an application for credit, notifying any default by me/us.
                     </p>
                     <p>
                         4) Give to any guarantor, proposed Guarantor or person providing security for a loan given by Knote Group Aus Pty Ltd and it’s related entities to me/us, any credit information about me/us.
                         
                     </p>
                     <div>
                         This includes but is not limited to the information about and copies of the following items:<br>
                     </div>
                     <div class="pl-3"> 
                         <p>
                              1) this and any credit contract or security contract I/we have or had with the Banks/Credit Provider/ Knote Group Aus Pty Ltd and it’s related entities
                              <br>  2) application information including any financial statements or statements of financial position given to us within the last 2 years,<br> 3) any credit report or related credit report obtained from a credit reporting agency,<br> 4) a copy of any related credit insurance contract,<br> 5) any default notices, statements of account, or dishonour notice on this or any related facility I/we have or had with the Banks/Credit Provider/Credit Hub Australia,<br> 6) any other information we have that they may reasonably request.
                         </p>
                     </div>
                     <div>
                         We further acknowledge this authority extends to include any information in the Our possession relating to the preceding 2 years and continues for the life of the facility now requested.
                     </div>
                     
                    <div class="pl-3">
                        <p>
                            1) Confirm my employment details from my employer, accountant or tax agent named in this application.<br>2) Confirm my income received on an investment property from any nominated real estate agent.
                        </p>
                    </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
@endsection
@section('scripts')
@if(request()->is('loan*'))
<script src="{{ asset('comman/js/pages/ion.rangeSlider.min.js') }}"></script>
<script type="text/javascript">

$('#pr-five-consent').click(function(){
    $('.error-block').remove();
    var url = $('#loan-application-five-consent').attr('action');
    $.ajax ({
        type: 'POST',
        url: url,
        data: $('#loan-application-five-consent').serialize(),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success : function(response) {
            if(save_exit_true()){
                if(response.status == 201){
                    if(response.message != ""){
                        toaserMessage(response.status, response.message);
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 3000);

                    }
                }else{
                    $('.consent-error').html('<span class="help-block error-block text-danger"><small class="text-danger">'+response.message+'</small></span>');
                }    
            }
        },
        error: function (reject) {
            if(save_exit_true()){
                if(reject.status === 422 ) {
                    var response = $.parseJSON(reject.responseText);
                    var errors = response['errors'];
                    $('.error-block').remove();
                    $.each(errors, function(field_name, error_array) {
                        $.each(error_array, function(index, error_message) {
                            $('.consent-error').html('<span class="help-block error-block text-danger"><small class="text-danger">'+ error_message +'</small></span>');
                        });
                    });
                }
            }
        }
    }); 
});
</script>
@endif
@endsection