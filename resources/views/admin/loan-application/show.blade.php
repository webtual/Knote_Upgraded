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

        .swal-small-popup {
            width: 350px !important;
            padding: 1.2em !important;
            font-size: 14px !important;
        }

        .score-title-com {
            display: inline-block;
            border: 3px solid;
            padding: 10px 15px;
            font-weight: 900;
            border-radius: 50%;
            text-align: center;
            min-width: 60px;
            aspect-ratio: 1/1;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 60px;
            margin-left: auto;
        }

        .loan-review .nav-tabs.nav-bordered {
            border-bottom: 2px solid #dee2e6;
        }

        .loan-review .nav-tabs.nav-bordered .nav-item .nav-link {
            border: none;
            font-weight: 500;
            color: #6c757d;
            padding: 10px 20px;
            font-size: 16px;
        }

        .loan-review .nav-tabs.nav-bordered .nav-item .nav-link.active {
            color: #1abc9c;
            font-weight: 700;
            background-color: transparent;
            border-bottom: 3px solid #1abc9c !important;
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
                        <h4 class="page-title">Loan Application Number : <span
                                class="text-success">{{ $application->application_number }}</span></h4>
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
                                        use Carbon\Carbon;
                                        $apply_for = config('constants.apply_for');
                                        $application_cust_url = url(
                                            'admin/users/loan-applications/' . Crypt::encrypt($application->user->id),
                                        );
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="header-title mt-0 font-18">Apply For :
                                                {{ $apply_for[$application->apply_for] }}
                                            </h3>
                                        </div>
                                        <div class="col-md-5 text-md-right">
                                            <a title="Download Application"
                                                href="{{ url('admin/loan/details/download/' . Crypt::encrypt($application->id)) }}"
                                                class="btn-sm btn-success text-white"><i class="fa fa-file-pdf-o"
                                                    aria-hidden="true"></i> Download Application</a>
                                        </div>
                                    </div>

                                    <hr>

                                    <ul class="nav nav-tabs nav-bordered mb-0">
                                        <li class="nav-item">
                                            <a href="#application" data-toggle="tab" aria-expanded="true"
                                                class="nav-link active">
                                                Application
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#assessment" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Assessment
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#approval" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Approval
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content border-0">
                                        <div class="tab-pane active" id="application">

                                            <div class="sectab-1">
                                                <div class="row">
                                                    <div class="col-md-6 d-flex align-items-center">
                                                        <h3 class="header-title font-18">
                                                            Business Information
                                                            <a id="edit-business-application" href="javascript: void(0)"><i
                                                                    class="fe-edit text-right edit-pin text-success"></i></a>
                                                        </h3>
                                                    </div>

                                                    @if ($application->business_score)
                                                        <div class="col-md-6 text-md-right">
                                                            <h3 class="header-title font-18 score-title-com"
                                                                style="color: {{ $application->business_score < 600 ? '#dc3545' : '#28a745' }} !important;">
                                                                {{ $application->business_score }}
                                                            </h3>

                                                        </div>
                                                    @endif
                                                </div>
                                                <hr>
                                                <div class="table-responsive mt-2 c-border p-3">
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Business Name :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->business_name }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">ABN or ACN :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->abn_or_acn }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Loan Requested
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->loan_request_amount() }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Business
                                                            Structure :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->business_structure->structure_type }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Year
                                                            Established :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->years_of_established }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Business
                                                            Address :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->business_address }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Mailing Address
                                                            :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->business_email }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Mobile :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ display_aus_phone($application->business_phone) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Landline :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ display_aus_landline($application->landline_phone) }}</span>
                                                    </div>

                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Company Enquiry
                                                            Score :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->business_score }}</span>
                                                    </div>

                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Company Trading
                                                            History
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->company_trading_history_score }}</span>
                                                    </div>

                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Industry :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->business_type->business_type }}</span>
                                                    </div>
                                                    @php
                                                        use App\Models\User;
                                                        $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                                                        $know_about_us_val =
                                                            $application->know_about_us == 8
                                                                ? $application->know_about_us_others
                                                                : $KNOW_ABOUT_US_VAL[$application->know_about_us] ?? '';
                                                    @endphp
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">How did you
                                                            know about
                                                            us?
                                                            : </strong>
                                                        <span class="mb-3">{{ $know_about_us_val }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Exit Strategy
                                                            and Brief
                                                            Notes : </strong>
                                                        <span class="mb-3">{{ $application->brief_notes }}</span>
                                                    </div>
                                                    @if ($application->referral_partner)
                                                        <div class="mt-0">
                                                            <div class="mb-2 font-15 font-weight-bold text-success">
                                                                Referral Partner Details</div>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-sm mb-0">
                                                                    <thead>
                                                                        <tr class="bg-light">
                                                                            <th class="font-13 text-muted">Name</th>
                                                                            <th class="font-13 text-muted">Phone</th>
                                                                            <th class="font-13 text-muted">Email</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ $application->referral_partner->name }}
                                                                            </td>
                                                                            <td>{{ $application->referral_partner->phone }}
                                                                            </td>
                                                                            <td>{{ $application->referral_partner->email }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="mb-2 font-15 mt-2 font-weight-bold text-success">
                                                            Company Enquiry
                                                        </div>
                                                        @if (is_null($application->company_enquiry_at) || Carbon::parse($application->company_enquiry_at)->addDays(30)->isPast())
                                                            <div class="">
                                                                <a href="javascript:void(0);"
                                                                    class="btn-sm btn-success company-enquiry-score text-white mr-1"
                                                                    data-id="{{ $application->id }}">
                                                                    <i class="fa fa-tachometer text-right text-white"></i>
                                                                    Check
                                                                    Company
                                                                    Enquiry Credit Score
                                                                </a>
                                                                <i class="fa fa-info-circle text-muted font-18"
                                                                    aria-hidden="true" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Company Enquiry reports provide information on the structure and management of a Company, as well as a profile of the credit activity of the Company along with the option of requesting Credit scores and/or enriched information. Company enquiries can help determine an organisationâ€™s credit worthiness apart from providing the entitiesâ€™ identity/registration/public information."></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @foreach ($application->latest_company_enquiry_credit_score_event_logs as $key_cs => $csh)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Enquiry Id :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ $csh->enquiry_id ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Score :
                                                                    </strong>
                                                                    <span class="mb-2">{{ $csh->score ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">IP Address :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ $csh->ip_address ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Created
                                                                        Date/Time :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ display_date_format_time($csh->created_at) ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Download Score
                                                                        PDF
                                                                        :
                                                                    </strong>
                                                                    @if ($csh->is_error == 0 && $csh->score_pdf != null)
                                                                        <span class="mb-2"><a class="text-success"
                                                                                title="Download Score PDF"
                                                                                href="{{ asset('storage/' . $csh->score_pdf) }}"
                                                                                download><i
                                                                                    class="mdi mdi-download mr-1 fs-22"></i></a></span>
                                                                    @else
                                                                        <span class="mb-2">-</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Score PDF
                                                                        Viewer :
                                                                    </strong>
                                                                    @if ($csh->is_error == 0 && $csh->score_pdf != null)
                                                                        <span class="mb-2"><a
                                                                                class="text-success director-summary-btn"
                                                                                onclick="get_credit_score_event_log_data({{ $csh->id }})"
                                                                                title="Score PDF Viewer"
                                                                                href="javascript:void(0)"><i
                                                                                    class="mdi mdi-clipboard-text mr-1 fs-22"></i></a></span>
                                                                    @else
                                                                        <span class="mb-2">-</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:5px;">
                                                    @endforeach

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="mb-2 font-15 mt-2 font-weight-bold text-success">
                                                            Company Trading History
                                                        </div>

                                                        @if (is_null($application->company_trading_history_at) ||
                                                                Carbon::parse($application->company_trading_history_at)->addDays(30)->isPast())
                                                            <div class="">
                                                                <a href="javascript:void(0);"
                                                                    class="btn-sm btn-success company-trading-history-score text-white mr-1"
                                                                    data-id="{{ $application->id }}">
                                                                    <i class="fa fa-tachometer text-right text-white"></i>
                                                                    Check
                                                                    Company
                                                                    Trading History Credit Score
                                                                </a>
                                                                <i class="fa fa-info-circle text-muted font-18"
                                                                    aria-hidden="true" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="A Company Trading History report provides a score and credit report of a Company. Company Trading History also provides a score and report for each director (up to 20), and lists the business relationships of those directors. The company score factors in directorsâ€™ credit activity in predicting the likelihood of future adverse or failure of the subject company."></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @foreach ($application->latest_company_trading_enquiry_credit_score_event_logs as $key_ts => $cth)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Enquiry Id :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ $cth->enquiry_id ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Score :
                                                                    </strong>
                                                                    <span class="mb-2">{{ $cth->score ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">IP Address :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ $cth->ip_address ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Created
                                                                        Date/Time :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-2">{{ display_date_format_time($cth->created_at) ?? '-' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Download Score
                                                                        PDF
                                                                        :
                                                                    </strong>
                                                                    @if ($cth->is_error == 0 && $cth->score_pdf != null)
                                                                        <span class="mb-2"><a class="text-success"
                                                                                title="Download Score PDF"
                                                                                href="{{ asset('storage' . $cth->score_pdf) }}"
                                                                                download><i
                                                                                    class="mdi mdi-download mr-1 fs-22"></i></a></span>
                                                                    @else
                                                                        <span class="mb-2">-</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="mb-0 ">
                                                                    <strong class="font-13 text-muted  mb-1">Score PDF
                                                                        Viewer :
                                                                    </strong>
                                                                    @if ($cth->is_error == 0 && $cth->score_pdf != null)
                                                                        <span class="mb-2"><a
                                                                                class="text-success director-summary-btn"
                                                                                onclick="get_credit_score_event_log_data({{ $cth->id }})"
                                                                                title="Score PDF Viewer"
                                                                                href="javascript:void(0)"><i
                                                                                    class="mdi mdi-clipboard-text mr-1 fs-22"></i></a></span>
                                                                    @else
                                                                        <span class="mb-2">-</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr style="margin-top:5px;">
                                                    @endforeach

                                                </div>

                                            </div>

                                            <div class="sectab-2">
                                                @if ($application->apply_for == 1)
                                                    <h4 class="header-title mt-3 font-20 d-flex justify-content-between">
                                                        Business
                                                        Financial
                                                        Information @if (!empty($application->finance_information))
                                                            {{ '(' . config('constants.finance_periods')[$application->finance_information->finance_periods] . ' - ' . $application->finance_information->business_trade_year . ')' }}
                                                        @endif

                                                        @if (empty($application->finance_information))
                                                            <a id="add-business-financial" href="javascript: void(0)"><i
                                                                    class="fe-plus text-right edit-pin text-success"></i></a>
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

                                                        @if ($application->apply_for == 2)
                                                            <a id="add-property-security" href="javascript: void(0)"><i
                                                                    class="fe-plus text-right edit-pin text-success"></i></a>
                                                        @endif

                                                        @if ($application->apply_for == 3)
                                                            <a id="add-crypto-security" href="javascript: void(0)"><i
                                                                    class="fe-plus text-right edit-pin text-success"></i></a>
                                                        @endif
                                                    </h4>
                                                @endif
                                                <hr>
                                                <div class="c-border p-3">
                                                    @if ($application->apply_for == 1)
                                                        @if (!empty($application->finance_information))
                                                            <div class="mb-2 font-15 font-weight-bold text-success">
                                                                Business Financial
                                                                Information
                                                                <a id="edit-business-financial"
                                                                    class="edit-business-financial"
                                                                    data-id="@if (!empty($application->finance_information)) {{ $application->finance_information->id }} @endif"
                                                                    href="javascript: void(0)"><i
                                                                        class="fe-edit text-right edit-pin text-success"></i></a>
                                                            </div>
                                                            <div>
                                                                <strong class="font-13 text-muted  mb-1 c-text-left">Gross
                                                                    Income :
                                                                </strong>
                                                                <span class="mb-3">
                                                                    @if (!empty($application->finance_information))
                                                                        {{ money_format_amount($application->finance_information->gross_income) }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <strong class="font-13 text-muted  mb-1 c-text-left">Total
                                                                    Expense :
                                                                </strong>
                                                                <span class="mb-3">
                                                                    @if (!empty($application->finance_information))
                                                                        {{ money_format_amount($application->finance_information->total_expenses) }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <strong class="font-13 text-muted  mb-1 c-text-left">Net
                                                                    Income :
                                                                </strong>
                                                                <span class="mb-3">
                                                                    @if (!empty($application->finance_information))
                                                                        {{ money_format_amount($application->finance_information->net_income) }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <hr>
                                                        @endif
                                                    @else
                                                        @if ($application->property_securities->count() > 0)
                                                            @php
                                                                $type_of_property = config(
                                                                    'constants.type_of_property',
                                                                );
                                                                if ($application->apply_for == 2) {
                                                                    $property_loan_types = config(
                                                                        'constants.property_loan_types',
                                                                    );
                                                                } else {
                                                                    $property_loan_types = config(
                                                                        'constants.type_of_crypto',
                                                                    );
                                                                }
                                                            @endphp

                                                            @if ($application->apply_for == 2)
                                                                <div class="wrapper-pro-securities">
                                                                    @foreach ($application->property_securities as $key_property => $property)
                                                                        <div
                                                                            class="mb-2 font-15 font-weight-bold text-success">
                                                                            Property / Security : {{ $key_property + 1 }}
                                                                            <a id="edit-property-security"
                                                                                data-id="{{ $property->id }}"
                                                                                class="edit-property-security"
                                                                                href="javascript: void(0)"><i
                                                                                    class="fe-edit text-right edit-pin text-success"></i></a>
                                                                        </div>
                                                                        <div class="d-property-sec-review">
                                                                            <div class="mb-0 ">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-1">Type
                                                                                    of
                                                                                    Property /
                                                                                    Security
                                                                                    :
                                                                                </strong>
                                                                                <span class="mb-2">
                                                                                    {{ $property_loan_types[$property->purpose] }}
                                                                                    -
                                                                                    {{ $type_of_property[$property->property_type] }}
                                                                                </span>
                                                                            </div>

                                                                            <div class="mb-0">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-1">Property
                                                                                    Address :
                                                                                </strong>
                                                                                <span class="mb-2">
                                                                                    {{ $property->property_address }}
                                                                                </span>
                                                                            </div>

                                                                            <div class="mb-0">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-0">Property
                                                                                    Value
                                                                                    :
                                                                                </strong>
                                                                                <span class="mb-0">
                                                                                    {{ money_format_amount($property->property_value) }}</span>
                                                                            </div>

                                                                            <div class="mb-0">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-1">Property
                                                                                    Owner
                                                                                    :
                                                                                </strong>
                                                                                @php
                                                                                    $owners = json_decode(
                                                                                        $property->property_owner,
                                                                                        true,
                                                                                    );
                                                                                    $ownerNames = [];
                                                                                    if (is_array($owners)) {
                                                                                        foreach ($owners as $owner) {
                                                                                            if (
                                                                                                isset($owner['name']) &&
                                                                                                !empty(
                                                                                                    trim($owner['name'])
                                                                                                )
                                                                                            ) {
                                                                                                $ownerNames[] =
                                                                                                    $owner['name'];
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $displayOwner = !empty($ownerNames)
                                                                                        ? implode(', ', $ownerNames)
                                                                                        : $property->property_owner;
                                                                                @endphp
                                                                                <span class="mb-2"> {{ $displayOwner }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            @if ($application->apply_for == 3)
                                                                <div class="wrapper-pro-securities">
                                                                    @foreach ($application->property_securities as $key_property => $property)
                                                                        <div
                                                                            class="mb-2 font-15 font-weight-bold text-success">
                                                                            Crypto / Security : {{ $key_property + 1 }}
                                                                            <a id="edit-crypto-security"
                                                                                data-id="{{ $property->id }}"
                                                                                class="edit-crypto-security"
                                                                                href="javascript: void(0)"><i
                                                                                    class="fe-edit text-right edit-pin text-success"></i></a>
                                                                        </div>
                                                                        <div class="d-property-sec-review">
                                                                            <div class="mb-0 ">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-1">Type
                                                                                    of Crypto
                                                                                    /
                                                                                    Security :
                                                                                </strong>
                                                                                <span class="mb-2">
                                                                                    {{ $property_loan_types[$property->property_type] }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="mb-0">
                                                                                <strong
                                                                                    class="font-13 text-muted  mb-0">Crypto
                                                                                    Value :
                                                                                </strong>
                                                                                <span class="mb-0">
                                                                                    {{ money_format_amount($property->property_value) }}</span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                        @endif

                                                    @endif


                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="assessment">

                                            <div class="sectab-3">
                                                @php
                                                    $url_1 = url(
                                                        'admin/loan/details/edit/' . \Crypt::encrypt($application->id),
                                                    );
                                                @endphp
                                                <h3 class="header-title font-18">
                                                    Conditionally Approved Details
                                                    <a id="edit-conditionally-approved" href="javascript: void(0)">
                                                        <i class="fe-edit text-right edit-pin text-success"></i>
                                                    </a>
                                                </h3>
                                                <hr>

                                                <div class="table-responsive mt-2 c-border p-3">
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Facility Limit
                                                            (Approval) :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->facility_limit, 2) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Facility Term
                                                            (Approval) :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ number_format($application->facility_term) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Applied
                                                            Interest Rate
                                                            (%) :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ number_format($application->applied_interest_rate_per_month, 2) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Applied annual
                                                            Interest
                                                            (%)
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
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Payment Type :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $paymentTypes[$application->payment_type] ?? '-' }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Repayment
                                                            amount :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->repayment_amount, 2) }}</span>
                                                    </div>
                                                    @if ($application->payment_type == 3)
                                                        <div>
                                                            <strong class="font-13 text-muted  mb-1 c-text-left">Interest
                                                                Capitalised :
                                                            </strong>
                                                            <span
                                                                class="mb-3">${{ number_format($application->interest_capitalized, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Repayment
                                                            Description :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->repayment_description }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Application
                                                            Fee
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->application_fee) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Documentation
                                                            Fee :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->documentation_fee) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Valuation Fee
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->valuation_fee) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Other Fee :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->other_fee) }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Monthly Acc
                                                            Fee
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">${{ number_format($application->monthly_acc_fee) }}</span>
                                                    </div>

                                                    @if ($application->discharge_fee == 'noval')
                                                        <div>
                                                            <strong class="font-13 text-muted  mb-1 c-text-left">Discharge
                                                                Fee :
                                                            </strong>
                                                            <span
                                                                class="mb-3">${{ $application->discharge_fee_val }}</span>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <strong class="font-13 text-muted  mb-1 c-text-left">Discharge
                                                                Fee :
                                                            </strong>
                                                            @if ($application->discharge_fee == 'N/A')
                                                                <span
                                                                    class="mb-3">{{ $application->discharge_fee }}</span>
                                                            @else
                                                                <span
                                                                    class="mb-3">${{ $application->discharge_fee }}</span>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Settlement
                                                            Conditions :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->settlement_conditions_descriptions }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Security
                                                            Descriptions :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->security_descriptions }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Mortgage Type
                                                            :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->mortgage_type_descriptions }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Land Address
                                                            [Volume &
                                                            Folio] : </strong>
                                                        <span
                                                            class="mb-3">{{ $application->land_address_descriptions }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">Grantor :
                                                        </strong>
                                                        <span
                                                            class="mb-3">{{ $application->grantor_descriptions }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">PPSR :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->ppsr_value }}</span>
                                                    </div>
                                                    <div>
                                                        <strong class="font-13 text-muted  mb-1 c-text-left">LVR current :
                                                        </strong>
                                                        <span class="mb-3">{{ $application->lvr_current }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sectab-4">
                                                <h4 class="header-title mt-4 font-20 d-flex justify-content-between">
                                                    Applicant/Director/Proprietor
                                                    <a id="add-director" href="javascript: void(0)"><i
                                                            class="fe-plus text-right edit-pin text-success"></i></a>
                                                </h4>
                                                <hr>
                                                @forelse($application->team_sizes as $key_team => $team)
                                                    <div class="c-border p-3 mb-2">
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex align-items-center">
                                                                <div
                                                                    class="mb-2 font-15 mt-0 font-weight-bold text-success">
                                                                    Applicant/Director/Proprietor : {{ $key_team + 1 }}
                                                                    <a id="edit-director-application-{{ $key_team + 1 }}"
                                                                        class="edit-director-application"
                                                                        data-id="{{ $team->id }}"
                                                                        href="javascript: void(0)"><i
                                                                            class="fe-edit text-right edit-pin text-success"></i></a>
                                                                </div>
                                                            </div>
                                                            @if ($team->seeker_score)
                                                                <div class="col-md-6 text-md-right">
                                                                    <h3 class="header-title font-18 score-title-com"
                                                                        style="color: {{ $team->seeker_score < 600 ? '#dc3545' : '#28a745' }} !important;">
                                                                        {{ $team->seeker_score }}
                                                                    </h3>
                                                                </div>
                                                            @endif
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Name
                                                                        :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-3">{{ config('constants.people_title')[$team->title] . ' ' . $team->firstname . ' ' . $team->lastname }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Residential
                                                                        Address : </strong>
                                                                    <span class="mb-3">{{ $team->address }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Residential
                                                                        Status : </strong>
                                                                    <span class="mb-3">
                                                                        @if ($team->residential_status != null)
                                                                            {{ config('constants.residential_status')[$team->residential_status] }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Marital
                                                                        Status : </strong>
                                                                    <span class="mb-3">
                                                                        @if ($team->marital_status != null)
                                                                            {{ config('constants.marital_status')[$team->marital_status] }}
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                @php
                                                                    $genderMap = config('constants.gender');
                                                                    $gender = $team->gender ?? null;
                                                                @endphp

                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted mb-1 c-text-left-medium">Gender
                                                                        :</strong>
                                                                    <span class="mb-3">
                                                                        {{ $genderMap[$gender] ?? '-' }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Date
                                                                        of
                                                                        Birth : </strong>
                                                                    <span
                                                                        class="mb-3">{{ indian_date_format($team->dob) }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Time
                                                                        at
                                                                        Address : </strong>
                                                                    <span
                                                                        class="mb-2">{{ $team->time_at_business == '' ? '' : $team->time_at_business . ' Years' }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Time
                                                                        in
                                                                        Business : </strong>
                                                                    <span
                                                                        class="mb-2">{{ $team->time_in_business == '' ? '' : $team->time_in_business . ' Years' }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Position
                                                                        :
                                                                    </strong>
                                                                    <span class="mb-3">{{ $team->position }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Email
                                                                        Address : </strong>
                                                                    <span class="mb-3">{{ $team->email_address }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Mobile
                                                                        :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-3">{{ display_aus_phone($team->mobile) }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">Landline
                                                                        :
                                                                    </strong>
                                                                    <span
                                                                        class="mb-3">{{ display_aus_landline($team->landline) }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">License
                                                                        Number : </strong>
                                                                    <span
                                                                        class="mb-3">{{ $team->license_number }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">License
                                                                        Expiry Date : </strong>
                                                                    <span
                                                                        class="mb-3">{{ indian_date_format($team->license_expiry_date) }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong
                                                                        class="font-13 text-muted  mb-1 c-text-left-medium">License
                                                                        Card
                                                                        Number : </strong>
                                                                    <span class="mb-3">{{ $team->card_number }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if ($team->mobile != null && $team->email_address != null)
                                                            <div class="d-flex justify-content-between">
                                                                <div
                                                                    class="mb-2 font-15 mt-2 font-weight-bold text-success">
                                                                    Consent Details
                                                                </div>

                                                                <div class="">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-success resent-consent text-white"
                                                                        data-id="{{ $team->id }}"
                                                                        data-action="{{ url('admin/consent/resent') }}">
                                                                        <i class="fe-mail text-right text-white"></i>
                                                                        Resend
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">Consent By
                                                                            : </strong>
                                                                        <span
                                                                            class="mb-2">{{ config('constants.people_title')[$team->title] . ' ' . $team->firstname . ' ' . $team->lastname }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">IP Address
                                                                            : </strong>
                                                                        <span
                                                                            class="mb-2">{{ $team->ip_address ?? '-' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">Sent
                                                                            Date/Time :
                                                                        </strong>
                                                                        <span
                                                                            class="mb-2">{{ display_date_format_time($team->consent_sent_at) ?? '-' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">Verified
                                                                            Date/Time :
                                                                        </strong>
                                                                        <span
                                                                            class="mb-2">{{ display_date_format_time($team->verified_at) ?? '-' }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">Download
                                                                            PDF :
                                                                        </strong>
                                                                        @if ($team->consent_status == 1 && $team->consent_pdf_file != null)
                                                                            <span class="mb-2"><a class="text-success"
                                                                                    title="Download Consent PDF"
                                                                                    href="{{ asset('storage/' . $team->consent_pdf_file) }}"
                                                                                    download><i
                                                                                        class="mdi mdi-download mr-1 fs-22"></i></a></span>
                                                                        @else
                                                                            @if ($team->consent_sent_at != null)
                                                                                <span class="mb-2">Processing</span>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-0 ">
                                                                        <strong class="font-13 text-muted  mb-1">Status :
                                                                        </strong>
                                                                        <span
                                                                            class="mb-2">{{ $team->consent_status == 1 ? 'Yes' : 'No' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <div
                                                                    class="mb-2 font-15 mt-2 font-weight-bold text-success">
                                                                    ScoreSeeker
                                                                </div>

                                                                @if (is_null($team->score_seeker_at) || Carbon::parse($team->score_seeker_at)->addDays(30)->isPast())
                                                                    <div class="">
                                                                        <a href="javascript:void(0);"
                                                                            class="btn-sm btn-success user-scoreseeker-score text-white mr-1"
                                                                            data-teamid="{{ $team->id }}"
                                                                            data-id="{{ $team->application_id }}">
                                                                            <i
                                                                                class="fa fa-tachometer text-right text-white"></i>
                                                                            Check
                                                                            ScoreSeeker
                                                                            Credit Score
                                                                        </a>
                                                                        <i class="fa fa-info-circle text-muted font-18"
                                                                            aria-hidden="true" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="The Score Seeker is a credit reporting tool that provides a real-time credit score and credit report for individual/Directors of the company."></i>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            @foreach ($team->score_seeker_event_logs as $key_js => $cjs)
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong
                                                                                class="font-13 text-muted  mb-1">Enquiry Id
                                                                                :
                                                                            </strong>
                                                                            <span
                                                                                class="mb-2">{{ $cjs->enquiry_id ?? '-' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong class="font-13 text-muted  mb-1">Score
                                                                                : </strong>
                                                                            <span
                                                                                class="mb-2">{{ $cjs->score ?? '-' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong class="font-13 text-muted  mb-1">IP
                                                                                Address :
                                                                            </strong>
                                                                            <span
                                                                                class="mb-2">{{ $cjs->ip_address ?? '-' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong
                                                                                class="font-13 text-muted  mb-1">Created
                                                                                Date/Time
                                                                                :
                                                                            </strong>
                                                                            <span
                                                                                class="mb-2">{{ display_date_format_time($cjs->created_at) ?? '-' }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong
                                                                                class="font-13 text-muted  mb-1">Download
                                                                                Score PDF
                                                                                :
                                                                            </strong>
                                                                            @if ($cjs->is_error == 0 && $cjs->score_pdf != null)
                                                                                <span class="mb-2"><a
                                                                                        class="text-success"
                                                                                        title="Download Score PDF"
                                                                                        href="{{ asset('storage' . $cjs->score_pdf) }}"
                                                                                        download><i
                                                                                            class="mdi mdi-download mr-1 fs-22"></i></a></span>
                                                                            @else
                                                                                <span class="mb-2">-</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="mb-0 ">
                                                                            <strong class="font-13 text-muted  mb-1">Score
                                                                                PDF Viewer :
                                                                            </strong>
                                                                            @if ($cjs->is_error == 0 && $cjs->score_pdf != null)
                                                                                <span class="mb-2"><a
                                                                                        class="text-success director-summary-btn"
                                                                                        onclick="get_credit_score_event_log_data({{ $cjs->id }})"
                                                                                        title="Score PDF Viewer"
                                                                                        href="javascript:void(0)"><i
                                                                                            class="mdi mdi-clipboard-text mr-1 fs-22"></i></a></span>
                                                                            @else
                                                                                <span class="mb-2">-</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr style="margin-top:5px;">
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                @empty
                                                @endforelse

                                                @forelse($application->team_sizes as $key_team => $team)
                                                    <div class="c-border p-3 mb-2">
                                                        @php
                                                            $f_exp_row = App\Models\FinanceInformationByPeople::where(
                                                                'application_id',
                                                                $application->id,
                                                            )
                                                                ->where('team_size_id', $team->id)
                                                                ->first();
                                                        @endphp

                                                        @if ($f_exp_row != null)
                                                            <div class="mb-2 font-15 mt-2 font-weight-bold text-success">
                                                                Directors
                                                                Personal
                                                                Financial information : {{ $key_team + 1 }}
                                                                <a id="edit-directors-financial"
                                                                    data-id="{{ $f_exp_row->id }}"
                                                                    class="edit-directors-financial"
                                                                    href="javascript: void(0)"><i
                                                                        class="fe-edit text-right edit-pin text-success"></i></a>
                                                            </div>
                                                            <h4 class="mt-1 mb-0"><strong>Assets</strong></h4>
                                                            <div class="row flex-nowrap ">
                                                                <div class="col-sm-6 col-12">
                                                                    <h5><strong>&nbsp;</strong></h5>
                                                                    <div class="mb-0 ">
                                                                        <strong
                                                                            class="font-13 text-muted  mb-1 c-text-left">Property
                                                                            (Residential Property) : </strong>
                                                                        <span class="mb-3">
                                                                            @if ($f_exp_row != null)
                                                                                {{ money_format_amount($f_exp_row->asset_property_primary_residence) }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <strong
                                                                            class="font-13 text-muted  mb-1 c-text-left">Property
                                                                            (Other) :
                                                                        </strong>
                                                                        <span class="mb-3">
                                                                            @if ($f_exp_row != null)
                                                                                {{ money_format_amount($f_exp_row->asset_property_other) }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <strong
                                                                            class="font-13 text-muted  mb-1 c-text-left">Bank
                                                                            Account
                                                                            Balance(s) : </strong>
                                                                        <span class="mb-3">
                                                                            @if ($f_exp_row != null)
                                                                                {{ money_format_amount($f_exp_row->asset_bank_account) }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <strong
                                                                            class="font-13 text-muted  mb-1 c-text-left">Super(s)
                                                                            :
                                                                        </strong>
                                                                        <span class="mb-3">
                                                                            @if ($f_exp_row != null)
                                                                                {{ money_format_amount($f_exp_row->asset_super) }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <strong
                                                                            class="font-13 text-muted  mb-1 c-text-left">Other
                                                                            assets :
                                                                        </strong>
                                                                        <span class="mb-3">
                                                                            @if ($f_exp_row != null)
                                                                                {{ money_format_amount($f_exp_row->asset_other) }}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h4 class="mt-3 mb-0"><strong>Liabilities</strong></h4>

                                                            <div class="review-liabilities">
                                                                <div class="row flex-nowrap ">
                                                                    <div class="col-sm-5 col-9">
                                                                        <h5><strong>&nbsp;</strong></h5>
                                                                        <div class="mb-0 ">
                                                                            <strong class="font-13 text-muted  mb-1">Home
                                                                                Loan :
                                                                            </strong>
                                                                        </div>

                                                                        <div class="mb-0">
                                                                            <strong class="font-13 text-muted  mb-1">Other
                                                                                Loan :
                                                                            </strong>
                                                                        </div>

                                                                        <div class="mb-0">
                                                                            <strong class="font-13 text-muted  mb-1">Credit
                                                                                Card (All
                                                                                Cards)
                                                                                :
                                                                            </strong>
                                                                        </div>

                                                                        <div class="mb-0">
                                                                            <strong
                                                                                class="font-13 text-muted  mb-1">Car/Personal
                                                                                Loan
                                                                                (All
                                                                                Loan) : </strong>
                                                                        </div>

                                                                        <div class="mb-0">
                                                                            <strong class="font-13 text-muted  mb-1">Any
                                                                                Other Expense
                                                                                :
                                                                            </strong>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <h5><strong>Limit</strong></h5>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_homeloan_limit) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_otherloan_limit) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_all_card_limit) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_car_personal_limit) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_living_expense_limit) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-3">
                                                                        <h5><strong>Repayment/Month</strong> </h5>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_homeloan_repayment) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_otherloan_repayment) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_all_card_repayment) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_car_personal_repayment) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                        <div class="mb-0">
                                                                            <span class="font-13 mb-1">
                                                                                @if ($f_exp_row != null)
                                                                                    {{ money_format_amount($f_exp_row->liability_living_expense_repayment) }}
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            @if (!$loop->last)
                                                                <hr>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="sectab-6">
                                                @php
                                                    $application_approved_document_data =
                                                        $application->application_approved_document;
                                                @endphp

                                                <h4
                                                    class="header-title mt-3 font-20 d-flex justify-content-between align-items-center">
                                                    Generated Documents

                                                    <a id="generate-documents-sel" class="btn btn-success text-white"
                                                        href="javascript:void(0);"
                                                        onclick="generateDocumentsSel({{ $application->id }}, this)">
                                                        Generate Selected Documents
                                                    </a>

                                                </h4>
                                                <hr>

                                                <div class="">
                                                    <input type="hidden" id="doc_sected_vals" name="doc_sected_vals"
                                                        value="">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-centered mb-0">
                                                            <tbody>
                                                                @if ($approved_documents_data->isNotEmpty())
                                                                    @foreach ($approved_documents_data as $akey => $app_val)
                                                                        @php
                                                                            $document_name = $app_val->document_name;
                                                                            $document_id = $app_val->id;

                                                                            $approved_document = $application_approved_document_data
                                                                                ->where(
                                                                                    'approved_document_id',
                                                                                    $document_id,
                                                                                )
                                                                                ->first();
                                                                            $document_file = $approved_document
                                                                                ? asset(
                                                                                    'storage' .
                                                                                        $approved_document->file_name,
                                                                                )
                                                                                : null;
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="review-tab-color-font"
                                                                                style="width:5%;">
                                                                                <input
                                                                                    id="appdocument{{ $akey }}"
                                                                                    class="selectAppDocs"
                                                                                    data-id="{{ $document_id }}"
                                                                                    type="checkbox" name="appdocument">
                                                                            </td>
                                                                            <td class="review-tab-color-font"
                                                                                style="width:85%;">
                                                                                {{ $document_name }}
                                                                            </td>
                                                                            <td style="width:10%; text-align:center;">
                                                                                @if ($document_file)
                                                                                    <a class="text-success"
                                                                                        href="{{ $document_file }}"
                                                                                        target="_blank">
                                                                                        <i
                                                                                            class="mdi mdi-download mr-1 fs-22"></i>
                                                                                    </a>
                                                                                @else
                                                                                    <span class="text-danger">-</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td class="review-tab-color-font"
                                                                            style="text-align:center;" colspan="3">
                                                                            No Record Found
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane" id="approval">

                                            <div class="sectab-5">
                                                @php
                                                    $url_2 = url(
                                                        'admin/loan/details/document/' .
                                                            \Crypt::encrypt($application->id),
                                                    );
                                                @endphp
                                                <h4
                                                    class="header-title font-20 d-flex justify-content-between align-items-center">
                                                    <a id="edit-document" class="edit-document"
                                                        href="javascript: void(0)">Document
                                                        &nbsp;<i class="fe-edit text-right edit-pin text-success"></i></a>

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

                                                            @foreach ($document_types as $key => $value)
                                                                @php
                                                                    $typeDocs = $application->get_documents_by_type(
                                                                        $key,
                                                                    );
                                                                @endphp

                                                                <tr>
                                                                    <td class="review-tab-color-font" colspan="3">
                                                                        <strong>{{ $value }}</strong>
                                                                    </td>
                                                                </tr>

                                                                @if ($typeDocs->count() > 0)
                                                                    @php $count = 1; @endphp
                                                                    @foreach ($typeDocs as $document)
                                                                        <tr>
                                                                            <td class="text-center" style="width: 5%;">
                                                                                <input class="selectAppDocs"
                                                                                    type="checkbox" name="appdocument[]"
                                                                                    data-link="{{ asset('storage/' . $document->file) }}"
                                                                                    data-filename="{{ $value . ' - ' . $count . '.' . pathinfo($document->file, PATHINFO_EXTENSION) }}">
                                                                            </td>
                                                                            <td class="review-tab-color-font">
                                                                                {{ $value . ' - ' . $count++ }}
                                                                            </td>
                                                                            <td style="width:10%; text-align:center;">
                                                                                @if ($document->file)
                                                                                    <a class="text-success"
                                                                                        href="{{ asset('storage/' . $document->file) }}"
                                                                                        target="_blank">
                                                                                        <i
                                                                                            class="mdi mdi-download mr-1 fs-22"></i>
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
                                            </div>

                                            <div class="sectab-6">
                                                @php
                                                    $application_approved_document_data =
                                                        $application->application_approved_document;
                                                @endphp

                                                <h4
                                                    class="header-title mt-3 font-20 d-flex justify-content-between align-items-center">
                                                    Generated Documents

                                                    <a id="generate-documents-sel" class="btn btn-success text-white"
                                                        href="javascript:void(0);"
                                                        onclick="generateDocumentsSel({{ $application->id }})">
                                                        Generate Selected Documents
                                                    </a>

                                                </h4>
                                                <hr>

                                                <div class="">
                                                    <input type="hidden" id="doc_sected_vals" name="doc_sected_vals"
                                                        value="">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-centered mb-0">
                                                            <tbody>
                                                                @if ($approved_documents_data->isNotEmpty())
                                                                    @foreach ($approved_documents_data as $akey => $app_val)
                                                                        @php
                                                                            $document_name = $app_val->document_name;
                                                                            $document_id = $app_val->id;

                                                                            $approved_document = $application_approved_document_data
                                                                                ->where(
                                                                                    'approved_document_id',
                                                                                    $document_id,
                                                                                )
                                                                                ->first();
                                                                            $document_file = $approved_document
                                                                                ? asset(
                                                                                    'storage' .
                                                                                        $approved_document->file_name,
                                                                                )
                                                                                : null;
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="review-tab-color-font"
                                                                                style="width:5%;">
                                                                                <input
                                                                                    id="appdocument{{ $akey }}"
                                                                                    class="selectAppDocs"
                                                                                    data-id="{{ $document_id }}"
                                                                                    type="checkbox" name="appdocument">
                                                                            </td>
                                                                            <td class="review-tab-color-font"
                                                                                style="width:85%;">
                                                                                {{ $document_name }}
                                                                            </td>
                                                                            <td style="width:10%; text-align:center;">
                                                                                @if ($document_file)
                                                                                    <a class="text-success"
                                                                                        href="{{ $document_file }}"
                                                                                        target="_blank">
                                                                                        <i
                                                                                            class="mdi mdi-download mr-1 fs-22"></i>
                                                                                    </a>
                                                                                @else
                                                                                    <span class="text-danger">-</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td class="review-tab-color-font"
                                                                            style="text-align:center;" colspan="3">
                                                                            No Record Found
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="sectab-7">
                                                <h4 class="header-title mt-3 font-20">Email Indent Logs</h4>
                                                <hr>
                                                <div class="c-border p-3">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table datatables-basic internal-data-table email-log-list">
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
                                            </div>

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Bar Start -->
                <div class="col-md-4">

                    <div class="card-box" style="padding: 10px;">
                        <h5 class="mb-2  bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Customer Details</h5>
                        <div>
                            <div class="media mb-3 d-flex align-items-center">
                                <div>
                                    <img class="d-flex mr-2 rounded-circle avatar-lg border"
                                        src="{{ asset('storage/' . $application->user->avtar) }}" alt="">
                                </div>
                                <div class="media-body">
                                    <h4 class="mt-0 mb-1"><a href="{{ $application_cust_url }}"><span
                                                class="text-success text-uppercase"
                                                style="">{{ $application->user->name }}</span></a></h4>
                                    <p class="text-muted"></p>
                                    <div class="text-left mt-2">
                                        <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Mobile
                                                :</strong><span
                                                class="ml-2">{{ display_aus_phone($application->user->phone) }}</span>
                                        </p>
                                        <p class="text-muted mb-0  font-13"><strong class="c-text-left-small">Email
                                                :</strong> <span class="ml-2 ">{{ $application->user->email }}</span>
                                        </p>
                                        <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Role
                                                :</strong>
                                            <span
                                                class="ml-2">{{ $application->user->roles->first()->role_name }}</span>
                                        </p>
                                        <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">No.
                                                :</strong>
                                            <span class="ml-2">{{ $application->user->customer_no }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($application->broker_id != null)
                            <h5 class="mb-2 bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Broker Details</h5>
                            <div>
                                <div class="media mb-3 d-flex align-items-center">
                                    <div>
                                        <img class="d-flex mr-2 rounded-circle avatar-lg border"
                                            src="{{ asset('storage/' . $application->user->avtar) }}" alt="">
                                    </div>
                                    <div class="media-body">
                                        <h4 class="mt-0 mb-1">{{ $application->broker->name }}</span></h4>
                                        <p class="text-muted"></p>
                                        <div class="text-left mt-2">
                                            <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Mobile
                                                    :</strong><span
                                                    class="ml-2">{{ display_aus_phone($application->broker->phone) }}</span>
                                            </p>
                                            <p class="text-muted mb-0  font-13"><strong class="c-text-left-small">Email
                                                    :</strong> <span
                                                    class="ml-2 ">{{ $application->broker->email }}</span></p>
                                            <p class="text-muted mb-0 font-13"><strong class="c-text-left-small">Role
                                                    :</strong>
                                                <span
                                                    class="ml-2">{{ $application->broker->roles->first()->role_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <h5 class="mb-2  bg-light p-2"><i class="mdi mdi-grease-pencil mr-1"></i> Update Status</h5>

                        <form action="{{ url('admin/review/status/update') }}" id="update-status" name="loan-status"
                            method="post" onsubmit="return false;" enctype="multipart/form-data" class="mb-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="media mb-3">
                                        <select class="custom-select selectpicker " name="status" id="status_vals">
                                            <option value="">Select Status</option>
                                            @foreach ($status as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $application->status_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" name="application_id" value="{{ $enc_id }}">
                                </div>
                            </div>
                        </form>

                        <!--Write Review Note Start-->
                        <h5 class="mb-2  bg-light p-2"><i class="mdi mdi-note mr-1"></i> Write Review Note</h5>

                        <form action="{{ url('admin/review-note/store') }}" id="write-review" name="loan-status-update"
                            data-redirect="{{ url('admin/loan-applications') }}" method="post"
                            onsubmit="return false;" enctype="multipart/form-data" class="mb-1">

                            <div class="media">
                                <textarea class="form-control" rows="4" name="note" placeholder="Note" id="reviewnote"></textarea>
                            </div>

                            <input type="hidden" name="application_id" value="{{ $enc_id }}">
                            <button class="mt-3 btn btn-success btn-block" type="submit" id="review-note">Save Review
                                Note</button>

                        </form>

                        @php
                            $max_height =
                                $application->review_notes->count() < 3
                                    ? $application->review_notes->count() * 80
                                    : '300';
                        @endphp
                        <div class="slimscroll mb-3" style="max-height: {{ $max_height }}px !important;">
                            <div class="data-note"></div>
                            @forelse($application->review_notes as $key => $review)
                                <div class="post-user-comment-box px-2 pt-1 pb-0 mb-0 {{ $key == 0 ? 'mt-0' : '' }}">
                                    <div class="media">
                                        <div class="media-body p-1">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mt-0"> {{ $review->user->name }}</h5> <small
                                                    class="text-muted">{{ $review->time_ago() }}</small>
                                            </div>
                                            {!! strip_tags(htmlspecialchars_decode($review->note)) !!}
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <!--Write Review Note End-->

                        <!--Write Assessor Note Start-->
                        <h5 class="mb-2  bg-light p-2"><i class="mdi mdi-note mr-1"></i> Write Assessor Note</h5>
                        <form action="{{ url('admin/assessor-review-note/store') }}" id="assessor-write-review"
                            method="post" onsubmit="return false;" enctype="multipart/form-data" class="mb-1">
                            <div class="media">
                                <textarea class="form-control" rows="4" name="assessor_note" placeholder="Assessor Note" id="assessor_note"></textarea>
                            </div>

                            <div class="mt-2">
                                <input class="form-control" type="file" name="assessor_file[]" id="assessor_file"
                                    multiple="" accept=".png, .jpeg, .jpg, .pdf, .doc, .docx">
                            </div>

                            <input type="hidden" name="assessor_application_id" id="assessor_application_id"
                                value="{{ $enc_id }}">

                            <input type="hidden" name="application_id_val" id="application_id_val"
                                value="{{ $application->id }}">

                            <button class="mt-3 btn btn-success btn-block" type="submit" id="assessor-review-note">Save
                                Assessor Note</button>
                        </form>

                        @php
                            $max_heights =
                                $application->assessor_review_notes->count() < 3
                                    ? $application->assessor_review_notes->count() * 100
                                    : '400';
                        @endphp
                        <div class="slimscroll mb-3 mt-1" style="max-height: {{ $max_heights }}px !important;">
                            <div class="assessor-data-note"></div>
                            @forelse($application->assessor_review_notes as $keys => $reviews)
                                <div class="post-user-comment-box px-2 pb-0 pt-1 mb-0 {{ $keys == 0 ? 'mt-0' : '' }}">
                                    <div class="media">
                                        <div class="media-body p-1">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="mt-0"> {{ $reviews->user->name }}</h5> <small
                                                    class="text-muted">{{ $reviews->time_ago() }}</small>
                                            </div>
                                            {!! strip_tags(htmlspecialchars_decode($reviews->assessor_note)) !!}
                                            <div class="text-right">
                                                @if (sizeof($reviews->assessor_docs) != 0)
                                                    @foreach ($reviews->assessor_docs as $document)
                                                        @php
                                                            $assessor_file_path = $document->assessor_file;
                                                        @endphp
                                                        @if (isset($assessor_file_path))
                                                            <a class="text-success" title="Download Document"
                                                                href="{{ asset('storage/' . $assessor_file_path) }}"
                                                                download><i class="mdi mdi-download mr-1 fs-22"></i></a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <!--Write Assessor Note End-->

                        <!--Write Email Indent Start-->
                        <h5 class="mb-2  bg-light p-2"><i class="mdi mdi-email mr-1"></i> Email Indent</h5>

                        <div class="card card-custom profile-detail mb-3 card-collapsed " data-card="true">
                            <div class="card-header card-header-tabs-line p-0 bg-transparent" style="">
                                <div class="card-toolbar w-100 justify-content-between bg-transparent" style="">
                                    <ul class="nav nav-tabs nav-bold nav-tabs-line sidebar-line-tab ">
                                        <li class="nav-item mr-1">
                                            <a class="nav-link active btn-success upload-document-tab" data-toggle="tab"
                                                href="#document">
                                                <span class="nav-icon">
                                                    <i class="flaticon-folder-1"></i>
                                                </span>
                                                <span class="nav-text">Upload Document</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#email-indent" aria-expanded="false"
                                                class="nav-link border email-indent-link" data-toggle="modal"
                                                data-target="#con-close-modal">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-new-email"></i>
                                                </span>
                                                <span class="nav-text">Email Indent</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body bg-eee">
                                <div class="tab-content pt-0">
                                    <div class="tab-pane fade show active" id="document" role="tabpanel"
                                        ria-labelledby="document">
                                        <div class="tab-content pt-0" id="document-tabs-content">
                                            <div class="sending-documents">
                                                <form
                                                    action="{{ url('admin/application/upload/application-documents') }}"
                                                    name="upload-application-document-form" method="post"
                                                    onsubmit="return false;" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label
                                                                    class="mb-2 font-15 mt-0 font-weight-bold text-success">Attachments
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="file" accept="application/pdf"
                                                                        class="form-control"
                                                                        name="application_documents[]" multiple="multiple"
                                                                        value="" id="application-documents"
                                                                        aria-describedby="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div id="upload-file-error-block"></div>
                                                <div class="scroll scroll-pull" data-scroll="true"
                                                    style="height: 300px;overflow: scroll;scrollbar-width: thin;scrollbar-color: #1abc9c #eee;">
                                                    <div id="result-upload-documents">
                                                        <div class="checkbox-list mb-6">
                                                            @if ($application->application_documents->count() != 0)
                                                                @foreach ($application->application_documents as $key_doc => $doc)
                                                                    <label for="document{{ $key_doc }}"
                                                                        class="checkbox d-flex w-100 flex-wrap align-items-center">
                                                                        <input id="document{{ $key_doc }}"
                                                                            type="checkbox"
                                                                            class="my-cu-check-uncheck2 Attachments mr-1"
                                                                            name="sending-documents"
                                                                            data-attachment="{{ $doc->file_extension == '' ? '' : $doc->document_file_path() }}"
                                                                            data-file-extension="{{ $doc->file_extension }}"
                                                                            data-file-name="{{ str_replace('_', ' ', $doc->title) }}">
                                                                        <span
                                                                            style="width: 75%;">{{ str_replace('_', ' ', $doc->title) }}</span>
                                                                        <div class="d-flex ml-auto">
                                                                            <a href="{{ $doc->document_file_path() }}"
                                                                                target="blank" class="text-success"><i
                                                                                    class="mdi mdi-download mr-1 fs-22"></i></a>
                                                                            @if ($doc->user_id == auth()->id())
                                                                                <a href="javascript:;"
                                                                                    class="upload-document-delete"
                                                                                    data-id="{{ $doc->id }}"><i
                                                                                        class="mdi mdi-delete text-danger mr-1 fs-22"></i></a>
                                                                            @endif
                                                                        </div>
                                                                        <div class="w-100">
                                                                            <span class="text-muted">
                                                                                <i class="flaticon2-time"></i>
                                                                                {{ display_date_format($doc->created_at) }}
                                                                            </span>
                                                                        </div>
                                                                    </label>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="send-mail-btn span-sending-document mt-3">
                                                <a href="javascript:;" id="send-mail-with-attach-file"
                                                    class="btn btn-success text-white w-100 text-center">Send Mail</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Write Email Indent End-->

                    </div>
                </div>
                <!-- Side Bar End -->
            </div>
        </div>
        <!-- container -->
    </div>

    <!-- Email Model - Start -->
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fe-mail text-info"></i> Email Indent</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body email-indent">
                    <form id="email_send" action="{{ url('admin/application/send-email') }}"
                        name="email_send_data_form" method="post" onsubmit="return false;"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" id="select-email-template-block">
                            <label>Email Template</label>
                            <select id="email_template" class="form-control form-control-solid" name="email_template">
                                <option value="" selected>Select Email Template</option>
                                @foreach ($email_template as $key => $etemp)
                                    <option value="{{ $etemp->id }}">{{ $etemp->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>To Email ( Note : Entered multiple email id's with comma separator. for example
                                abc@knote.com.au,xyz@knote.com.au )</label>
                            <input name="to" type="text" class="form-control form-control-solid"
                                placeholder="To" value="{{ $application->user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input name="subject" type="text" class="form-control form-control-solid subject-val"
                                placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea id="summernote" class="summernote summernote-val" name="summernote"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="summernote_message" id="summernote_message" required>
                        </div>

                        <div class="form-group attachment-add">
                            <label>Upload Attachment</label>
                            <input type="file" accept="application/pdf" id="attachment_add" name="attachment_add[]"
                                multiple="multiple" value="" class="form-control" aria-describedby="">
                        </div>

                        <div id="attachment-files">
                        </div>
                        <input type="hidden" value="{{ $application->id }}" id="application_id_val"
                            name="application_id_val">
                        <input type="hidden" value="" id="attachments_files" name="attachments_files">
                        <input type="hidden" value="info@knote.com.au" id="from_email" name="from_email">
                        <img src="{{ url('public/sending.gif') }}" id="mailloader" class="mailloader"
                            style="display:none;">
                        <div class="form-group m-b-0">
                            <div class="text-right">
                                <button class="btn btn-success mail-send-inquiry">
                                    <span>Send</span>
                                </button>
                                <button type="button" class="btn btn-info" data-dismiss="modal"
                                    aria-hidden="true">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Email Model - End -->

    <!--Message Model Start-->
    <div id="showmessage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form method="post" action="" id="assign_member" name="assign_member" enctype="multipart/form-data">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope text-success"></i> Details
                        </h4>
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

    <div id="director_summary" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="directorSummaryLabel"
        aria-hidden="true">
        <form method="post" action="" id="director_summary_form" name="director_summary_form"
            enctype="multipart/form-data">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="directorSummaryLabel"><i class="fa fa-file-pdf-o text-success"></i>
                            Score PDF Viewer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="fa fa-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" id="director_summary_data_show">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    @include('partials.comman.modal.conditionally-approved', compact('application'));

    @include('partials.comman.modal.status-notes')

    @include('partials.comman.modal.edit-business', compact('application'))

    @include('partials.comman.modal.add-director', compact('application'))

    @include('partials.comman.modal.edit-director', compact('application'))

    @if ($application->apply_for == 1)
        @include('partials.comman.modal.add-business-financial', compact('application'))
        @include('partials.comman.modal.edit-business-financial', compact('application'))
    @else
        @if ($application->apply_for == 2)
            @include('partials.comman.modal.add-security', compact('application'))
            @include('partials.comman.modal.edit-security', compact('application'))
        @else
            @include('partials.comman.modal.add-crypto-security', compact('application'))
            @include('partials.comman.modal.edit-crypto-security', compact('application'))
        @endif
    @endif

    @include('partials.comman.modal.edit-directors-financial', compact('application'))

    @include('partials.comman.modal.edit-document', compact('application'))

@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.google_map_api_key') }}&libraries=places">
    </script>
    <script src="https://unpkg.com/currency.js@2.0.4/dist/currency.min.js"></script>
    <script src="{{ asset('comman/js/pages/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('comman/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('comman/js/pages/form-summernote.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#download-documents-sel').on('click', function(e) {
                e.preventDefault();

                var selectedFiles = [];

                // 1. Collect all checked file URLs
                $('.selectAppDocs:checked').each(function() {
                    var fileUrl = $(this).data('link');
                    var fileName = $(this).data('filename');

                    if (fileUrl) {
                        selectedFiles.push({
                            url: fileUrl,
                            name: fileName
                        });
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
                selectedFiles.forEach(function(file, index) {
                    setTimeout(function() {

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
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        function get_credit_score_event_log_data(credit_score_event_log_id) {

            $('.gocover').show();
            $.ajax({
                url: "{{ url('admin/application/credit-score-event-log-data') }}",
                type: "POST",
                data: {
                    'credit_score_event_log_id': credit_score_event_log_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('.gocover').hide();
                    $('#director_summary_data_show').html(response.html);
                    $('#director_summary').modal('show');
                },
                error: function() {
                    $('.gocover').hide();
                }
            });

        }

        $(document).ready(function() {
            $('#doc_sected_vals').val('');
            $('.selectAppDocs').on('change', function() {
                let selectedVals = $('#doc_sected_vals').val().split(',').filter(v =>
                    v); // Get current values as array
                let docId = $(this).data('id'); // Get document ID

                if ($(this).is(':checked')) {
                    if (!selectedVals.includes(docId.toString())) {
                        selectedVals.push(docId); // Add if not already in array
                    }
                } else {
                    selectedVals = selectedVals.filter(val => val !== docId
                        .toString()); // Remove if unchecked
                }

                $('#doc_sected_vals').val(selectedVals.join(',')); // Set updated values
            });
        });

        $('body').on('click', '.user-scoreseeker-score', function() {
            let applicationId = $(this).data('id');
            let teamSizeId = $(this).data('teamid');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to check the Director's ScoreSeeker score?",
                /*icon: 'question',*/
                showCancelButton: true,
                confirmButtonText: 'Yes, check it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    popup: 'swal-small-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    $('.gocover').show();

                    $.ajax({
                        url: "{{ url('admin/check-user-score-seeker') }}",
                        type: "POST",
                        data: {
                            application_id: applicationId,
                            team_size_id: teamSizeId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('.gocover').hide();

                            if (response.status === 200) {
                                toaserMessage('200',
                                    'Director ScoreSeeker score checked successfully.');
                            } else {
                                toaserMessage('400', response.message ||
                                    'Something went wrong.');
                            }

                            setTimeout(() => location.reload(true), 2000);
                        },
                        error: function(xhr) {
                            $('.gocover').hide();
                            toaserMessage('400', 'Request failed. Please try again.');
                        }
                    });
                }
            });
        });

        $('body').on('click', '.company-enquiry-score', function() {
            let applicationId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to check the company's enquiry score?",
                /*icon: 'question',*/
                showCancelButton: true,
                confirmButtonText: 'Yes, check it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    popup: 'swal-small-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    $('.gocover').show();

                    $.ajax({
                        url: "{{ url('admin/check-company-enquiry-score') }}",
                        type: "POST",
                        data: {
                            application_id: applicationId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('.gocover').hide();

                            if (response.status === 200) {
                                toaserMessage('200',
                                    'Company enquiry score checked successfully.');
                            } else {
                                toaserMessage('400', response.message ||
                                    'Something went wrong.');
                            }

                            setTimeout(() => location.reload(true), 2000);
                        },
                        error: function(xhr) {
                            $('.gocover').hide();
                            toaserMessage('400', 'Request failed. Please try again.');
                        }
                    });
                }
            });
        });

        $('body').on('click', '.company-trading-history-score', function() {
            let applicationId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to check the company trading history score?",
                /*icon: 'question',*/
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, check it!',
                customClass: {
                    popup: 'swal-small-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    $('.gocover').show();

                    $.ajax({
                        url: "{{ url('admin/check-company-trading-history-score') }}",
                        type: "POST",
                        data: {
                            application_id: applicationId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('.gocover').hide();

                            if (response.status === 200) {
                                toaserMessage('200',
                                    'Company trading history score checked successfully.');
                            } else {
                                toaserMessage('400', response.message ||
                                    'Something went wrong.');
                            }

                            setTimeout(() => location.reload(true), 2000);
                        },
                        error: function(xhr) {
                            $('.gocover').hide();
                            toaserMessage('400', 'Server error. Please try again.');
                        }
                    });
                }
            });
        });

        function generateDocumentsSel(application_id, btnObj) {
            var btn = $(btnObj);
            var originalHtml = btn.html();

            var doc_sected_vals = $('#doc_sected_vals').val();
            if (doc_sected_vals == '') {
                toaserMessage('400', 'Please select atleast one document.');
                return false;
            } else {
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);
                $('.gocover').show();
                $.ajax({
                    url: "{{ url('admin/conditionally-approved-generate-documents-sel') }}",
                    type: "POST",
                    data: {
                        'application_id': application_id,
                        'doc_sected_vals': doc_sected_vals
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        toaserMessage('200', 'Document generated successfully.');
                        setTimeout(function() {
                            location.reload(true);
                        }, 2000);
                    },
                    error: function() {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                    }
                });
            }
        }
    </script>

    <script>
        $('.numbersOnlyAllowPoint').keyup(function() {
            if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            }
        });

        $('.numbersOnlyAllow').keyup(function() {
            // Replace any period (dot) with an empty string
            this.value = this.value.replace(/\./g, '');
            // Remove any non-numeric characters
            if (this.value != this.value.replace(/[^0-9]/g, '')) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }
        });
    </script>

    <script>
        $(document).on('change', '.property-security-check-add input[type="radio"]', function() {
            var selectedValue = $(this).val();
            $(this).closest('.property-security-check-add').find('.hidden_purpose').val(selectedValue);
        });

        $(document).on('change', '.property-type-check-add input[type="radio"]', function() {
            var selectedValue = $(this).val();
            $(this).closest('.property-type-check-add').find('.hidden_property_type').val(selectedValue);
        });

        $(document).on('change', '.property-security-check-edit input[type="radio"]', function() {
            var selectedValue = $(this).val();
            $(this).closest('.property-security-check-edit').find('.hidden_purpose').val(selectedValue);
        });

        $(document).on('change', '.property-type-check-edit input[type="radio"]', function() {
            var selectedValue = $(this).val();
            $(this).closest('.property-type-check-edit').find('.hidden_property_type').val(selectedValue);
        });

        $(document).ready(function() {

            function calculateRepaymentPay1(facility_limit, facility_term, applied_annual_interest) {
                var facility_term_val = parseFloat(facility_term / 12);
                let applied_annual_interest_val = (applied_annual_interest / 100);
                let totalExtraInterest = (facility_limit * facility_term_val) * (applied_annual_interest_val);
                let repaymentAmount = facility_limit + totalExtraInterest;
                let LoanFirstRepaymentAmount = parseFloat(repaymentAmount / facility_term);
                let LoanLastRepaymentAmount = parseFloat(repaymentAmount / facility_term);

                $('#interest_capitalized').val('');

                return {
                    LoanFirstRepaymentAmount: LoanFirstRepaymentAmount.toFixed(2),
                    LoanLastRepaymentAmount: LoanLastRepaymentAmount.toFixed(2),
                    repaymentAmount: repaymentAmount.toFixed(2),
                    totalExtraInterest: totalExtraInterest.toFixed(2)
                };


            }

            function calculateRepaymentPay2(facility_limit, facility_term, applied_interest_rate_per_month) {
                let totalExtraInterestMonthly = (facility_limit) * (applied_interest_rate_per_month / 100);
                let totalExtraInterest = (totalExtraInterestMonthly) * (facility_term);
                let repaymentAmount = facility_limit + totalExtraInterest;
                let LoanFirstRepaymentAmount = parseFloat(repaymentAmount);
                let LoanLastRepaymentAmount = parseFloat(repaymentAmount);

                $('#interest_capitalized').val('');

                return {
                    LoanFirstRepaymentAmount: LoanFirstRepaymentAmount.toFixed(2),
                    LoanLastRepaymentAmount: LoanLastRepaymentAmount.toFixed(2),
                    repaymentAmount: repaymentAmount.toFixed(2),
                    totalExtraInterestMonthly: totalExtraInterestMonthly.toFixed(2),
                    totalExtraInterest: totalExtraInterest.toFixed(2)
                };
            }

            function calculateRepaymentPay3(facility_limit, facility_term, applied_interest_rate_per_month,
                application_fee, documentation_fee, other_fee, discharge_fee_val, monthly_acc_fee) {
                let applied_interest_rate_per_month_val = parseFloat(applied_interest_rate_per_month / 100);

                console.log('applied_interest_rate_per_month_val: ' + applied_interest_rate_per_month_val);

                let facility_limit_val = parseFloat(facility_limit) + parseFloat(application_fee) + parseFloat(
                    documentation_fee) + parseFloat(other_fee) + parseFloat(discharge_fee_val) + parseFloat(
                    monthly_acc_fee);

                console.log('facility_limit_val: ' + facility_limit_val);

                let totalAmount = facility_limit_val * facility_term * applied_interest_rate_per_month_val;
                let interestCapitalized = totalAmount * facility_term * applied_interest_rate_per_month_val;
                let totalLoanAmount = totalAmount + interestCapitalized;

                console.log('totalAmount: ' + totalAmount);
                console.log('interestCapitalized: ' + interestCapitalized);
                console.log('totalLoanAmount: ' + totalLoanAmount);

                let FinalTotalLoanAmount = parseFloat(facility_limit_val) + parseFloat(totalLoanAmount);

                console.log('FinalTotalLoanAmount: ' + FinalTotalLoanAmount);

                $('#interest_capitalized').val(totalLoanAmount.toFixed(2));

                return {
                    FinalTotalLoanAmount: FinalTotalLoanAmount.toFixed(2),
                    interestCapitalized: interestCapitalized.toFixed(2),
                    totalLoanAmount: totalLoanAmount.toFixed(2)
                };
            }

            $('#payment_type').change(function() {
                var paymentType = $(this).val();
                var repaymentAmountVal = '';
                var repayment_description = '';

                var facility_limit = parseFloat($('#facility_limit').val()) || 0;
                var facility_term = parseInt($('#facility_term').val()) || 0;
                var applied_interest_rate_per_month = parseFloat($('#applied_interest_rate_per_month')
                    .val()) || 0;
                var applied_annual_interest = parseFloat($('#applied_annual_interest').val()) || 0;

                var application_fee = parseFloat($('#application_fee').val()) || 0;
                var other_fee = parseFloat($('#other_fee').val()) || 0;
                var documentation_fee = parseFloat($('#documentation_fee').val()) || 0;

                var discharge_fee_val = parseFloat($('#discharge_fee_val').val()) || 0;

                var monthly_acc_fee = parseFloat($('#monthly_acc_fee').val()) || 0;

                if (paymentType == 1) {
                    let result = calculateRepaymentPay1(facility_limit, facility_term,
                        applied_annual_interest);
                    $('#total_repayment_amount').val(result.repaymentAmount);
                    let facility_term_plus = (facility_term + 1);

                    let LoanFirstRepaymentAmount = result.LoanFirstRepaymentAmount;
                    let LoanLastRepaymentAmount = result.LoanLastRepaymentAmount;

                    $('#repayment_amount').val(result.LoanFirstRepaymentAmount);

                    /*let repayment_description = result.repaymentAmount+" payments of "+LoanFirstRepaymentAmount+" followed by a final payment of "+LoanLastRepaymentAmount+" plus any applicable discharge fee. Your interest charges and principal repayment for a payment period are due on the last day of the period. The amount of principal repayment due for each payment period is calculated by dividing the facility limit bythe facility term "+facility_term+" (in months).";*/

                    LoanFirstRepaymentAmount = parseFloat(LoanFirstRepaymentAmount);

                    let LoanFirstRepaymentAmountVAL = LoanFirstRepaymentAmount.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let repayment_description = facility_term + " payments of $" +
                        LoanFirstRepaymentAmountVAL +
                        " plus any applicable discharge fee on the last day of the period. Your interest charges and principal repayment for a payment period are due on the last day of the period and are intended to amortise. The amount of principal repayment due for each payment period is calculated by dividing the facility limit by the facility term (in months). You must pay us the secured money on the last day of the facility term.";

                    $('#repayment_description').val(repayment_description);
                } else if (paymentType == 2) {
                    let result = calculateRepaymentPay2(facility_limit, facility_term,
                        applied_interest_rate_per_month);
                    $('#repayment_amount').val(result.totalExtraInterestMonthly);
                    $('#total_repayment_amount').val('');

                    let LoanFirstRepaymentAmount = result.LoanFirstRepaymentAmount;
                    let LoanLastRepaymentAmount = result.LoanLastRepaymentAmount;

                    /*let repayment_description = result.totalExtraInterestMonthly+" payments of "+LoanFirstRepaymentAmount+" followed by a final payment of "+LoanLastRepaymentAmount+" plus any applicable discharge fee. Repayment Monthly repayments are to be made on the anniversary date of the first drawdown every month and are intended to amortise. You must pay us the secured money on the last day of the facility term";*/

                    var totalExtraInterestMonthly = parseFloat(result.totalExtraInterestMonthly);

                    let totalExtraInterestMonthlyVAL = totalExtraInterestMonthly.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let repayment_description = facility_term + " payments of $" +
                        totalExtraInterestMonthlyVAL + " followed by a final payment of " + facility_limit +
                        " plus any applicable discharge fee on the last day of the period. Repayment Monthly repayments are to be made on the anniversary date of the first drawdown every month. You must pay us the secured money on the last day of the facility term.";

                    $('#repayment_description').val(repayment_description);

                } else if (paymentType == 3) {
                    let result = calculateRepaymentPay3(facility_limit, facility_term,
                        applied_interest_rate_per_month, application_fee, documentation_fee, other_fee,
                        discharge_fee_val, monthly_acc_fee);
                    $('#repayment_amount').val(result.FinalTotalLoanAmount);
                    $('#total_repayment_amount').val('');

                    var FinalTotalLoanAmount = parseFloat(result.FinalTotalLoanAmount);

                    let FinalTotalLoanAmountVAL = FinalTotalLoanAmount.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let repayment_description = "1 payment of $" + FinalTotalLoanAmountVAL +
                        " at the end of Contract period plus any applicable discharge fee. \n\nRepayment \n\nYou must pay us the secured money on the last day of the facility term.";

                    $('#repayment_description').val(repayment_description);
                } else {
                    $('#repayment_amount').val(repaymentAmountVal);
                    $('#repayment_description').val(repayment_description);
                    $('#total_repayment_amount').val('');
                }

            });

        });

        $(document).on('keyup', '#facility_limit', function() {
            let facility_limit = parseFloat($(this).val());

            if (!isNaN(facility_limit)) {
                let application_fee = facility_limit * 0.03; // Calculate 3%

                // Ensure minimum fee is 3000
                application_fee = Math.max(application_fee, 3000).toFixed(2);

                $('#application_fee').val(application_fee);
            } else {
                $('#application_fee').val('');
            }
        });

        $(document).on('keyup',
            '#applied_interest_rate_per_month, #facility_limit, #facility_term, #applied_annual_interest, #application_fee',
            function() {
                $('#payment_type').trigger('change');
            });

        $(document).on('keyup', '#applied_interest_rate_per_month', function() {
            let monthlyInterestRate = parseFloat($(this).val());
            let annualInterestRate = monthlyInterestRate * 12;

            if (!isNaN(annualInterestRate)) {
                $('#applied_annual_interest').val(annualInterestRate.toFixed(2));
            } else {
                $('#applied_annual_interest').val('');
            }
        });

        $(function() {

            var column_name = "DT_RowIndex";

            var table = $('.email-log-list').DataTable({
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All']
                ],
                processing: true,
                pageLength: 25,
                serverSide: true,
                searching: true,
                info: true,
                autoWidth: false,
                responsive: true,
                aoColumnDefs: [{
                    "bSearchable": true,
                    "bVisible": false,
                    "aTargets": [0]
                }, ],
                "order": [
                    [0, "desc"]
                ],
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                ajax: {
                    url: "{{ url('admin/application/emaillogs/ajax') }}",
                    data: function(data) {
                        data.application_id = '{{ $application->id }}';
                    }
                },
                columns: [{
                        data: 'order_by_val',
                        name: 'order_by_val'
                    },
                    {
                        data: 'to_name_details',
                        name: 'to_name_details'
                    },
                    {
                        data: 'cc_details',
                        name: 'cc_details'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });

        function generateDocuments(application_id, btnObj) {
            var btn = $(btnObj);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

            $('.gocover').show();
            $.ajax({
                url: "{{ url('admin/conditionally-approved-generate-documents') }}",
                type: "POST",
                data: {
                    'application_id': application_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    toaserMessage('200', 'Document generated successfully.');
                    setTimeout(function() {
                        location.reload(true);
                    }, 2000);
                },
                error: function() {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                }
            });
        }

        function get_mail_data(mail_id) {
            $.ajax({
                url: "{{ url('admin/application/get-mail-data') }}",
                type: "POST",
                data: {
                    'email_id': mail_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#message_data_show').html(response.html);
                    $('#showmessage').modal('show');
                },
            });
        }

        function get_error_data(mail_id) {
            $.ajax({
                url: "{{ url('admin/application/get-error-mail-data') }}",
                type: "POST",
                data: {
                    'email_id': mail_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#message_data_show').html(response.html);
                    $('#showmessage').modal('show');
                },
            });
        }

        $('.send-mail-btn').click(function() {
            var message = $('.note-editable').html();
            $('.note-editable').html('');
            $('.subject-val').val('');
            $('.summernote-val').val('');
        });

        $('.upload-document-tab').click(function() {
            $('.my-cu-check-uncheck2:checked').trigger('click');
            $('#attachment-files').empty();
            $('.note-editable').html('');
            $('#attachments_files').val('');
        });

        $(document).ready(function() {
            $('.my-cu-check-uncheck2:checked').trigger('click');
            $('#attachment-files').empty();
            $('.note-editable').html('');
            $('#attachments_files').val('');
        });

        $('#application-documents').change(function() {

            if ($('.error-block-attachment').length != 0) {
                $('.error-block-attachment').first().remove();
            }

            var url = $('form[name="upload-application-document-form"]').attr('action');
            var form = $('form[name="upload-application-document-form"]')[0];
            var form_data = new FormData(form);
            form_data.append('application_id_val', $('#application_id_val').val());
            form_data.append('is_type', 0);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.gocover').show();
                },
                success: function(response) {
                    $('.gocover').hide();
                    if (response.status == 201) {
                        //$('#result-upload-documents').empty().append(response.html);
                        toaserMessage('200', 'The document was uploaded successfully.');
                        form.reset();
                        location.reload(true);
                    } else {
                        $('<div class="error-block-attachment"><label id="title-error" class="error" for="title">Please checked any one document</label></div>')
                            .insertBefore('#upload-file-error-block');
                    }
                }
            });
        });

        $('#attachment_add').on('change', function() {
            // Remove previous error messages
            if ($('.error-block-attachment').length !== 0) {
                $('.error-block-attachment').first().remove();
            }

            var url = "{{ url('admin/application/upload/application-documents-mail') }}";
            var form = $('form[name="email_send_data_form"]')[0];
            var form_data = new FormData(form);
            form_data.append('application_id_val', $('#application_id_val').val());
            form_data.append('is_type', 1);

            $.ajax({
                type: 'POST',
                url: url,
                data: form_data,
                cache: false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.gocover').show();
                },
                success: function(response) {
                    $('.gocover').hide();

                    if (response.status === '201') {
                        let attachments = response.attachments || [];
                        let attachmentLinks = '';
                        let htmlHeader = "<h5>Document Attachment</h5>";

                        // Append attachment file names to input
                        $('input[name="attachments_files"]').val(attachments.join(', '));

                        // Generate attachment links
                        $.each(attachments, function(index, fileUrl) {
                            attachmentLinks +=
                                `<a href="${fileUrl}" target="_blank">${fileUrl.split('/').pop()}</a><br>`;
                        });

                        $('#attachment-files').html(htmlHeader + attachmentLinks);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.gocover').hide();

                    let errorMsg = xhr.responseJSON ? xhr.responseJSON.message :
                        'Error while uploading attachments.';
                    alert(errorMsg);
                }
            });
        });

        $('#request-document-file').click(function() {
            if ($('.error-block-attachment').length != 0) {
                $('.error-block-attachment').first().remove();
            }
            var request_documents = $("input[name='request-documents']:checked").map(function() {
                return $(this).attr('data-file-name');
            }).get();
            var attachments_files = $("input[name='request-documents']:checked").map(function() {
                if ($(this).attr('data-file-extension') != "") {
                    return $(this).attr('data-attachment');
                }
            }).get();

            $('#attachment-files').empty();
            if (request_documents != "") {
                var file_name = '';
                $.each(request_documents, function(index, obj) {
                    var name = "<li><p>" + obj + "</p></li>";
                    file_name += name;
                });
                if (attachments_files != "") {
                    $('input[name="attachments_files"]').val(attachments_files.join(', '));
                    var attachment_links = '';
                    var html = "<h5>Document Attachment</h5>";
                    $.each(attachments_files, function(index, obj) {
                        var link = "<a href=" + obj + " target='blank'>" + obj + "</a><br>";
                        attachment_links += link;
                    });
                    $('#attachment-files').html(html + attachment_links);
                }
                $('#select-email-template-block').addClass('d-none');
                $('#email_template option:eq(1)').prop('selected', true);
                $('.note-editable').html(
                    '<p>Dear <strong>Sir/Madam</strong>,</p><p>It was pleasure talking to you , hope our discussion has lead you in right direction. As per our conversation we will need following docs to structure our proposal</p><ul>' +
                    file_name +
                    '</ul><p>Once all docs in hand , we shall structure the file and call you with details of suited product as per need before I proceed.</p><p>Meanwhile please feel free to contact us for any queries.</p><br>'
                );
                $('#con-close-modal').modal('show');
            } else {
                $('<div class="error-block-attachment"><label id="title-error" class="error" for="title">Please checked any one document</label></div>')
                    .insertBefore('#request-document-file');
            }
        });

        $('#send-mail-with-attach-file').click(function() {

            $('.attachment-add').hide();
            $('#attachment_add').val('');

            if ($('.error-block-attachment').length != 0) {
                $('.error-block-attachment').first().remove();
            }

            var attachments_files = $("input[name='sending-documents']:checked").map(function() {
                if ($(this).attr('data-file-extension') != "") {
                    return $(this).attr('data-attachment');
                }
            }).get();

            if (attachments_files != "") {
                $('input[name="attachments_files"]').val(attachments_files.join(', '));
                var attachment_links = '';
                var html = "<h5>Document Attachment</h5>";
                $.each(attachments_files, function(index, obj) {
                    var link = "<a href=" + obj + " target='blank'>" + obj + "</a><br>";
                    attachment_links += link;
                });
                $('#attachment-files').html(html + attachment_links);
                $('#select-email-template-block').addClass('d-none');
                $('#email_template option:eq(1)').prop('selected', true);
                $('#con-close-modal').modal('show');
            } else {
                $('<div class="error-block-attachment"><label id="title-error" class="error" for="title">Please checked any one document</label></div>')
                    .insertBefore('#send-mail-with-attach-file');
            }
        });

        $('body').on('click', '.upload-document-delete', function() {
            var btn = $(this);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

            var id = $(this).attr('data-id');
            $(this).parents('label').fadeOut(300, function() {
                $(this).remove();
            });
            $('.gocover').show();
            $.ajax({
                url: '{{ url('admin/upload-documents/delete') }}',
                type: "POST",
                data: {
                    id: id
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                },
                error: function() {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                }
            });
        });

        $('.mail-send-inquiry').click(function() {
            var message = $('.note-editable').html();

            if (message == "<p><br></p>") {
                $('#summernote').val('');
                $('#summernote_message').val('');
            } else {
                $('#summernote').val(message);
                $('#summernote_message').val(message);
            }

            var form = $("#email_send");
            $(".mail-send-inquiry").attr("disabled", false);

            $.validator.addMethod(
                "multiemails",
                function(value, element, regexp) {
                    var allOk = true;
                    if (value.indexOf(',') > -1) {
                        var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                        var result = value.replace(/\s/g, "").split(/,|;/);
                        for (var i = 0; i < result.length; i++) {
                            var status = (regex.test(result[i])) ? true : false;
                            if (!status) {
                                allOk = false;
                            }
                        }
                    }
                    return allOk;
                },
                "Please input valid to emails."
            );

            form.validate({
                //ignore: [],
                ignore: "[contenteditable='true']:not([name])",
                rules: {
                    email_template: {
                        required: true
                    },
                    to: {
                        required: true,
                        multiemails: true
                    },
                    subject: {
                        required: true
                    },
                    summernote_message: {
                        required: true
                    },
                },
                messages: {
                    email_template: {
                        required: "Please select the email template"
                    },
                    to: {
                        required: "Please enter the to email",
                        multiemails: "Please input valid to emails."
                    },
                    subject: {
                        required: "Please enter the subject"
                    },
                    summernote_message: {
                        required: "Please enter the message"
                    },
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }
            });

            if (form.valid() == true) {
                var message = $('#summernote_message').val();
                var application_id_val = $('#application_id_val').val();
                var email_to = $('input[name="to"]').val();
                var subject = $('input[name="subject"]').val();
                var attachments = $('input[name="attachments_files"]').val();
                var from_email = $('#from_email').val();
                $(".mail-send-inquiry").attr("disabled", true);

                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'application_id_val': application_id_val,
                        'message': message,
                        'email_to': email_to,
                        'subject': subject,
                        'attachments': attachments,
                        'from_email': from_email
                    },
                    success: function(data) {
                        if (data.status == "200") {
                            toastr.success(data.message);
                            $('#con-close-modal').modal('hide');
                            $('#attachment-files').remove();
                            $('#email_send')[0].reset();
                            $('.note-editable').html('');
                            $('#summernote_message').val('');
                            $('.my-cu-check-uncheck2').removeAttr('checked');
                            $('.my-cu-check-uncheck2:checked').trigger('click');
                        }
                    },
                    beforeSend: function() {
                        // Code to display spinner
                        $('.mailloader').show();
                        var btn = $(".mail-send-inquiry");
                        var originalHtml = btn.html();
                        btn.data('original-html', originalHtml);
                        btn.prop('disabled', true).html(
                            '<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);
                    },
                    complete: function() {
                        // Code to hide spinner.
                        $('.mailloader').hide();
                        var btn = $(".mail-send-inquiry");
                        btn.prop('disabled', false).html(btn.data('original-html'));
                    }
                });
            }
        });

        $("#email_template").change(function() {
                    var email_template_id = $(this).val();

                    $('.gocover').show();
                    $.ajax({
                            url: '{{ url('admin/get-email-template') }}',
                            type: "POST",
                            data: {
                                "email_template_id": email_template_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('.gocover').hide();
                                if (data.status == "200") {
                                    $('#email_send input[name="subject"]').val(data.subject);
                                    $('.note-editable').html(data.html);
                                }
                                return allOk;
                            },
                            "Please input valid to emails."
                        );

                        form.validate({
                            //ignore: [],
                            ignore: "[contenteditable='true']:not([name])",
                            rules: {
                                email_template: {
                                    required: true
                                },
                                to: {
                                    required: true,
                                    multiemails: true
                                },
                                subject: {
                                    required: true
                                },
                                summernote_message: {
                                    required: true
                                },
                            },
                            error: function() {
                                $('.gocover').hide();
                            }
                        });
                    });

                $('.email-indent-link').click(function() {
                    $('.attachment-add').show();
                    $('#attachment_add').val('');
                    $('#email_template').val('').trigger('change');
                    $('#attachment-files').empty();
                    $('#attachments_files').val('');
                    $('.note-editable').html('');
                    $('.subject-val').val('');
                    $('.summernote-val').val('');
                    $('#select-email-template-block').removeClass('d-none');
                    $('#con-close-modal').modal('show');
                });

                $('#email-indent-model').click(function() {
                    $('#email_template').val('').trigger('change');
                    $('#con-close-modal').modal('show');
                });

                $('.summernote').summernote({
                    height: 230,
                    minHeight: null,
                    maxHeight: null,
                    focus: true
                });

                $(document).ready(function() {
                    $("body").on("click", ".resent-consent", function() {

                        $('.gocover').show();

                        var team_id = $(this).data('id');
                        var url = $(this).attr('data-action');

                        $.ajax({
                            type: 'POST',
                            url: url,
                            async: false,
                            data: {
                                team_id: team_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                toaserMessage(response.status, response.message);
                                $('.gocover').hide();
                                setTimeout(function() {
                                    @php
                                        $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                    @endphp
                                    window.location.href = "{{ $url }}";
                                }, 2000);
                            },
                            error: function(reject) {
                                if (reject.status === 422) {
                                    var errors = $.parseJSON(reject.responseText);
                                    errors = errors['errors'];
                                    toaserMessage(422, Object.values(errors)[0]);
                                }
                            }
                        });
                    });
                });

                $('.edit-document').click(function() {
                    $('#edit_document_model').modal('show');
                });

                $('#form_document_edit_btn').click(function() {
                    var btn = $(this);
                    var originalHtml = btn.html();
                    btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                    var url = $('#form_document_edit').closest('form').attr('action');
                    $('.gocover_modal').show();
                    $('.gocover').show();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        async: false,
                        data: $('#form_document_edit').closest('form').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            if (response.status == 200) {
                                $('#edit_document_model').modal('hide');
                                toaserMessage(response.status, response.message);
                                setTimeout(function() {
                                    @php
                                        $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                    @endphp
                                    window.location.href = "{{ $url }}";
                                }, 2000);
                            }
                        },
                        error: function(reject) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            if (reject.status === 422) {
                                var response = $.parseJSON(reject.responseText);
                                toaserMessage(422, response.message);
                            }
                        }
                    });
                });

                $('.hard-remove-document-image-new').click(function() {
                    var btn = $(this);
                    var originalHtml = btn.html();
                    btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

                    var url = $(this).data('url');
                    var document_id = $(this).attr('data-id');
                    var application_id = $(this).attr('data-application-id');

                    // Add confirmation dialog
                    var confirmation = confirm("Are you sure you want to delete this document?");

                    if (confirmation) {
                        $(this).closest('div.col-3').remove(); // Remove the element from the DOM

                        $('.gocover').show();
                        $.ajax({
                            type: 'POST',
                            url: url,
                            async: false,
                            data: {
                                document_id: document_id,
                                application_id: application_id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                btn.prop('disabled', false).html(originalHtml);
                                $('.gocover').hide();
                                if (response.status == 201) {
                                    toaserMessage(response.status, response.message);
                                }
                            },
                            error: function(reject) {
                                btn.prop('disabled', false).html(originalHtml);
                                $('.gocover').hide();
                                if (reject.status === 422) {
                                    var errors = $.parseJSON(reject.responseText);
                                    var errors = errors['errors'];
                                    toaserMessage(422, Object.values(errors)[0]);
                                }
                            }
                        });
                    } else {
                        btn.prop('disabled', false).html(originalHtml);
                        // Do nothing if the user cancels the deletion
                        return false;
                    }
                });

                $('.edit-directors-financial').click(function() {
                    var btn = $(this);
                    var originalHtml = btn.html();
                    btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

                    var Id = $(this).data('id');
                    $('.gocover').show();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('admin/loan/details/directors_financial') }}",
                        async: false,
                        data: {
                            'id': Id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            $('.directors_financial_id').val(response.data.id);
                            $('.team_size_id').val(response.data.team_size_id);
                            $('.asset_property_primary_residence').val(response.data
                                .asset_property_primary_residence);
                            $('.asset_property_other').val(response.data.asset_property_other);
                            $('.asset_bank_account').val(response.data.asset_bank_account);
                            $('.asset_super').val(response.data.asset_super);
                            $('.asset_other').val(response.data.asset_other);
                            $('.liability_homeloan_limit').val(response.data.liability_homeloan_limit);
                            $('.liability_homeloan_repayment').val(response.data
                                .liability_homeloan_repayment);
                            $('.liability_otherloan_limit').val(response.data.liability_otherloan_limit);
                            $('.liability_otherloan_repayment').val(response.data
                                .liability_otherloan_repayment);
                            $('.liability_all_card_limit').val(response.data.liability_all_card_limit);
                            $('.liability_all_card_repayment').val(response.data
                                .liability_all_card_repayment);
                            $('.liability_car_personal_limit').val(response.data
                                .liability_car_personal_limit);
                            $('.liability_car_personal_repayment').val(response.data
                                .liability_car_personal_repayment);
                            $('.liability_living_expense_limit').val(response.data
                                .liability_living_expense_limit);
                            $('.liability_living_expense_repayment').val(response.data
                                .liability_living_expense_repayment);

                        },
                        error: function(reject) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            if (reject.status === 422) {
                                var errors = $.parseJSON(reject.responseText);
                                var errors = errors['errors'];
                                toaserMessage(422, Object.values(errors)[0]);
                            }
                        }
                    });

                    $('#edit_directors_financial_model').modal('show');
                });

                $('#form_directors_financial_edit_btn').click(function() {
                    var btn = $(this);
                    var originalHtml = btn.html();
                    btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                    var url = $('#form_directors_financial_edit').closest('form').attr('action');
                    $('.gocover').show();
                    $.ajax({
                        type: 'POST',
                        url: url,
                        async: false,
                        data: $('#form_directors_financial_edit').closest('form').serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            if (response.status == 200) {
                                $('#edit_directors_financial_model').modal('hide');
                                toaserMessage(response.status, response.message);
                                setTimeout(function() {
                                    @php
                                        $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                    @endphp
                                    window.location.href = "{{ $url }}";
                                }, 2000);
                            }
                        },
                        error: function(reject) {
                            btn.prop('disabled', false).html(originalHtml);
                            $('.gocover').hide();
                            if (reject.status === 422) {
                                var errors = $.parseJSON(reject.responseText);
                                var errors = errors['errors'];

                                $('.help-block').text('');

                                $.each(errors, function(field_name, error) {
                                    var string = error[0];
                                    var modifiedError = string.replace(/\.\d\s?/, ' ');
                                    var error_text = modifiedError.replace(/_/g, ' ');

                                    if (field_name == "asset_property_primary_residence" ||
                                        field_name == "asset_property_other" || field_name ==
                                        "asset_bank_account" || field_name == "asset_super" ||
                                        field_name == "asset_other") {
                                        $('input[name="' + field_name + '"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else if (field_name === "business_trade_year") {
                                        $('select[name="' + field_name + '"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                    } else {
                                        var field = field_name.replace(/[0-9]/g, '').replace('.',
                                            '');
                                        var number = field_name.replace(/\D/g, "");

                                        if (field === "title" || field === "residential_status" ||
                                            field === "gender" || field === "marital_status" ||
                                            field === "time_in_business" || field ===
                                            "time_at_business"
                                        ) {
                                            $('.additional_clone').eq(number).find('select[name="' +
                                                field + '[]"]').next('span').after(
                                                '<span class="help-block error-block text-danger"><small>' +
                                                error_text + '</small></span>');
                                        } else {
                                            //alert(field);
                                            $('.additional_clone').eq(number).find('input[name="' +
                                                field + '[]"]').after(
                                                '<span class="help-block error-block text-danger"><small>' +
                                                error_text + '</small></span>');

                                            $('.assets-members').eq(number).find('input[name="' +
                                                field + '[]"]').after(
                                                '<span class="help-block error-block text-danger"><small>' +
                                                error_text + '</small></span>');
                                        }
                                    }

                                });
                            }
                        }
                    });
                });
    </script>

    @if ($application->apply_for == 1)
        <script>
            $('.business_trade_year').select2();

            $('.edit-business-financial').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

                var securityId = $(this).data('id');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/loan/details/business_financial') }}",
                    async: false,
                    data: {
                        'id': securityId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        $('.business_financial_id').val(response.data.id);
                        $('.business_trade_year').val(response.data.business_trade_year).trigger('change');
                        $('.gross_income').val(response.data.gross_income);
                        $('.total_expenses').val(response.data.total_expenses);
                        $('.net_income').val(response.data.net_income);

                        $('.finance_periods').each(function() {
                            if ($(this).val() == response.data.finance_periods) {
                                $(this).prop('checked', true);
                            }
                        });

                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];
                            toaserMessage(422, Object.values(errors)[0]);
                        }
                    }
                });

                $('#edit_business_financial_model').modal('show');
            });

            $('#form_business_financial_edit_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_business_financial_edit').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_business_financial_edit').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#edit_business_financial_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "gross_income" || field_name ==
                                    "total_expenses" || field_name == "net_income") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else if (field_name === "business_trade_year") {
                                    $('select[name="' + field_name + '"]').next('span').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });

            $('#form_business_financial_add_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_business_financial_add').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_business_financial_add').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#add_business_financial_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "gross_income" || field_name ==
                                    "total_expenses" || field_name == "net_income") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else if (field_name === "business_trade_year") {
                                    $('select[name="' + field_name + '"]').next('span').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });

            $('#add-business-financial').click(function() {
                $('#add_business_financial_model').modal('show');
            });
        </script>
    @else
        <script>
            $('#edit_security_model').on('shown.bs.modal', function() {
                initializeAutocompleteS($(".property_address_val")[0]);
            });

            $('.edit-property-security').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

                var securityId = $(this).data('id');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/loan/details/property_security') }}",
                    async: false,
                    data: {
                        'id': securityId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        $('.security_id').val(response.data.id);
                        $('#hidden_purpose').val(response.data.purpose);
                        $('#hidden_property_type').val(response.data.property_type);
                        $('.property_owner_json').val(response.data.property_owner);
                        try {
                            var owners = JSON.parse(response.data.property_owner);
                            $('.property-owner-wrapper .owner-inputs-container').empty();
                            if (Array.isArray(owners) && owners.length > 0) {
                                $.each(owners, function(index, owner) {
                                    var btn = (index === 0) ?
                                        '<button type="button" class="btn btn-success ml-2 add-property-owner"><i class="mdi mdi-plus"></i></button>' :
                                        '<button type="button" class="btn btn-danger ml-2 remove-property-owner"><i class="mdi mdi-minus"></i></button>';
                                    var html = '<div class="owner-input-group d-flex mb-2">' +
                                        '<input type="text" class="form-control property_owner_name property_owner_val" placeholder="Property Owner" value="' +
                                        (owner.name || '') + '" >' +
                                        btn +
                                        '</div>';
                                    $('.property-owner-wrapper .owner-inputs-container').append(
                                        html);
                                });
                            }
                        } catch (e) {
                            $('.property-owner-wrapper .owner-inputs-container').empty();
                            var html = '<div class="owner-input-group d-flex mb-2">' +
                                '<input type="text" class="form-control property_owner_name property_owner_val" placeholder="Property Owner" value="' +
                                (response.data.property_owner || '') + '" >' +
                                '<button type="button" class="btn btn-success ml-2 add-property-owner"><i class="mdi mdi-plus"></i></button>' +
                                '</div>';
                            $('.property-owner-wrapper .owner-inputs-container').append(html);
                        }
                        $('.property_address').val(response.data.property_address);
                        $('.property_value').val(response.data.property_value);

                        $('.purpose').each(function() {
                            if ($(this).val() == response.data.purpose) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });

                        $('.property_type').each(function() {
                            if ($(this).val() == response.data.property_type) {
                                $(this).prop('checked', true);
                            }
                        });
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];
                            toaserMessage(422, Object.values(errors)[0]);
                        }
                    }
                });

                $('#edit_security_model').modal('show');
            });

            $('#form_security_edit_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_security_edit').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_security_edit').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#edit_security_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "property_address" || field_name ==
                                    "property_value") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });

            $('#form_security_add_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_security_add').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_security_add').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#add_security_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "property_address" || field_name ==
                                    "property_value") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });

            $('#add_security_model').on('shown.bs.modal', function() {
                initializeAutocompleteS($(".property_address")[0]);
            });

            $('#add_crypto_model').on('shown.bs.modal', function() {
                initializeAutocompleteS($(".property_address")[0]);
            });

            $('#add-property-security').click(function() {
                $('#add_security_model').modal('show');
            });

            $('#form_crypto_add_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_crypto_add').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_crypto_add').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#add_crypto_security_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "property_address" || field_name ==
                                    "property_value") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });

            $('#add-crypto-security').click(function() {
                $('#add_crypto_model').modal('show');
            });

            $('#edit_security_model').on('shown.bs.modal', function() {
                initializeAutocompleteS($(".property_address_val")[0]);
            });

            $('.edit-crypto-security').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

                var securityId = $(this).data('id');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('admin/loan/details/crypto_security') }}",
                    async: false,
                    data: {
                        'id': securityId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        $('.security_id').val(response.data.id);
                        $('#hidden_purpose').val(response.data.purpose);
                        $('#hidden_property_type').val(response.data.property_type);
                        $('.property_owner').val(response.data.property_owner);
                        $('.property_address').val(response.data.property_address);
                        $('.property_value').val(response.data.property_value);

                        $('.purpose').each(function() {
                            if ($(this).val() == response.data.purpose) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });

                        $('.property_type').each(function() {
                            if ($(this).val() == response.data.property_type) {
                                $(this).prop('checked', true);
                            }
                        });
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];
                            toaserMessage(422, Object.values(errors)[0]);
                        }
                    }
                });

                $('#edit_crypto_model').modal('show');
            });

            $('#form_crypto_edit_btn').click(function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

                var url = $('#form_crypto_edit').closest('form').attr('action');
                $('.gocover').show();
                $.ajax({
                    type: 'POST',
                    url: url,
                    async: false,
                    data: $('#form_crypto_edit').closest('form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (response.status == 200) {
                            $('#edit_crypto_model').modal('hide');
                            toaserMessage(response.status, response.message);
                            setTimeout(function() {
                                @php
                                    $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                                @endphp
                                window.location.href = "{{ $url }}";
                            }, 2000);
                        }
                    },
                    error: function(reject) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('.gocover').hide();
                        if (reject.status === 422) {
                            var errors = $.parseJSON(reject.responseText);
                            var errors = errors['errors'];

                            $('.help-block').text('');

                            $.each(errors, function(field_name, error) {
                                var string = error[0];
                                var modifiedError = string.replace(/\.\d\s?/, ' ');
                                var error_text = modifiedError.replace(/_/g, ' ');

                                if (field_name == "property_address" || field_name ==
                                    "property_value") {
                                    $('input[name="' + field_name + '"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                    var number = field_name.replace(/\D/g, "");

                                    if (field === "title" || field === "residential_status" ||
                                        field === "gender" || field === "marital_status" ||
                                        field === "time_in_business" || field === "time_at_business"
                                    ) {
                                        $('.additional_clone').eq(number).find('select[name="' +
                                            field + '[]"]').next('span').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    } else {
                                        //alert(field);
                                        $('.additional_clone').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');

                                        $('.assets-members').eq(number).find('input[name="' +
                                            field + '[]"]').after(
                                            '<span class="help-block error-block text-danger"><small>' +
                                            error_text + '</small></span>');
                                    }
                                }

                            });
                        }
                    }
                });
            });
        </script>
    @endif

    <script>
        function formatDate(dateString) {
            if (dateString != '') {
                var dateParts = dateString.split('-');
                return dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
            } else {
                return "";
            }
        }

        $('.edit-director-application').click(function() {
            var btn = $(this);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i>');

            var directorId = $(this).data('id');

            $('.gocover').show();
            $.ajax({
                type: 'POST',
                url: "{{ url('admin/loan/details/team') }}",
                async: false,
                data: {
                    'id': directorId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    $('#team_size_id').val(response.data.id);
                    $('.title-1').val(response.data.title).trigger('change');
                    $('#firstname').val(response.data.firstname);
                    $('#lastname').val(response.data.lastname);
                    $('#address').val(response.data.address);
                    $('.residential_status-1').val(response.data.residential_status).trigger('change');
                    $('.marital_status-1').val(response.data.marital_status).trigger('change');
                    $('.gender-1').val(response.data.gender).trigger('change');
                    $('#mobile').val(response.data.mobile);
                    $('.landline').val(response.data.landline);
                    $('.license_number').val(response.data.license_number);
                    $('#email_address').val(response.data.email_address);
                    $('.license_card_number').val(response.data.card_number);
                    $('#position').val(response.data.position);
                    $('.time_in_business-1').val(response.data.time_in_business).trigger('change');
                    $('.time_at_business-1').val(response.data.time_at_business).trigger('change');
                    $('#dob').val(formatDate(response.data.dob));
                    $('#license_expiry_date').val(formatDate(response.data.license_expiry_date));
                },
                error: function(reject) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];
                        toaserMessage(422, Object.values(errors)[0]);
                    }
                }
            });

            $('#update_director_model').modal('show');
        });

        $('#update_director_model').on('shown.bs.modal', function() {
            initializeAutocompleteS($(".buz_address")[0]);
        });

        $('#form_director_update_btn').click(function() {
            var btn = $(this);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

            var url = $('#form_director_update').closest('form').attr('action');
            $('.gocover').show();
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: $('#form_director_update').closest('form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (response.status == 200) {
                        $('#update_director_model').modal('hide');
                        toaserMessage(response.status, response.message);
                        setTimeout(function() {
                            @php
                                $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                            @endphp
                            window.location.href = "{{ $url }}";
                        }, 2000);
                    }
                },
                error: function(reject) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];

                        $('.help-block').text('');

                        $.each(errors, function(field_name, error) {
                            var string = error[0];
                            var modifiedError = string.replace(/\.\d\s?/, ' ');
                            var error_text = modifiedError.replace(/_/g, ' ');

                            if (field_name === "business_trade_year" || field_name ==
                                "year_established" || field_name == "business_structure" ||
                                field_name == "trade") {
                                $('select[name="' + field_name + '"]').next('span').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "brief_notes") {
                                $('textarea[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "mobile_no" || field_name ==
                                "business_email" || field_name == "business_address" ||
                                field_name == "business_name" || field_name == "abn_acn" ||
                                field_name == "m_loan_amount" || field_name ===
                                "finance_periods" || field_name === "gross_income" ||
                                field_name === "total_expenses" || field_name === "net_income"
                            ) {
                                $('input[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else {
                                var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                var number = field_name.replace(/\D/g, "");

                                if (field === "title" || field === "residential_status" ||
                                    field === "gender" || field === "marital_status" ||
                                    field === "time_in_business" || field === "time_at_business"
                                ) {
                                    $('.additional_clone').eq(number).find('select[name="' +
                                        field + '[]"]').next('span').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    //alert(field);
                                    $('.additional_clone').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.d-property-sec').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.assets-members').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                }
                            }

                        });
                    }
                }
            });
        });

        function initializeAutocompleteS(inputElement) {

            var options = {
                types: ['geocode'],
                componentRestrictions: {
                    country: 'AU'
                }
            };

            var autocomplete = new google.maps.places.Autocomplete(inputElement, options);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                // Handle place data for both input fields
                console.log(place.address_components);
            });
        }

        //initializeAutocompleteS($(".business_address")[0]);
        initializeAutocompleteS($(".buz_address")[0]);

        $('#add-director').click(function() {
            $('#add_director_model').modal('show');
        });

        $('#add_director_model').on('shown.bs.modal', function() {
            initializeAutocompleteS($(".buz_address")[0]);
        });

        $('#form_director_add_btn').click(function() {
            var btn = $(this);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

            var url = $('#form_director_add').closest('form').attr('action');
            $('.gocover').show();
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: $('#form_director_add').closest('form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (response.status == 200) {
                        $('#add_director_model').modal('hide');
                        toaserMessage(response.status, response.message);
                        setTimeout(function() {
                            @php
                                $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                            @endphp
                            window.location.href = "{{ $url }}";
                        }, 2000);
                    }
                },
                error: function(reject) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];

                        $('.help-block').text('');

                        $.each(errors, function(field_name, error) {
                            var string = error[0];
                            var modifiedError = string.replace(/\.\d\s?/, ' ');
                            var error_text = modifiedError.replace(/_/g, ' ');

                            if (field_name === "business_trade_year" || field_name ==
                                "year_established" || field_name == "business_structure" ||
                                field_name == "trade") {
                                $('select[name="' + field_name + '"]').next('span').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "brief_notes") {
                                $('textarea[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "mobile_no" || field_name ==
                                "business_email" || field_name == "business_address" ||
                                field_name == "business_name" || field_name == "abn_acn" ||
                                field_name == "m_loan_amount" || field_name ===
                                "finance_periods" || field_name === "gross_income" ||
                                field_name === "total_expenses" || field_name === "net_income"
                            ) {
                                $('input[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else {
                                var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                var number = field_name.replace(/\D/g, "");

                                if (field === "title" || field === "residential_status" ||
                                    field === "gender" || field === "marital_status" ||
                                    field === "time_in_business" || field === "time_at_business"
                                ) {
                                    $('.additional_clone').eq(number).find('select[name="' +
                                        field + '[]"]').next('span').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    //alert(field);
                                    $('.additional_clone').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.d-property-sec').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.assets-members').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                }
                            }

                        });
                    }
                }
            });
        });

        function initializeAutocomplete() {
            var options = {
                types: ['geocode'],
                componentRestrictions: {
                    country: 'AU'
                }
            };

            // Initialize autocomplete on the input field inside the modal
            var autocomplete = new google.maps.places.Autocomplete($("#business_address")[0], options);

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log(place.address_components); // You can log the place for debugging
            });
        }

        $(document).ready(function() {
            initializeAutocomplete();

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
                let newAmount = Math.max(0, currentAmount -
                    incrementValue); // Ensure amount doesn't go below 0
                $('#m_loan_amount').val(newAmount.toLocaleString());
                var loan_amount = newAmount.toLocaleString();
                loan_amount = loan_amount.replace(/[^0-9]/g, '');
                $('input[name="loan_amount_requested"]').val(loan_amount);
            });

            $('#year_established').select2();
            $('#business_structure').select2();
            $('#trade').select2();

            $('#title-1').select2();
            $('#residential_status-1').select2();
            $('#marital_status-1').select2();
            $('#gender-1').select2();
            $('#time_in_business-1').select2();
            $('#time_at_business-1').select2();

            $('.title-1').select2();
            $('.residential_status-1').select2();
            $('.marital_status-1').select2();
            $('.gender-1').select2();
            $('.time_in_business-1').select2();
            $('.time_at_business-1').select2();
        });

        $('.add-manual-amount-btn').click(function() {
            $(this).closest('.form-group').next('.form-group').removeClass('d-none');
            $(this).closest('.form-group').remove();
        });

        $('#discharge_fee').on('change', function() {
            var dischargeFeeValue = $(this).val();
            if (dischargeFeeValue == 'noval') {
                $('.discharge_fee_2').show();
            } else {
                $('.discharge_fee_2').hide();
                $('.discharge_fee_2').val('');
            }
        });

        $('#m_loan_amount').on('keyup', function() {
            var loan_amount = $(this).val();
            loan_amount = loan_amount.replace(/[^0-9]/g, '');
            $('input[name="loan_amount_requested"]').val(loan_amount);
            $('.error-block').remove();
            var apply_for = $('#apply_for').val();

            if (apply_for == 1) {
                if (loan_amount < 1 || loan_amount > 100000) {
                    $('input[id="m_loan_amount"]').after(
                        '<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $100,000</small></span>'
                    );
                }
            } else {
                if (loan_amount < 1 || loan_amount > 10000000) {
                    $('input[id="m_loan_amount"]').after(
                        '<span class="help-block error-block text-danger"><small>The loan amount must be between $1 and $10,000,000</small></span>'
                    );
                }
            }
        });

        $('#form_loan_application_update_btn').click(function() {
            var btn = $(this);
            var originalHtml = btn.html();
            btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);

            var url = $('#form_loan_application_update').closest('form').attr('action');
            $('.gocover').show();
            $.ajax({
                type: 'POST',
                url: url,
                async: false,
                data: $('#form_loan_application_update').closest('form').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (response.status == 200) {
                        $('#edit_business_model').modal('hide');
                        toaserMessage(response.status, response.message);
                        setTimeout(function() {
                            @php
                                $url = url('admin/loan/details/' . Crypt::encrypt($application->id));
                            @endphp
                            window.location.href = "{{ $url }}";
                        }, 2000);
                    }
                },
                error: function(reject) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('.gocover').hide();
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        var errors = errors['errors'];

                        $('.help-block').text('');

                        $.each(errors, function(field_name, error) {
                            var string = error[0];
                            var modifiedError = string.replace(/\.\d\s?/, ' ');
                            var error_text = modifiedError.replace(/_/g, ' ');

                            if (field_name === "business_trade_year" || field_name ==
                                "year_established" || field_name == "business_structure" ||
                                field_name == "trade") {
                                $('select[name="' + field_name + '"]').next('span').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "brief_notes") {
                                $('textarea[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else if (field_name == "mobile_no" || field_name ==
                                "business_email" || field_name == "business_address" ||
                                field_name == "business_name" || field_name == "abn_acn" ||
                                field_name == "m_loan_amount" || field_name ===
                                "finance_periods" || field_name === "gross_income" ||
                                field_name === "total_expenses" || field_name === "net_income"
                            ) {
                                $('input[name="' + field_name + '"]').after(
                                    '<span class="help-block error-block text-danger"><small>' +
                                    error_text + '</small></span>');
                            } else {
                                var field = field_name.replace(/[0-9]/g, '').replace('.', '');
                                var number = field_name.replace(/\D/g, "");

                                if (field === "title" || field === "residential_status" ||
                                    field === "gender" || field === "marital_status" ||
                                    field === "time_in_business" || field === "time_at_business"
                                ) {
                                    $('.additional_clone').eq(number).find('select[name="' +
                                        field + '[]"]').next('span').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                } else {
                                    //alert(field);
                                    $('.additional_clone').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.d-property-sec').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');

                                    $('.assets-members').eq(number).find('input[name="' +
                                        field + '[]"]').after(
                                        '<span class="help-block error-block text-danger"><small>' +
                                        error_text + '</small></span>');
                                }
                            }

                        });
                    }
                }
            });
        });

        $('#edit-business-application').click(function() {
            $('#edit_business_model').modal('show');
        });

        $('#edit_business_model').on('shown.bs.modal', function() {
            initializeAutocomplete();
        });

        // Store the old value initially
        var previousStatus = '{{ $application->status_id }}';

        $('#status_vals').change(function() {
            $('#is_edit_val').val('');
            var popup_status_id = $(this).val();
            var popup_application_id = $('#application_id_val').val();
            var validStatuses = [5, 7, 8, 9, 11, 12];

            // Check if the selected status is not null
            if (!popup_status_id) {
                toaserMessage(422, "Please select a valid status.");
                //$(this).val(previousStatus);
                return;
            }

            if ($.inArray(parseInt(popup_status_id), validStatuses) !== -1) {

                if (popup_status_id == 5) {
                    $('#conditionally_approved').modal('show');
                } else {
                    // Reset values and show modal if status matches
                    $('#popup_assessor_note').val('');
                    $('#popup_application_id').val(popup_application_id);
                    $('#popup_status_id').val(popup_status_id);
                    $('#status_notes').modal('show');
                    //previousStatus = popup_status_id;
                }
            } else {
                // Show SweetAlert2 confirmation before making the AJAX request
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to update the status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = $('#update-status').attr('action');

                        $('.gocover').show();
                        Swal.showLoading();
                        // AJAX request to update status
                        $.ajax({
                            type: 'POST',
                            url: url,
                            async: false,
                            data: $("#update-status").serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('.gocover').hide();
                                if (response.status == 201) {
                                    toaserMessage(response.status, response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 3000);
                                } else {
                                    // Scroll to the note field if there's an issue
                                    $('#assessor_note').focus()[0].scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                    toaserMessage(response.status, response.message);
                                }
                            },
                            error: function(reject) {
                                $('.gocover').hide();
                                if (reject.status === 422) {
                                    var errors = $.parseJSON(reject.responseText);
                                    var errors = errors['errors'];
                                    toaserMessage(422, Object.values(errors)[0]);
                                }
                            }
                        });
                        // Update previous status to current after successful save
                        //previousStatus = popup_status_id;
                    } else {
                        // Revert to the previous status if the user cancels
                        $('#status_vals').val(previousStatus);
                    }
                });
            }
        });

        // When the modal is closed without confirmation, revert to the old value
        $('.close-notestag').click(function() {
            $('#status_vals').val(previousStatus);
        });

        $('.close-conditionally-approved').click(function() {
            $('#status_vals').val(previousStatus);
        });

        $('#edit-conditionally-approved').click(function() {
            $('#is_edit_val').val('1');
            $('#conditionally_approved').modal('show');
        });

        $('.submit-conditionally-approved').click(function() {
            var btn = $(this);
            var originalHtml = btn.html();

            var form = $("#conditionally_approved_form");

            form.validate({
                ignore: ":hidden:not(:visible)",
                rules: {
                    facility_limit: {
                        required: true
                    },
                    facility_term: {
                        required: true
                    },
                    applied_interest_rate_per_month: {
                        required: true
                    },
                    applied_annual_interest: {
                        required: true
                    },
                    payment_type: {
                        required: true
                    },
                    repayment_amount: {
                        required: true
                    },
                    repayment_description: {
                        required: true
                    },
                    settlement_conditions_descriptions: {
                        required: true
                    },
                    application_fee: {
                        required: true
                    },
                    documentation_fee: {
                        required: true
                    },
                    valuation_fee: {
                        required: true
                    },
                    discharge_fee: {
                        required: true
                    },
                    other_fee: {
                        required: true
                    },
                    disbursement_fees: {
                        required: true
                    },
                    ppsr_value: {
                        required: true
                    },
                    lvr_current: {
                        required: true
                    },
                },
                /*messages: {
                    facility_limit: { required: "Please enter the facility limit" },
                },*/
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // Adjust the placement if needed
                    console.log("Validation Error: ", error.text()); // Debugging
                }
            });

            if (form.valid() === true) {
                var facility_limit = $('#facility_limit').val();
                var application_id_val = $('#conditionally_approved_application_id').val();
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form.serialize(),
                    success: function(data) {
                        if (data.status === 200) {
                            toastr.success(data.message);
                            $('#conditionally_approved').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                    },
                    beforeSend: function() {
                        btn.prop('disabled', true).html(
                            '<i class="mdi mdi-loading mdi-spin mr-1"></i> ' + originalHtml);
                        // Add a loading spinner if needed
                        $('.gocover').show();
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalHtml);
                        // Remove the spinner if added
                        $('.gocover').hide();
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('comman/libs/trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="https: //stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection
