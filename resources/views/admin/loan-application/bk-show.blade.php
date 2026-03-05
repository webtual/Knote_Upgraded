@extends('layouts._comman')
@section('title', 'Loan Applications - Knote')
@section('styles')
<style>
	.c-text-left {
		width: 200px;
		display: inline-flex;
	}

	.c-text-left-medium {
		width: 150px;
		display: inline-flex;
	}

	.c-text-left-small {
		width: 60px;
		display: inline-flex;
	}

	.d-property-sec-review {
		border: 1px solid #eee;
		padding: 14px;
		margin-bottom: 15px;
	}

	.c-border {
		border: 1px solid #eee;
	}
</style>
<link href="{{ asset('comman/libs/trumbowyg/trumbowyg.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="content loan-review">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
					<h4 class="page-title">Loan Application Number : <span class="text-success">{{ $application->application_number }}</span></h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="card-box">
					<div class="tab-content pt-0">
						<div class="tab-pane active" id="settings">
							<form action="{{ url()->current() }}" id="loan-application-five" name="loan-application-five" method="post" onsubmit="return false;">
								@php
								$apply_for = config('constants.apply_for');
								@endphp
								<h3 class="header-title mt-0 font-18">Apply For : {{ ($apply_for[$application->apply_for])  }}</h3>
								<hr>
								<h3 class="header-title mt-2 font-18">Business Information </h3>
								<div class="table-responsive mt-2 c-border p-3">
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Business Name : </strong>
										<span class="mb-3">{{ $application->business_name }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">ABN or ACN : </strong>
										<span class="mb-3">{{ $application->abn_or_acn }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Loan Requested : </strong>
										<span class="mb-3">{{ $application->loan_request_amount() }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Business Structure : </strong>
										<span class="mb-3">{{ $application->business_structure->structure_type }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Year Established : </strong>
										<span class="mb-3">{{ $application->years_of_established }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Business Address : </strong>
										<span class="mb-3">{{ $application->business_address }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Mailing Address : </strong>
										<span class="mb-3">{{ $application->business_email }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Mobile : </strong>
										<span class="mb-3">{{ display_aus_phone($application->business_phone) }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Landline : </strong>
										<span class="mb-3">{{ display_aus_landline($application->landline_phone) }}</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Industry : </strong>
										<span class="mb-3">{{ $application->business_type->business_type }}</span>
									</div>
								</div>
								<h4 class="header-title mt-4 font-20">Applicant/Director/Proprietor </h4>

								<hr>

								@forelse($application->team_sizes as $key_team => $team)
								<div class="c-border p-3 mb-2">
									<div class="mb-2 font-15 mt-0 font-weight-bold text-success">Applicant/Director/Proprietor : {{ $key_team+1 }}</div>
									<div class="row">
										<div class="col-md-5">
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Name : </strong>
												<span class="mb-3">{{ config('constants.people_title')[$team->title].' '.$team->firstname.' '.$team->lastname }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Residential Address : </strong>
												<span class="mb-3">{{ $team->address }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Residential Status : </strong>
												<span class="mb-3">
													@if($team->residential_status != null)
													{{ config('constants.residential_status')[$team->residential_status] }}
													@endif
												</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Marital Status : </strong>
												<span class="mb-3">
													@if($team->marital_status != null)
													{{ config('constants.marital_status')[$team->marital_status] }}
													@endif
												</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Date of Birth : </strong>
												<span class="mb-3">{{ indian_date_format($team->dob) }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Time at Address : </strong>
												<span class="mb-2">{{ ($team->time_at_business == "") ? '' : $team->time_at_business.' Years' }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Time in Business : </strong>
												<span class="mb-2">{{ ($team->time_in_business == "") ? '' : $team->time_in_business.' Years' }}</span>
											</div>
										</div>
										<div class="col-md-5">
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Position : </strong>
												<span class="mb-3">{{ $team->position }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Mobile : </strong>
												<span class="mb-3">{{ display_aus_phone($team->mobile) }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">Landline : </strong>
												<span class="mb-3">{{ display_aus_landline($team->landline) }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">License Number : </strong>
												<span class="mb-3">{{ $team->license_number }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">License Expiry Date : </strong>
												<span class="mb-3">{{ indian_date_format($team->license_expiry_date) }}</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left-medium">License Card Number : </strong>
												<span class="mb-3">{{ ($team->card_number) }}</span>
											</div>
										</div>
									</div>
								</div>
								@empty
								@endforelse

								@if($application->apply_for == 1)
								<h4 class="header-title mt-3 font-20">Business Financial Information @if(!empty($application->finance_information)) {{ '('.config('constants.finance_periods')[$application->finance_information->finance_periods].' - '.$application->finance_information->business_trade_year.')' }} @endif </h4>
								@else
								<h4 class="header-title mt-3 font-20">Property / Security</h4>
								@endif
								<hr>
								
								<div class="c-border p-3">
									@if($application->apply_for == 1)
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Gross Income : </strong>
										<span class="mb-3"> @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->gross_income) }} @endif</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Total Expense : </strong>
										<span class="mb-3"> @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->total_expenses) }} @endif</span>
									</div>
									<div>
										<strong class="font-13 text-muted  mb-1 c-text-left">Net Income : </strong>
										<span class="mb-3"> @if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->net_income) }} @endif</span>
									</div>
									@else

									@if($application->property_securities->count() > 0)
									@php
									$type_of_property = config('constants.type_of_property');
									$property_loan_types = config('constants.property_loan_types');
									@endphp
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
												<span class="mb-0"> {{ money_format_amount($property->property_value) }}</span>
											</div>
										</div>
										@endforeach
									</div>
									@endif
									@endif
									@forelse($application->team_sizes as $key_team => $team)
									@php
									$f_exp_row = App\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
									@endphp
									<div class="mb-2 font-15 mt-2 font-weight-bold text-success">Directors Personal Financial information : {{ $key_team+1 }}</div>
									<h4 class="mt-1 mb-0"><strong>Assets</strong></h4>
									<div class="row flex-nowrap ">
										<div class="col-sm-6 col-12">
											<h5><strong>&nbsp;</strong></h5>
											<div class="mb-0 ">
												<strong class="font-13 text-muted  mb-1 c-text-left">Property (Residential Property) : </strong>
												<span class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_primary_residence) }}@endif</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left">Property (Other) : </strong>
												<span class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_other) }}@endif</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left">Bank Account Balance(s) : </strong>
												<span class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_bank_account) }}@endif</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left">Super(s) : </strong>
												<span class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_super) }}@endif</span>
											</div>
											<div>
												<strong class="font-13 text-muted  mb-1 c-text-left">Other assets : </strong>
												<span class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_other) }}@endif</span>
											</div>
										</div>
									</div>
									
									<h4 class="mt-3 mb-0"><strong>Liabilities</strong></h4>
									<div class="review-liabilities">
										<div class="row flex-nowrap ">
											<div class="col-sm-5 col-9">
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
									@if(!$loop->last)
									<hr>
									@endif
									@endforeach
								</div>
								
								<h4 class="header-title mt-3 font-20">Document </h4>
								<hr>
								<div class="table-responsive mt-3">
									<table class="table table-bordered table-centered mb-0">
										<tbody>
											@php
											$document_types = config('constants.document_types');
											if($application->apply_for == 1){
											unset($document_types['3']);
											}
											@endphp
											@foreach($document_types as $key => $value)
											<tr>
												<td class="review-tab-color-font" rowspan="{{ $application->get_documents_by_type($key)->count() + 1 }}">{{ $value }}</td>
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
								<h4 class="header-title mt-3 font-20">Brief notes</h4>
								<hr>
								<div>
									<span class="mb-3">{{ $application->brief_notes }}</span>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card-box">
					<h5 class="mb-2  bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Customer</h5>
					<div>
						<div class="media mb-3 d-flex align-items-center">
							<div>
								<img class="d-flex mr-2 rounded-circle avatar-lg border" src="{{ asset('storage/'.$application->user->avtar) }}" alt="">
							</div>
							<div class="media-body">
								<h4 class="mt-0 mb-1">{{ $application->user->name }}</h4>
								<p class="text-muted"></p>
								<div class="text-left mt-2">
									<p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Mobile :</strong><span class="ml-2">{{ display_aus_phone($application->user->phone) }}</span>
									</p>
									<p class="text-muted mb-0  font-13"><strong class="c-text-left-small">Email :</strong> <span class="ml-2 ">{{ $application->user->email }}</span></p>
									<p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Role :</strong> <span class="ml-2">{{ $application->user->roles->first()->role_name }}</span></p>
								</div>
							</div>
						</div>
					</div>
					<h5 class="mb-2  bg-light p-2"><i class="mdi mdi-grease-pencil mr-1"></i> Update Status</h5>
					<form action="{{ url('admin/review/status/update') }}" id="update-status" name="loan-status" method="post" onsubmit="return false;" enctype="multipart/form-data" class="mb-2">
						<div class="row">
							<div class="col-md-9">
								<div class="media mb-3">
									<select class="custom-select selectpicker " name="status">
										<option value="">Select Status</option>
										@foreach($status as $value)
										<option value="{{ $value->id }}" {{ ($application->status_id == $value->id) ? 'selected' : '' }}>{{ $value->status }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<input type="hidden" name="application_id" value="{{ $enc_id }}">
								<button class="btn btn-success" type="submit" id="review-status-update-note">Save</button>
							</div>
						</div>
					</form>
					<h5 class="mb-2  bg-light p-2"><i class="mdi mdi-note mr-1"></i> Write Review Note</h5>
					<form action="{{ url('admin/review-note/store') }}" id="write-review" name="loan-status-update" data-redirect="{{ url('admin/loan-applications') }}" method="post" onsubmit="return false;" enctype="multipart/form-data" class="mb-3">
						<div class="media">
							<textarea class="form-control" rows="4" name="note" placeholder="Note" id=""></textarea>
						</div>
						<input type="hidden" name="application_id" value="{{ $enc_id }}">
						<button class="mt-3 btn btn-success btn-block" type="submit" id="review-note">Submit</button>
					</form>
					@php
					$max_height = ($application->review_notes->count() < 4) ? ($application->review_notes->count() * 100) : '400';
						@endphp
						<div class="slimscroll mb-3" style="max-height: {{ $max_height }}px !important;">
							<div class="data-note"></div>
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
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('comman/libs/trumbowyg/trumbowyg.min.js') }}"></script>
@endsection