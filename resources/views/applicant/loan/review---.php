@extends('layouts._comman')
@section('title', 'Create New Loan Application - Knote')
@section('styles')
@if(request()->is('loan*'))
<link href="{{ asset('comman/css/loan-application.css') }}" rel="stylesheet">
<link href="{{ asset('comman/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
@endif
@endsection
@section('content')
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <div class="row mt-4">
         <div class="col-lg-8 col-xl-8">
            <div class="card-box">
               <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                     <form action="{{ url()->current() }}" id="loan-application-five" name="loan-application-five" method="post" onsubmit="return false;">
                        <h4 class="header-title font-22">Review</h4>
                        <hr>
                        <h3 class="header-title mt-4 font-18">Business Information <a href="{{ url('loan/create/business-information') }}"><i class="fe-edit text-right edit-pin"></i></a></h3>
                        <div class="table-responsive mt-2">
                           <div>
                              <strong class="font-13 text-muted text-uppercase mb-1">Business Name : </strong>
                              <span class="mb-3">{{ $application->business_name }}</span>
                           </div>

                           <div>
                              <strong class="font-13 text-muted text-uppercase mb-1">ABN or ACN : </strong>
                              <span class="mb-3">{{ $application->business_name }}</span>
                           </div>


                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 <tr>
                                    <td>Business Name</td>
                                    <td>{{ $application->business_name }}</td>
                                 </tr>
                                 <tr>
                                    <td>ABN or ACN</td>
                                    <td>{{ $application->abn_or_acn }}</td>
                                 </tr>
                                 <tr>
                                    <td>Loan Requested</td>
                                    <td>{{ $application->loan_request_amount() }}</td>
                                 </tr>
                                 <tr>
                                    <td>Business Structure</td>
                                    <td>{{ $application->business_structure->structure_type }}</td>
                                 </tr>
                                 <tr>
                                    <td>Year Established</td>
                                    <td>{{ $application->years_of_established }}</td>
                                 </tr>
                                 <tr>
                                    <td>Business Address</td>
                                    <td>{{ $application->business_address }}</td>
                                 </tr>
                                 <tr>
                                    <td>Mailing Address</td>
                                    <td>{{ $application->business_email }}</td>
                                 </tr>
                                 <tr>
                                    <td>Mobile</td>
                                    <td>{{ $application->business_phone }}</td>
                                 </tr>
                                 <tr>
                                    <td>Landline</td>
                                    <td>{{ $application->landline_phone }}</td>
                                 </tr>
                                 <tr>
                                    <td>Fax</td>
                                    <td>{{ $application->fax }}</td>
                                 </tr>
                                 <tr>
                                    <td>Industry</td>
                                    <td>{{ $application->business_type->business_type }}</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <h4 class="header-title mt-4 font-20">People <a href="{{ url('loan/create/people') }}"><i class="fe-edit text-right edit-pin"></i></a></h4>
                        @forelse($application->team_sizes as $key_team => $team)
                        <p class="mt-2">People : {{ $key_team+1 }}</p>
                        <div class="table-responsive mt-2">
                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 <tr>
                                    <td>Name</td>
                                    <td>{{ config('constants.people_title')[$team->title].' '.$team->firstname.' '.$team->lastname }}</td>
                                    <td>Position</td>
                                    <td>{{ $team->position }}</td>
                                 </tr>
                                 <tr>
                                    <td>Address</td>
                                    <td colspan="3">{{ $team->address }}</td>
                                 </tr>
                                 <tr>
                                    <td>Mobile</td>
                                    <td>{{ $team->mobile }}</td>
                                    <td>Landline</td>
                                    <td>{{ $team->landline }}</td>
                                 </tr>
                                 <tr>
                                    <td>Marital Status</td>
                                    <td>
                                       @if($team->marital_status != null)
                                       {{ config('constants.marital_status')[$team->marital_status] }}
                                       @endif
                                    </td>
                                    <td>Date of Birth</td>
                                    <td>{{ $team->dob }}</td>
                                 </tr>
                                 <tr>
                                    <td>License Number</td>
                                    <td>{{ $team->license_number }}</td>
                                    <td>License Expiry Date</td>
                                    <td>{{ $team->license_expiry_date }}</td>
                                 </tr>
                                 <tr>
                                    <td>Time at Address</td>
                                    <td>{{ $team->time_at_business }} Years</td>
                                    <td>Time in Business</td>
                                    <td>{{ $team->time_in_business }} Years</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        @empty
                        @endforelse
                        <h4 class="header-title mt-4 font-20">Finance (@if(!empty($application->finance_information)) {{ config('constants.finance_periods')[$application->finance_information->finance_periods].' - '.$application->finance_information->business_trade_year }} @endif) <a href="{{ url('loan/create/finance') }}"><i class="fe-edit text-right edit-pin"></i></a></h4>
                        <hr>
                        <div class="table-responsive">
                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 <tr>
                                    <td>Gross Income</td>
                                    <td>
                                       @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->gross_income) }} 
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Total Expense</td>
                                    <td>
                                       @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->total_expenses) }} 
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Net Income</td>
                                    <td>
                                       @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->net_income) }} 
                                       @endif
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <p class="mt-4">Assets</p>
                        <div class="table-responsive mt-4">
                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 <tr>
                                    <td>Property (Prime Residence)</td>
                                    <td>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->asset_property_primary_residence) }} @endif</td>
                                 </tr>
                                 <tr>
                                    <td>Property (Other)</td>
                                    <td>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->asset_property_other) }} @endif</td>
                                 </tr>
                                 <tr>
                                    <td>Bank Account(s)</td>
                                    <td>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->asset_bank_account) }} @endif</td>
                                 </tr>
                                 <tr>
                                    <td>Super(s)</td>
                                    <td>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->asset_super) }} @endif</td>
                                 </tr>
                                 <tr>
                                    <td>Other assets</td>
                                    <td>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->asset_other) }} @endif</td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <hr>
                        <p>Liabilities</p>
                        <div class="table-responsive mt-4">
                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 <tr>
                                    <td>Home Loan</td>
                                    <td>
                                       @if(!empty($application->finance_information)) 
                                       @if($application->finance_information->liability_homeloan_type != "")
                                       {{ config('constants.liabilities_select_options')[$application->finance_information->liability_homeloan_type] }} Value: {{ money_format_amount($application->finance_information->liability_homeloan) }}
                                       @endif
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Other Loan</td>
                                    <td>
                                       @if(!empty($application->finance_information))
                                       @if($application->finance_information->liability_otherloan_type != "")
                                       {{ config('constants.liabilities_select_options')[$application->finance_information->liability_otherloan_type] }} Value: {{ money_format_amount($application->finance_information->liability_otherloan) }}
                                       @endif
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Credit Card (All Cards)</td>
                                    <td>
                                       @if(!empty($application->finance_information)) 
                                       @if($application->finance_information->liability_all_card_type != "")
                                       {{ config('constants.liabilities_select_options')[$application->finance_information->liability_all_card_type] }} Value: {{ money_format_amount($application->finance_information->liability_all_card) }}
                                       @endif
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Car/Personal Loans (All Loans)</td>
                                    <td>
                                       @if(!empty($application->finance_information)) 
                                       @if($application->finance_information->liability_car_personal_type != "")
                                       {{ config('constants.liabilities_select_options')[$application->finance_information->liability_car_personal_type] }} Value: {{ money_format_amount($application->finance_information->liability_car_personal) }}
                                       @endif
                                       @endif
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Living Expense</td>
                                    <td>
                                       @if(!empty($application->finance_information)) 
                                       @if($application->finance_information->liability_living_expense_type != "")
                                       {{ config('constants.liabilities_select_options')[$application->finance_information->liability_living_expense_type] }} Value: {{ money_format_amount($application->finance_information->liability_living_expense) }}
                                       @endif
                                       @endif
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <h4 class="header-title mt-4 font-20">Document <a href="{{ url('loan/create/document') }}"><i class="fe-edit text-right edit-pin"></i></a></h4>
                        <div class="table-responsive mt-4">
                           <table class="table table-bordered table-centered mb-0">
                              <tbody>
                                 @foreach(config('constants.document_types') as $key => $value)
                                 <tr>
                                    <td rowspan="{{ $application->get_documents_by_type($key)->count() + 1 }}">{{ $value }}</td>
                                    <td>
                                       @if($application->get_documents_by_type($key)->count() != 0)
                                       <a href="{{ asset('storage/'.$application->get_documents_by_type($key)->first()['file']) }}" target="blank">{{ $value.' - 1' }}</a>
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
                                    <td><a href="{{ asset('storage/'.$document->file) }}" target="blank">{{ $value.' - '.($count++) }}</a></td>
                                 </tr>
                                 @endif
                                 @endforeach
                                 @endif
                              </tbody>
                              @endforeach
                           </table>
                        </div>
                        <h4 class="header-title mt-4 font-20">
                           <div class="checkbox checkbox-success mb-2">
                              <input id="checkbox3" class="my-cu-check-uncheck ml-1" type="checkbox" value="1" name="privacy_policy" {{ ($application->is_accept_terms == 1) ? 'checked="checked"' : '' }}>
                              <label for="checkbox3">
                              <a href="javascript:;" data-toggle="modal" data-target=".bs-example-modal-lg" class="font-13">I Agree Privacy Information</a>
                              </label>
                           </div>
                        </h4>
                        <h4 class="header-title mt-1 font-20">
                           <div class="checkbox checkbox-success mb-2">
                              <input id="checkbox4" type="checkbox" class="my-cu-check-uncheck ml-1" value="1" name="authority_to_obtain_credit_information" {{ ($application->is_accept_terms == 1) ? 'checked="checked"' : '' }}>
                              <label for="checkbox4">
                              <a href="javascript:;" data-toggle="modal" data-target=".bs-example-modal-lg-1" class="font-13">AUTHORITY TO OBTAIN CREDIT INFORMATION</a>                                       
                              </label>
                           </div>
                        </h4>
                        <input type="hidden" name="application_id" value="{{ $application->id }}" >
                        @if($enc_id == "")
                        <div class="text-center">
                           <a href="{{ route('loan.create.document') }}" class="btn btn-outline-dark waves-effect waves-light z-two mt-2">
                           <i class="fe-arrow-left"></i>&nbsp;Previous
                           </a>
                           <button type="submit" data-url="{{ url()->current() }}" data-redirect="{{ url('/dashboard') }}" id="pr-five" class="btn btn-success waves-effect waves-light mt-2 ml-2">Submit<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                        </div>
                        @else
                        <div class="text-center">
                           <a href="{{ url('loan/edit/document/'.$enc_id) }}" class="btn btn-outline-dark waves-effect waves-light z-two mt-2">
                           <i class="fe-arrow-left"></i>
                           &nbsp;Previous
                           </a>
                           <button type="submit" data-url="{{ url('loan/create/review') }}" data-redirect="{{ url('/dashboard') }}" id="pr-five" class="btn btn-success waves-effect waves-light mt-2 ml-2">Submit<span class="btn-label-right"><i class="fe-arrow-right"></i></span></button>
                        </div>
                        @endif
                     </form>
                  </div>
                  <!-- end settings content-->
               </div>
               <!-- end tab-content -->
            </div>
         </div>
         <div class="col-lg-4 col-xl-4">
            @include('partials.comman.loan.right_cardbox', ['application' => $application])
         </div>
      </div>
   </div>
   <!-- container -->
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
            <h4 class="modal-title" id="myLargeModalLabel">AUTHORITY TO OBTAIN CREDIT INFORMATION</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <p class="slimscroll border p-2" style="max-height: 300px !important;">
                     I/We understand that by signing this application, consent is given to Jass Group (Aus) Pty Ltd to: <br> 1) Disclose to a credit reporting agency certain personal information about me/us including: identity particulars; amount of credit applied for in this application; payments which may become more than 60 days overdue; any serious credit infringement which Jass Group (Aus) Pty Ltd believes I/we have committed, advice that payments are no longer overdue and/or that credit provided to me/us has been discharged.<br> 2) Obtain from a credit reporting agency a report containing personal credit information about me/us and, a report containing information about my/our commercial activities or commercial credit worthiness, to enable Jass Group (Aus) Pty Ltd to assess this application for credit. I/We further consent to and acknowledge that Jass Group (Aus) Pty Ltd may at it’s discretion obtain second and/or subsequent credit reports prior to funding (settlement) or withdrawal of this application, in order to reassess my/our application for credit.<br> 3) Give and obtain from any credit provider(s) that may be named in this application or in a report held by a credit reporting agency information about my/our credit arrangements, including information about my/our credit worthiness, credit standing, credit history, credit capacity for the purpose of assessing an application for credit, notifying any default by me/us.<br> 4) Give to any guarantor, proposed Guarantor or person providing security for a loan given by Jass Group (Aus) Pty Ltd to me/us, any credit information about me/us.<br> This includes but is not limited to the information about and copies of the following items:<br> 1) this and any credit contract or security contract I/we have or had with the Banks/Credit Provider/Credit Hub Australia<br> 2) application information including any financial statements or statements of financial position given to us within the last 2 years,<br> 3) any credit report or related credit report obtained from a credit reporting agency,<br> 4) a copy of any related credit insurance contract,<br> 5) any default notices, statements of account, or dishonour notice on this or any related facility I/we have or had with the Banks/Credit Provider/Credit Hub Australia,<br> 6) any other information we have that they may reasonably request.<br> We further acknowledge this authority extends to include any information in the Our possession relating to the preceding 2 years and continues for the life of the facility now requested.<br> 1) Confirm my employment details from my employer, accountant or tax agent named in this application.<br> 2) Confirm my income received on an investment property from any nominated real estate agent.<br> 
                  </p>
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
@endif
@endsection