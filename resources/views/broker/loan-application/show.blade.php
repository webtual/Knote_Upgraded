@extends('layouts._comman')
@section('title', 'Loan Applications - Knote')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('comman/css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ cached_asset('comman/css/loan-application.css') }}" rel="stylesheet">
    <link href="{{ asset('comman/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css" media="screen">
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #1abc9c !important;
            border-color: #1abc9c !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:active {
            box-shadow: none !important;
        }

        .swal2-actions {
            gap: 10px;
        }

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

        .fs-22 {
            font-size: 22px;
        }

        .bg-eee {
            background: #eee !important;
        }

        .pac-container.pac-logo {
            z-index: 10005 !important;
        }

        .my-cu-check-uncheck2.Attachments {
            opacity: 1 !important;
        }

        .input-pos-relative span.pers-symbol {
            position: absolute;
            top: 37px;
            right: 5px;
            font-weight: 900;
        }

        #sidebar-menu ul li:hover {
            background-color: transparent !important;
            /*color: white;*/
        }

        #sidebar-menu ul li.active {
            background-color: transparent !important;
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

        .irs--flat .irs-min,
        .irs--flat .irs-max {
            font-size: 12px;
        }

        .irs--flat .irs-from,
        .irs--flat .irs-to,
        .irs--flat .irs-single {
            font-size: 12px;
        }

        .loan-form-page .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.9rem + 2px);
            padding: 5px;
            border: 1px solid #ccc;
        }

        .loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
        }

        .loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444444b8;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #2eab99 !important;
            color: white;
        }

        .currency-symbol-one {
            top: 8px !important;
        }

        .text-nowrap {
            text-wrap: nowrap;
        }

        .gap-2 {
            gap: 8px;
        }

        .plus-minus-btn {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            width: 40px;
            line-height: normal;
            height: 14px;
            line-height: 14px;
            display: block;
        }

        .plus-minus-btn.mb-1 {
            margin-bottom: 2px !important;
        }

        .plus-minus-btn-wrapper {
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 3px;
            padding: 2px;
        }

        .plus-minus-btn-wrapper>div {
            width: 50px;
        }

        .new-select .select2-container--default .select2-selection--single {
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
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .new-select .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .9rem + 2px);
        }

        .loan-form-page .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.9rem + 2px);
            padding: 5px;
            border: 1px solid #ccc;
        }

        .loan-form-page .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
        }

        .loan-form-page .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444444b8;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #2eab99 !important;
            color: white;
        }

        hr {
            border-top: 2px solid #1369589e;
        }

        .datepicker td,
        .datepicker th {
            width: 32px;
            height: 30px;
        }

        .d-fin-wrapper,
        .d-property-sec {
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px
        }

        .document-page .gallery {
            background: #2eab990a;
            padding: 25px;
            border-radius: 5px;
            margin: 0px 0px;
        }

        .document-page .gallery .item img {
            /*height: 150px;*/
            /*object-fit: contain;*/
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .document-page .gallery .item {
            text-align: center;
            background: #2eab9917;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            height: 185px;
            border: 1px solid #ccc;
        }

        .document-page .gallery .remove-document-img,
        .document-page .gallery .hard-remove-document-image-new {
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

        .document-page .gallery .remove-document-img i,
        .document-page .gallery .hard-remove-document-image-new i {
            font-size: 16px;
            position: absolute;
            left: 4px;
        }

        .loanapplication .col-3 {
            flex: inherit !important;
            max-width: inherit !important;
            width: auto;
        }

        .conditionally_approved .error {
            color: red;
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
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active"><a title="Back" href="{{ url('broker/dashboard') }}"
                                    class="btn btn-success text-white">Back</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">
                        <h4 class="page-title">Loan Application Number : <span
                                class="text-success">{{ $application->application_number }}</span></h4>
                    </h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card-box">

                    <div class="tab-content pt-0">
                        <div class="tab-pane active" id="settings">
                            <form action="{{ url()->current() }}" id="loan-application-five"
                                name="loan-application-five" method="post" onsubmit="return false;">

                                @php
                                    $apply_for = config('constants.apply_for');
                                    use App\Models\User;
                                    $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                                    $know_about_us_val = $application->know_about_us == 8 ? $application->know_about_us_others : ($KNOW_ABOUT_US_VAL[$application->know_about_us] ?? '');
                                @endphp

                                <div class="row">
                                    <div class="col-md-7">
                                        <h3 class="header-title mt-0 font-18">Apply For :
                                            {{ ($apply_for[$application->apply_for])  }}
                                        </h3>
                                    </div>
                                    <div class="col-md-5 text-md-right">
                                        <h3 class="header-title text-success mt-0 font-18">Status :
                                            {{ $application->current_status ? $application->current_status->status : '' }}
                                        </h3>
                                    </div>
                                </div>
                                <hr>
                                <h3 class="header-title mt-2 font-18">
                                    Business Information
                                </h3>

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
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Business Structure :
                                        </strong>
                                        <span class="mb-3">{{ $application->business_structure->structure_type }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Year Established :
                                        </strong>
                                        <span class="mb-3">{{ $application->years_of_established }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Business Address :
                                        </strong>
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
                                        <span
                                            class="mb-3">{{ display_aus_landline($application->landline_phone) }}</span>
                                    </div>

                                    {{--
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Fax : </strong>
                                        <span class="mb-3">{{ $application->fax }}</span>
                                    </div>
                                    --}}

                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Industry : </strong>
                                        <span class="mb-3">{{ $application->business_type->business_type }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">How did you know about us?
                                            : </strong>
                                        <span class="mb-3">{{ $know_about_us_val }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Exit Strategy and Brief
                                            Notes : </strong>
                                        <span class="mb-3">{{ $application->brief_notes }}</span>
                                    </div>
                                </div>

                                <h3 class="header-title mt-2 font-18">
                                    Conditionally Approved Details
                                </h3>

                                <div class="table-responsive mt-2 c-border p-3">
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Facility Limit (Approval) :
                                        </strong>
                                        <span class="mb-3">${{ number_format($application->facility_limit, 2) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Facility Term (Approval) :
                                        </strong>
                                        <span class="mb-3">{{ number_format($application->facility_term) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Applied Interest Rate (%) :
                                        </strong>
                                        <span
                                            class="mb-3">{{ number_format($application->applied_interest_rate_per_month, 2) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Applied annual Interest (%)
                                            : </strong>
                                        <span
                                            class="mb-3">{{ number_format($application->applied_annual_interest, 2) }}</span>
                                    </div>
                                    @php
                                        $paymentTypes = [
                                            1 => 'Principal And Interest',
                                            2 => 'Interest Only',
                                            3 => 'Interest Capitalized',
                                        ];
                                    @endphp
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Payment Type : </strong>
                                        <span class="mb-3">{{ $paymentTypes[$application->payment_type] ?? '-' }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Repayment amount :
                                        </strong>
                                        <span
                                            class="mb-3">${{ number_format($application->repayment_amount, 2) }}</span>
                                    </div>
                                    @if($application->payment_type == 3)
                                        <div>
                                            <strong class="font-13 text-muted  mb-1 c-text-left">Interest Capitalised :
                                            </strong>
                                            <span
                                                class="mb-3">${{ number_format($application->interest_capitalized, 2) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Repayment Description :
                                        </strong>
                                        <span class="mb-3">{{ $application->repayment_description }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Application Fee : </strong>
                                        <span class="mb-3">${{ number_format($application->application_fee) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Documentation Fee :
                                        </strong>
                                        <span class="mb-3">${{ number_format($application->documentation_fee) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Valuation Fee : </strong>
                                        <span class="mb-3">${{ number_format($application->valuation_fee) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Other Fee : </strong>
                                        <span class="mb-3">${{ number_format($application->other_fee) }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Monthly Acc Fee : </strong>
                                        <span class="mb-3">${{ number_format($application->monthly_acc_fee) }}</span>
                                    </div>

                                    @if($application->discharge_fee == 'noval')
                                        <div>
                                            <strong class="font-13 text-muted  mb-1 c-text-left">Discharge Fee : </strong>
                                            <span class="mb-3">${{ $application->discharge_fee_val }}</span>
                                        </div>
                                    @else
                                        <div>
                                            <strong class="font-13 text-muted  mb-1 c-text-left">Discharge Fee : </strong>
                                            @if($application->discharge_fee == 'N/A')
                                                <span class="mb-3">{{ $application->discharge_fee }}</span>
                                            @else
                                                <span class="mb-3">${{ $application->discharge_fee }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Settlement Conditions :
                                        </strong>
                                        <span class="mb-3">{{ $application->settlement_conditions_descriptions }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Security Descriptions :
                                        </strong>
                                        <span class="mb-3">{{ $application->security_descriptions }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Mortgage Type : </strong>
                                        <span class="mb-3">{{ $application->mortgage_type_descriptions }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Land Address [Volume &
                                            Folio] : </strong>
                                        <span class="mb-3">{{ $application->land_address_descriptions }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">Grantor : </strong>
                                        <span class="mb-3">{{ $application->grantor_descriptions }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">PPSR : </strong>
                                        <span class="mb-3">{{ $application->ppsr_value }}</span>
                                    </div>
                                    <div>
                                        <strong class="font-13 text-muted  mb-1 c-text-left">LVR current : </strong>
                                        <span class="mb-3">{{ $application->lvr_current }}</span>
                                    </div>
                                </div>

                                <h4 class="header-title mt-4 font-20 d-flex justify-content-between">
                                    Applicant/Director/Proprietor
                                </h4>
                                <hr>
                                @forelse($application->team_sizes as $key_team => $team)
                                    <div class="c-border p-3 mb-2">
                                        <div class="mb-2 font-15 mt-0 font-weight-bold text-success">
                                            Applicant/Director/Proprietor : {{ $key_team + 1 }}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Name :
                                                    </strong>
                                                    <span
                                                        class="mb-3">{{ config('constants.people_title')[$team->title] . ' ' . $team->firstname . ' ' . $team->lastname }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Residential
                                                        Address : </strong>
                                                    <span class="mb-3">{{ $team->address }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Residential
                                                        Status : </strong>
                                                    <span class="mb-3">
                                                        @if($team->residential_status != null)
                                                            {{ config('constants.residential_status')[$team->residential_status] }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Marital
                                                        Status : </strong>
                                                    <span class="mb-3">@if($team->marital_status != null)
                                                        {{ config('constants.marital_status')[$team->marital_status] }}
                                                    @endif</span>
                                                </div>
                                                @php
                                                    $genderMap = [
                                                        'M' => 'Male',
                                                        'F' => 'Female',
                                                        'U' => 'Unknown/Unspecified/Other',
                                                    ];
                                                    $gender = $team->gender ?? null;
                                                  @endphp

                                                <div>
                                                    <strong class="font-13 text-muted mb-1 c-text-left-medium">Gender
                                                        :</strong>
                                                    <span class="mb-3">
                                                        {{ $genderMap[$gender] ?? '-' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Date of
                                                        Birth : </strong>
                                                    <span class="mb-3">{{ indian_date_format($team->dob) }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Time at
                                                        Address : </strong>
                                                    <span
                                                        class="mb-2">{{ ($team->time_at_business == "") ? '' : $team->time_at_business . ' Years' }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Time in
                                                        Business : </strong>
                                                    <span
                                                        class="mb-2">{{ ($team->time_in_business == "") ? '' : $team->time_in_business . ' Years' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Position :
                                                    </strong>
                                                    <span class="mb-3">{{ $team->position }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Email
                                                        Address : </strong>
                                                    <span class="mb-3">{{ $team->email_address }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Mobile :
                                                    </strong>
                                                    <span class="mb-3">{{ display_aus_phone($team->mobile) }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">Landline :
                                                    </strong>
                                                    <span class="mb-3">{{ display_aus_landline($team->landline) }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">License
                                                        Number : </strong>
                                                    <span class="mb-3">{{ $team->license_number }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">License
                                                        Expiry Date : </strong>
                                                    <span
                                                        class="mb-3">{{ indian_date_format($team->license_expiry_date) }}</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left-medium">License Card
                                                        Number : </strong>
                                                    <span class="mb-3">{{ ($team->card_number) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse

                                @if($application->apply_for == 1)
                                    <h4 class="header-title mt-3 font-20 d-flex justify-content-between">Business Financial
                                        Information @if(!empty($application->finance_information))
                                            {{ '(' . config('constants.finance_periods')[$application->finance_information->finance_periods] . ' - ' . $application->finance_information->business_trade_year . ')' }}
                                        @endif

                                        @if(empty($application->finance_information))

                                        @endif
                                    </h4>
                                @else
                                    @php
                                        $titles_vals = [
                                            1 => 'Business Financial Information',
                                            2 => 'Property/Security',
                                            3 => 'Crypto/Security',
                                        ];
                                    @endphp
                                    <h4 class="header-title mt-3 font-20 d-flex justify-content-between">
                                        {{ $titles_vals[$application->apply_for] ?? '' }}

                                    </h4>
                                @endif
                                <hr>
                                <div class="c-border p-3">
                                    @if($application->apply_for == 1)
                                        @if(!empty($application->finance_information))
                                            <div class="mb-2 font-15 font-weight-bold text-success">Business Financial
                                                Information
                                            </div>
                                            <div>
                                                <strong class="font-13 text-muted  mb-1 c-text-left">Gross Income : </strong>
                                                <span class="mb-3"> @if(!empty($application->finance_information))
                                                    {{ money_format_amount($application->finance_information->gross_income) }}
                                                @endif</span>
                                            </div>
                                            <div>
                                                <strong class="font-13 text-muted  mb-1 c-text-left">Total Expense : </strong>
                                                <span class="mb-3"> @if(!empty($application->finance_information))
                                                    {{ money_format_amount($application->finance_information->total_expenses) }}
                                                @endif</span>
                                            </div>
                                            <div>
                                                <strong class="font-13 text-muted  mb-1 c-text-left">Net Income : </strong>
                                                <span class="mb-3"> @if(!empty($application->finance_information))
                                                    {{ money_format_amount($application->finance_information->net_income) }}
                                                @endif</span>
                                            </div>
                                            <hr>
                                        @endif
                                    @else

                                        @if($application->property_securities->count() > 0)
                                            @php
                                                $type_of_property = config('constants.type_of_property');
                                                if ($application->apply_for == 2) {
                                                    $property_loan_types = config('constants.property_loan_types');
                                                } else {
                                                    $property_loan_types = config('constants.type_of_crypto');
                                                }
                                            @endphp

                                            @if($application->apply_for == 2)
                                                <div class="wrapper-pro-securities">
                                                    @foreach($application->property_securities as $key_property => $property)
                                                        <div class="mb-2 font-15 font-weight-bold text-success">
                                                            Property / Security : {{$key_property + 1}}
                                                        </div>
                                                        <div class="d-property-sec-review">
                                                            <div class="mb-0 ">
                                                                <strong class="font-13 text-muted  mb-1">Type of Property / Security :
                                                                </strong>
                                                                <span class="mb-2">
                                                                    {{ ($property_loan_types[$property->purpose])  }} -
                                                                    {{ ($type_of_property[$property->property_type]) }}
                                                                </span>
                                                            </div>

                                                            <div class="mb-0">
                                                                <strong class="font-13 text-muted  mb-1">Property Address : </strong>
                                                                <span class="mb-2"> {{ ($property->property_address) }} </span>
                                                            </div>

                                                            <div class="mb-0">
                                                                <strong class="font-13 text-muted  mb-0">Property Value : </strong>
                                                                <span class="mb-0">
                                                                    {{ money_format_amount($property->property_value) }}</span>
                                                            </div>

                                                            <div class="mb-0">
                                                                <strong class="font-13 text-muted  mb-1">Property Owner : </strong>
                                                                @php
                                                                    $owners = json_decode($property->property_owner, true);
                                                                    $ownerNames = [];
                                                                    if (is_array($owners)) {
                                                                        foreach ($owners as $owner) {
                                                                            if (isset($owner['name']) && !empty(trim($owner['name']))) {
                                                                                $ownerNames[] = $owner['name'];
                                                                            }
                                                                        }
                                                                    }
                                                                    $displayOwner = !empty($ownerNames) ? implode(', ', $ownerNames) : $property->property_owner;
                                                                @endphp
                                                                <span class="mb-2"> {{ $displayOwner }} </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($application->apply_for == 3)
                                                <div class="wrapper-pro-securities">
                                                    @foreach($application->property_securities as $key_property => $property)
                                                        <div class="mb-2 font-15 font-weight-bold text-success">
                                                            Crypto / Security : {{$key_property + 1}}
                                                        </div>
                                                        <div class="d-property-sec-review">
                                                            <div class="mb-0 ">
                                                                <strong class="font-13 text-muted  mb-1">Type of Crypto / Security :
                                                                </strong>
                                                                <span class="mb-2">
                                                                    {{ ($property_loan_types[$property->property_type]) }}
                                                                </span>
                                                            </div>
                                                            <div class="mb-0">
                                                                <strong class="font-13 text-muted  mb-0">Crypto Value : </strong>
                                                                <span class="mb-0">
                                                                    {{ money_format_amount($property->property_value) }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                        @endif

                                    @endif

                                    @forelse($application->team_sizes as $key_team => $team)

                                    @php
                                        $f_exp_row = App\Models\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
                                    @endphp

                                    @if($f_exp_row != null)
                                        <div class="mb-2 font-15 mt-2 font-weight-bold text-success">Directors Personal
                                            Financial information : {{ $key_team + 1 }}

                                        </div>
                                        <!--<h4 class="mt-1 mb-0"><strong>Assets</strong></h4>-->
                                        <div class="row flex-nowrap ">
                                            <div class="col-sm-6 col-12">
                                                <h5><strong>Assets</strong></h5>
                                                <div class="mb-0 ">
                                                    <strong class="font-13 text-muted  mb-1 c-text-left">Property
                                                        (Residential Property) : </strong>
                                                    <span
                                                        class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_primary_residence) }}@endif</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left">Property (Other) :
                                                    </strong>
                                                    <span
                                                        class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_other) }}@endif</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left">Bank Account
                                                        Balance(s) : </strong>
                                                    <span
                                                        class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_bank_account) }}@endif</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left">Super(s) :
                                                    </strong>
                                                    <span
                                                        class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_super) }}@endif</span>
                                                </div>
                                                <div>
                                                    <strong class="font-13 text-muted  mb-1 c-text-left">Other assets :
                                                    </strong>
                                                    <span
                                                        class="mb-3">@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_other) }}@endif</span>
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
                                                        <strong class="font-13 text-muted  mb-1">Credit Card (All Cards) :
                                                        </strong>
                                                    </div>

                                                    <div class="mb-0">
                                                        <strong class="font-13 text-muted  mb-1">Car/Personal Loan (All
                                                            Loan) : </strong>
                                                    </div>

                                                    <div class="mb-0">
                                                        <strong class="font-13 text-muted  mb-1">Any Other Expense :
                                                        </strong>
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
                                    @endif
                                    @endforeach
                                </div>

                                @php
                                    $url_2 = url('admin/loan/details/document/' . \Crypt::encrypt($application->id));
                                @endphp
                                <h4 class="header-title mt-3 font-20 d-flex justify-content-between align-items-center">
                                    Document
                                    <a id="download-documents-sel" class="btn btn-success text-white"
                                        href="javascript:void(0);">
                                        Download Selected Documents
                                    </a>
                                </h4>
                                <hr>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-centered mb-0">
                                        <tbody>
                                            @php
                                                $document_types = config('constants.document_types');
                                                if ($application->apply_for == 1) {
                                                    unset($document_types['3']);
                                                }
                                            @endphp

                                            @foreach($document_types as $key => $value)
                                                @php $typeDocs = $application->get_documents_by_type($key); @endphp

                                                <tr>
                                                    <td class="review-tab-color-font" colspan="3">
                                                        <strong>{{ $value }}</strong>
                                                    </td>
                                                </tr>

                                                @if($typeDocs->count() > 0)
                                                    @php $count = 1; @endphp
                                                    @foreach($typeDocs as $document)
                                                        <tr>
                                                            <td class="text-center" style="width: 5%;">
                                                                <input class="selectAppDocs" type="checkbox" name="appdocument[]"
                                                                    data-link="{{ asset('storage/' . $document->file) }}"
                                                                    data-filename="{{ $value . ' - ' . $count . '.' . pathinfo($document->file, PATHINFO_EXTENSION) }}">
                                                            </td>
                                                            <td class="review-tab-color-font">
                                                                <!--<a class="text-success" href="{{ asset('storage/'.$document->file) }}" target="_blank">-->
                                                                {{ $value . ' - ' . $count++ }}
                                                                <!--</a>-->
                                                            </td>
                                                            <td style="width:10%; text-align:center;">
                                                                @if($document->file)
                                                                    <a class="text-success"
                                                                        href="{{ asset('storage/' . $document->file) }}"
                                                                        target="_blank">
                                                                        <i class="mdi mdi-download mr-1 fs-22"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-danger">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @php
                                    $application_approved_document_data = $application->application_approved_document;
                                @endphp

                                <h4 class="header-title mt-3 font-20 d-flex justify-content-between align-items-center">
                                    Generated Documents</h4>
                                <hr>

                                <div class="">
                                    <input type="hidden" id="doc_sected_vals" name="doc_sected_vals" value="">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <tbody>
                                                @if($approved_documents_data->isNotEmpty())
                                                    @foreach($approved_documents_data as $akey => $app_val)
                                                        @php
                                                            $document_name = $app_val->document_name;
                                                            $document_id = $app_val->id;

                                                            // Check if this document exists in approved documents
                                                            $approved_document = $application_approved_document_data->where('approved_document_id', $document_id)->first();
                                                            $document_file = $approved_document ? asset('storage' . $approved_document->file_name) : null;
                                                        @endphp
                                                        <tr>
                                                            <td class="review-tab-color-font" style="width:85%;">
                                                                {{ $document_name }}
                                                            </td>
                                                            <td style="width:10%; text-align:center;">
                                                                @if($document_file)
                                                                    <a class="text-success" href="{{ $document_file }}"
                                                                        target="_blank">
                                                                        <i class="mdi mdi-download mr-1 fs-22"></i>
                                                                    </a>
                                                                @else
                                                                    <span class="text-danger">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="review-tab-color-font" style="text-align:center;"
                                                            colspan="3">
                                                            No Record Found
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <h4 class="header-title mt-3 font-20">Email Indent Logs</h4>
                                <hr>
                                <div class="c-border p-3">
                                    <div class="table-responsive">
                                        <table class="table datatables-basic internal-data-table email-log-list">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Receiver</th>
                                                    <th style="width: 150px;">CC/ReplyTo</th>
                                                    <th>Subject</th>
                                                    <th style="width: 100px;">Created Date</th>
                                                    <th style="width: 40px;">Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- end settings content-->
                    </div>
                    <!-- end tab-content -->
                </div>
            </div>

            <div class="col-md-4">

                <!--<div class="card-box" style="padding:10px;">
                
                @if($application->broker_id != null)
                    <h5 class="mb-2 bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Broker Details</h5>
                    <div>
                        <div class="media mb-3 d-flex align-items-center">
                            <div>
                                <img class="d-flex mr-2 rounded-circle avatar-lg border" src="{{ asset('storage/'.$application->user->avtar) }}" alt="">
                            </div>
                            <div class="media-body">
                               <h4 class="mt-0 mb-1">{{ $application->broker->name }}</span></h4>
                               <p class="text-muted"></p>
                               <div class="text-left mt-2">
                                  <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Mobile :</strong><span class="ml-2">{{ display_aus_phone($application->broker->phone) }}</span>
                                  </p>
                                  <p class="text-muted mb-0  font-13"><strong class="c-text-left-small">Email :</strong> <span class="ml-2 ">{{ $application->broker->email }}</span></p>
                                  <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Role :</strong> <span class="ml-2">{{  $application->broker->roles->first()->role_name }}</span></p>
                               </div>
                            </div>
                         </div>
                    </div>
                @endif
            </div>-->

                <div class="card-box" style="padding:10px;">
                    <h5 class="mb-2 bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Customer Details</h5>
                    <div>
                        <div class="media mb-3 d-flex align-items-center">
                            <div>
                                <img class="d-flex mr-2 rounded-circle avatar-lg border"
                                    src="{{ asset('storage/' . $application->user->avtar) }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="mt-0 mb-1">{{ $application->user->name }}</span></h4>
                                <p class="text-muted"></p>
                                <div class="text-left mt-2">
                                    <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Mobile
                                            :</strong><span
                                            class="ml-2">{{ display_aus_phone($application->user->phone) }}</span>
                                    </p>
                                    <p class="text-muted mb-0  font-13"><strong class="c-text-left-small">Email
                                            :</strong> <span class="ml-2 ">{{ $application->user->email }}</span></p>
                                    <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Role :</strong>
                                        <span class="ml-2">{{  $application->user->roles->first()->role_name }}</span>
                                    </p>
                                    <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">No. :</strong>
                                        <span class="ml-2">{{  $application->user->customer_no }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--code start here-->

                </div>

            </div>
        </div>
    </div>
    <!-- container -->
</div>

<!--Message Model Start-->
<div id="showmessage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form method="post" action="" id="assign_member" name="assign_member" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope text-success"></i> Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="message_data_show">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!--Message Model End-->
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_api_key') }}&libraries=places"></script>
    <script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>
    <script src="{{ asset('comman/js/pages/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#download-documents-sel').on('click', function (e) {
                e.preventDefault();

                var selectedFiles = [];

                // 1. Collect all checked file URLs
                $('.selectAppDocs:checked').each(function () {
                    var fileUrl = $(this).data('link');
                    var fileName = $(this).data('filename');

                    if (fileUrl) {
                        selectedFiles.push({ url: fileUrl, name: fileName });
                    }
                });

                if (selectedFiles.length === 0) {
                    // Assuming toaserMessage is your custom function
                    toaserMessage('400', 'Please select at least one document to download.');
                    return false;
                }

                // 2. Function to download a single file
                function downloadFile(url, filename) {
                    var a = document.createElement("a");
                    a.href = url;
                    a.setAttribute("download", filename);
                    a.target = "_blank";
                    a.style.display = "none";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                }

                // 3. Loop with delay
                selectedFiles.forEach(function (file, index) {
                    setTimeout(function () {

                        downloadFile(file.url, file.name);

                        // Check if this is the last file in the array
                        if (index === selectedFiles.length - 1) {
                            // Show success message after the last download triggers
                            toaserMessage('200', 'All files downloaded successfully.');
                        }

                    }, index * 500); // 500ms delay per file
                });
            });

        });
    </script>

    <script>
        $(function () {

            var column_name = "DT_RowIndex";

            var table = $('.email-log-list').DataTable({
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                processing: true,
                pageLength: 25,
                serverSide: true,
                searching: true,
                info: true,
                autoWidth: false,
                responsive: true,
                aoColumnDefs: [
                    {
                        "bSearchable": true,
                        "bVisible": false,
                        "aTargets": [0]
                    },
                ],
                "order": [[0, "desc"]],
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                ajax: {
                    url: "{{ url('broker/application/emaillogs/ajax') }}",
                    data: function (data) {
                        data.application_id = '{{$application->id}}';
                    }
                },
                columns: [
                    { data: 'order_by_val', name: 'order_by_val' },
                    { data: 'to_name_details', name: 'to_name_details' },
                    { data: 'cc_details', name: 'cc_details' },
                    { data: 'subject', name: 'subject' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action' },
                ]
            });

        });

        function get_mail_data(mail_id) {
            $.ajax({
                url: "{{ url('broker/application/get-mail-data') }}",
                type: "POST",
                data: { 'email_id': mail_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    $('#message_data_show').html(response.html);
                    $('#showmessage').modal('show');
                },
            });
        }

        function get_error_data(mail_id) {
            $.ajax({
                url: "{{ url('broker/application/get-error-mail-data') }}",
                type: "POST",
                data: { 'email_id': mail_id },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    $('#message_data_show').html(response.html);
                    $('#showmessage').modal('show');
                },
            });
        }
    </script>

    <script src="{{ asset('comman/libs/trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection