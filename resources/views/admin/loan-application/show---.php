@extends('layouts._comman')
@section('title', 'Loan Applications - Knote')
@section('styles')
<link href="{{ asset('comman/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               {{-- <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item active">[ Number : <span class="text-success">{{ $application->id }}</span> ]</li>
                  </ol>
               </div> --}}
               <h4 class="page-title">Loan Application Number : <span class="text-success">{{ $application->id }}</span>
               </h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-8">
             <div class="card-box">
               <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                     
                     <form action="{{ url()->current() }}" id="loan-application-five" name="loan-application-five" method="post" onsubmit="return false;">
                        <h3 class="header-title mt-0 font-18">Business Information 
                           <div class="badge font-14 {{ $application->current_status->color_class }} p-1">
                                 {{ $application->current_status->status }}
                           </div>
                        </h3>
                        <div class="table-responsive mt-4">
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
                        <h4 class="header-title mt-4 font-20">People </h4>
                        
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

                        <h4 class="header-title mt-4 font-20">Finance (@if(!empty($application->finance_information)) {{ config('constants.finance_periods')[$application->finance_information->finance_periods].' - '.$application->finance_information->business_trade_year }} @endif) </h4>
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
                        <h4 class="header-title mt-4 font-20">Document </h4>
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
                        
                     </form>
                  </div>
                  <!-- end settings content-->
               </div>
               <!-- end tab-content -->
            </div>
         </div>
         <div class="col-4">
            
            <div class="card-box">
               <div class="media mb-3">
                  <img class="d-flex mr-3 rounded-circle avatar-lg" src="{{ asset('storage/'.$application->user->avtar) }}" alt="">
                  <div class="media-body">
                     <h4 class="mt-0 mb-1">{{ $application->user->name }}</h4>
                     <p class="text-muted"></p>

                     <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">Address :</h4>
                        <p class="text-muted font-13 mb-3">
                           {{ $application->user->address }}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">{{ $application->user->phone }}</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{ $application->user->email }}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Role :</strong> <span class="ml-2">{{  $application->user->roles->first()->role_name }}</span></p>
                     </div>
                  </div>
               </div>

               <h5 class="mb-3 mt-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Write Review Note & Update Status</h5>
               @php
                  $max_height = ($application->review_notes->count() < 4) ? ($application->review_notes->count() * 100) : '400';
               @endphp
               <div class="slimscroll mb-3" style="max-height: {{ $max_height }}px !important;"> 
                  @forelse($application->review_notes as $key => $review)
                     <div class="post-user-comment-box p-2 mb-0 {{ ($key == 0) ? 'mt-0' : '' }}">
                         <div class="media">
                             <div class="media-body p-1">
                                 <h5 class="mt-0"> {{ $review->user->name }} <small class="text-muted">{{ $review->time_ago() }}</small></h5>
                                 {!! strip_tags(htmlspecialchars_decode($review->note)) !!}

                                 <br>
                              </div>
                         </div>
                     </div>
                  @empty

                  @endforelse
               </div>


               <form action="{{ url('admin/review-note/store') }}" id="write-review" name="loan-status-update" data-redirect="{{ url('admin/loan-applications') }}" method="post" onsubmit="return false;" enctype="multipart/form-data">

                  <div class="media mb-3">
                     <select class="custom-select selectpicker " name="status">
                        <option value="">Select Status</option>
                        @foreach($status as $value)
                           <option value="{{ $value->id }}" {{ ($application->status_id == $value->id) ? 'selected' : '' }}>{{ $value->status }}</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="media mb-3">
                     <textarea class="form-control summernote-editor" rows="4" name="note" placeholder="Note" required="required" id=""></textarea>
                  </div>

                  <input type="hidden" name="application_id" value="{{ $enc_id }}">

                  <button class="btn btn-primary text-right" type="submit" id="review-note">Submit</button>
                  <button type="reset" class="btn btn-secondary ml-2">Cancel</button>

               </form>

            </div>

         </div>
      </div>
   </div>
   <!-- container -->
</div>
@endsection
@section('scripts')
<!-- Summernote js -->
<script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
<!-- Init js -->
<script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
@endsection