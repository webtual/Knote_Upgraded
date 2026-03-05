<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <style>
        .page-break {
            page-break-after: always;
        }
        
        body, .page-break-avoid
        {
            page-break-inside: avoid;
        }

        @media print {
            @page {
                size: letter;
                margin: 2px;
            }
        }

        * {
            font-family: Helvetica, Arial, sans-serif;
            font-size: small;
        }

        .font-weight-bolder {
            font-weight: 600 !important;
        }
        .text-success {
            color: #28c76f !important;
            text-decoration: none;
        }
        .text-danger {
            color: #ea5455 !important;
        }
        .text-info {
            color: #00cfe8 !important;
        }
        .my-0{
            margin-top: 0;
            margin-bottom: 0;
        }
        table{
            /*margin-bottom: 12px;*/
        }
        table tr td {
           vertical-align: top;
        }
        h1{
            font-size: 12px;
        }
        h3{
            font-size: 14px;
            color: #343a40;
            margin: 0;
        }
        .hr-line{
            border-width: .5px;
            color: #f6f6f6;
        }
        .card-table{
            padding: 0px 10px;
            border: 1px solid #ccc;
            width: 100%;
        }
        
        .card-table tr td b{
            font-size: 12px !important;
        }
        
        .card-table tr td,.card-table tr th{
            padding: 2px 8px;
            font-size: 12px;
        }
        .applicant-proproetor
        {
            color: #1abc9c !important;
            font-size: 14px;
        }
        .card-table-2{
            padding: 0px 10px;
            border: 1px solid #ccc;
            width: 100%;
        }
        
        .card-table-2 table tr td b{
            font-size: 12px !important;
        }
        
        .card-table-2 table tr td{
            padding: 2px 8px;
            font-size: 12px;
        }
        .liabilities-title{
            width: 40%;
        }
        .liabilities-limit{
            width: 30%;
            text-align: right;
        }
        .document-table,.document-table table{
            width:100%;
            border-collapse: collapse;
        }
        .document-table tr td{
            border: 1px solid #ccc;
        }
        .document-table tr table{
            margin-bottom: 0px;
        }
        .link-table tr td{
            border:0px !important;
            border-bottom: 1px solid #ccc !important;
        }
        .link-table tr::last-child td{
            border:0px !important;
            border-bottom:0px !important;
        }
        .link{
            text-decoration: none;
            color: #1abc9c!important;
        }
        .briefnotes{
            font-size: 10px;
            color: #343a40;
            margin-top: 0px;
        }
    </style>
</head>
<body>
@php
    $apply_for = config('constants.apply_for');
    use App\User;
    $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
    $know_about_us_val = $application->know_about_us == 8 ? $application->know_about_us_others : ($KNOW_ABOUT_US_VAL[$application->know_about_us] ?? '');
@endphp
<table style="width:100%;">
    <tbody>
        <tr>
            <td>
                <h1 class="my-0" style="padding-bottom:6px;">Apply For : {{ ($apply_for[$application->apply_for])  }}</h1>
                <span style="font-size:16px;"><b>Status : </b>{{ $application->current_status->status }}</span>
            </td>
            <td style="text-align:center;vertical-align: top;">
                <span style="text-align:left;display:block;"><b style="display:block;padding-bottom:5px;">Application Number</b>{{ $application->application_number }}</span>
            </td>
        </tr>
        <tr >
            <td colspan="2">
                <hr class="hr-line">
            </td>
        </tr>
    </tbody>
</table>
<table>
    <tr>
        <td>
            <h3 class="my-0">Business Information</h3>
        </td>
    </tr>
</table>
<table class="card-table">
    <tr>
        <td style="width:200px;"><b>Customer No :</b></td>
        <td style="width:auto;">{{ $application->user->customer_no }}</td>
    </tr>
    <tr>
        <td style="width:200px;"><b>Customer Name :</b></td>
        <td style="width:auto;">{{ $application->user->name }}</td>
    </tr>
    <tr>
        <td><b>Customer Mobile :</b></td>
        <td>{{ display_aus_phone($application->user->phone) }}</td>
    </tr>
    <tr>
        <td><b>Customer Email :</b></td>
        <td>{{ $application->user->email }}</td>
    </tr>
    <tr>
        <td><b>Business Name :</b></td>
        <td>{{ $application->business_name }}</td>
    </tr>
    <tr>
        <td><b>ABN or ACN :</b></td>
        <td>{{ $application->abn_or_acn }}</td>
    </tr>
    <tr>
        <td><b>Loan Requested :</b></td>
        <td>{{ $application->loan_request_amount() }}</td>
    </tr>
    <tr>
        <td><b>Business Structure :</b></td>
        <td>{{ $application->business_structure->structure_type }}</td>
    </tr>
    <tr>
        <td><b>Year Established :</b></td>
        <td>{{ $application->years_of_established }}</td>
    </tr>
    <tr>
        <td><b>Business Address :</b></td>
        <td>{{ $application->business_address }}</td>
    </tr>
    <tr>
        <td><b>Mailing Address :</b></td>
        <td>{{ $application->business_email }}</td>
    </tr>
    <tr>
        <td><b>Mobile :</b></td>
        <td>{{ display_aus_phone($application->business_phone) }}</td>
    </tr>
    <tr>
        <td><b>Landline :</b></td>
        <td>{{ display_aus_landline($application->landline_phone) }}</td>
    </tr>
    <tr>
        <td><b>Industry :</b></td>
        <td>{{ $application->business_type->business_type }}</td>
    </tr>
    <tr>
        <td><b>How did you know about us? :</b></td>
        <td>{{ $know_about_us_val}}</td>
    </tr>
</table>

@if(sizeof($application->team_sizes) != 0)
<table>
    <tr>
        <td>
            <h3 class="">Applicant/Director/Proprietor</h3>
        </td>
    </tr>
</table>
@forelse($application->team_sizes as $key_team => $team)
<table class="card-table-2">
    <thead>
        <tr>
            <td style="padding: 2px 8px;"><b class="applicant-proproetor" colspan="2">Applicant/Director/Proprietor : {{ $key_team+1 }}</b></td>
        </tr>
    </thead>
    <tbody style="width:100%;">
        <tr>
            <td style="width:50%;">
                <table >
                    <tr >
                        <td><b >Name :</b></td>
                        <td>{{ config('constants.people_title')[$team->title].' '.$team->firstname.' '.$team->lastname }}</td>
                    </tr>
                    <tr>
                        <td><b style="white-space:nowrap;">Residential Address :</b></td>
                        <td>{{ $team->address }}</td>
                    </tr>
                    <tr>
                        <td><b>Residential Status :</b></td>
                        <td>
                            @if($team->residential_status != null)
    			                {{ config('constants.residential_status')[$team->residential_status] }}
    			            @endif
    			        </td>
                    </tr>
                    <tr>
                        <td><b>Marital Status :</b></td>
                        <td>
                            @if($team->marital_status != null)
                             {{ config('constants.marital_status')[$team->marital_status] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date of Birth :</b></td>
                        <td>{{ indian_date_format($team->dob) }}</td>
                    </tr>
                    <tr>
                        <td><b>Time at Address :</b></td>
                        <td>{{ ($team->time_at_business == "") ? '' : $team->time_at_business.' Years' }}</td>
                    </tr>
                    <tr>
                        <td><b>Time in Business :</b></td>
                        <td>{{ ($team->time_in_business == "") ? '' : $team->time_in_business.' Years' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr>
                        <td><b>Position :</b></td>
                        <td>{{ $team->position }}</td>
                    </tr>
                    <tr>
                        <td><b>Mobile :</b></td>
                        <td>{{ display_aus_phone($team->mobile) }}</td>
                    </tr>
                    <tr>
                        <td><b>Landline :</b></td>
                        <td>{{ display_aus_landline($team->landline) }}</td>
                    </tr>
                    <tr>
                        <td><b>License Number :</b></td>
                        <td>{{ $team->license_number }}</td>
                    </tr>
                    <tr>
                        <td><b>License Expiry Date :</b></td>
                        <td>{{ indian_date_format($team->license_expiry_date) }}</td>
                    </tr>
                    <tr>
                        <td><b>License Card Number :</b></td>
                        <td>{{ ($team->card_number) }}</td>
                    </tr>
                    <tr>
                        @php
                            $genderMap = config('constants.gender');
                            $gender = $team->gender ?? null;
                        @endphp
                        <td><b>Gender :</b></td>
                        <td>{{ $genderMap[$gender] ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 2px 8px;"><b class="applicant-proproetor" colspan="2">Consent Details</b></td>
        </tr>
        <tr>
            <td style="width:50%;">
                <table>
                    <tr >
                        <td><b >Consent By :</b></td>
                        <td>{{ config('constants.people_title')[$team->title].' '.$team->firstname.' '.$team->lastname }}</td>
                    </tr>
                    <tr>
                        <td><b style="white-space:nowrap;">Sent Date/Time :</b></td>
                        <td>{{ display_date_format_time($team->consent_sent_at) ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><b style="white-space:nowrap;">Download PDF :</b></td>
                        <td>
                            @if($team->consent_status == 1)
                                <span class="mb-2"><a class="text-success" title="Download PDF" href="{{ asset('storage/'.$team->consent_pdf_file) }}" download>Consent PDF</a></span>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width:50%;">
                <table>
                    <tr >
                        <td><b >IP Address :</b></td>
                        <td>{{ $team->ip_address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><b style="white-space:nowrap;">Verified Date/Time :</b></td>
                        <td>{{ display_date_format_time($team->verified_at) ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><b style="white-space:nowrap;">Status :</b></td>
                        <td>
                            {{ $team->consent_status == 1 ? 'Yes' : 'No' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<br>
@empty
@endforelse
<div class="page-break"></div>
@endif

@if($application->apply_for == 1)
    <table>
        <tr>
            <td>
               <h3 class="">Business Financial Information @if(!empty($application->finance_information)) {{ '('.config('constants.finance_periods')[$application->finance_information->finance_periods].' - '.$application->finance_information->business_trade_year.')' }} @endif </h3>
            </td>
        </tr>
    </table>
@else
    @php
        $titles_vals = [
            1 => 'Business Financial Information',
            2 => 'Property/Security',
            3 => 'Crypto/Security',
        ];
    @endphp
    @if($application->property_securities->count() > 0)
    <table>
        <tr>
            <td>
                <h3 class="">{{ $titles_vals[$application->apply_for] ?? '' }}</h3>
            </td>
        </tr>
    </table>
    @endif
@endif

<table class="card-table">
    @if($application->apply_for == 1)
    <tr>
        <td>
            <table class="card-table" style="border: 0px solid #ccc;">
                <tr>
                    <span><b>Gross Income : </b>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->gross_income) }} 
                                   @endif</span>
                </tr>
                <tr>
                    <span><b>Total Expense : </b>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->total_expenses) }} 
                                   @endif</span>
                </tr>
                <tr>
                    <span><b>Net Income : </b>@if(!empty($application->finance_information)) {{ money_format_amount($application->finance_information->net_income) }} 
                                   @endif</span>
                </tr>
            </table>
        </td>
    </tr>
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
            @foreach($application->property_securities as $key_property => $property)
                <tr>
                    <td>
                        @if($application->apply_for == 2)
                            <table class="card-table">
                                <tr>
                                    <span><b>Type of Property / Security : </b>{{ ($property_loan_types[$property->purpose])  }} - {{ ($type_of_property[$property->property_type]) }}</span>
                                </tr>
                                <tr>
                                    <span><b>Property Address : </b>{{ ($property->property_address) }}</span>
                                </tr>
                                <tr>
                                    <span><b>Property Value : </b>{{ money_format_amount($property->property_value) }}</span>
                                </tr>
                            </table>
                        @endif
                        @if($application->apply_for == 3)
                            <table class="card-table">
                                <tr>
                                    <span><b>Type of Crypto / Security : </b>{{ ($property_loan_types[$property->property_type]) }}</span>
                                </tr>
                                <tr>
                                    <span><b>Crypto Value : </b>{{ money_format_amount($property->property_value) }}</span>
                                </tr>
                            </table>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    @endif
    
    @if(sizeof($application->team_sizes) != 0)
    <tr>
        <td>
        @forelse($application->team_sizes as $key_team => $team)
                            
        @php
            $f_exp_row = App\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
        @endphp    
        <table style="width:100%;">
            <tr>
                <td><b class="applicant-proproetor" colspan="2">Directors Personal Financial information : {{ $key_team+1 }}</b></td>
            </tr>
            <tr>
                <table style="width:100%;">
                   <tr>
                <td style="padding:0px;">
                    <table class="assets-table">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align:left;">Assets</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Property (Residential Property) :</b></td>
                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_primary_residence) }}@endif</td>
                            </tr>
                            <tr>
                                <td><b>Property (Other) :</b></td>
                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_other) }}@endif</td>
                            </tr>
                            <tr>
                                <td><b>Bank Account Balance(s) :</b></td>
                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_bank_account) }}@endif</td>
                            </tr>
                            <tr>
                                <td><b>Super(s) :</b></td>
                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_super) }}@endif</td>
                            </tr>
                            <tr>
                                <td><b>Other assets :</b></td>
                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_other) }}@endif</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:0px;">
                    <table class="liabilities-table" style="width:100%;">
                        <thead>
                            <tr>
                                <th colspan="3" style="text-align:left;">Liabilities</th>
                            </tr>
                            <tr>
                                <th class="liabilities-title"></th>
                                <th class="liabilities-limit">Limit</th>
                                <th class="liabilities-limit">Repayment/Month</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="liabilities-title"><b>Home Loan :</b></td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_limit) }}@endif</td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_repayment) }}@endif	</td>
                            </tr>
                            <tr>
                                <td class="liabilities-title"><b>Other Loan :</b></td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_limit) }}@endif</td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_repayment) }}@endif</td>
                            </tr>
                            <tr>
                                <td class="liabilities-title"><b>Credit Card (All Cards) :</b></td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_limit) }}@endif</td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_repayment) }}@endif</td>
                            </tr>
                            <tr>
                                <td class="liabilities-title"><b>Car/Personal Loan (All Loan) :</b></td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_limit) }}@endif</td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_repayment) }}@endif</td>
                            </tr>
                            <tr>
                                <td class="liabilities-title"><b>Any Other Expense :</b></td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_limit) }}@endif</td>
                                <td class="liabilities-limit">@if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_repayment) }}@endif</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
                </table>
            </tr>
            
        </table>
        @if(!$loop->last)
            <!--<hr>-->
            @endif
        @endforeach
        </td>
    </tr>
    @endif
</table>
@php
    $document_types = config('constants.document_types');
    if($application->apply_for == 1){
        unset($document_types['3']);
    }
@endphp

@if(sizeof($application->documents) != 0)
<div class="page-break"></div>
<table>
    <tr>
        <td>
            <h3 class="">Document</h3>
        </td>
    </tr>
</table>
<table class="document-table">
    @foreach($document_types as $key => $value)
        <tr>
            <td style="padding:2px 8px;vertical-align:middle;">
                {{ $value }}
            </td>
             <td style="padding:0px;">
                <table class="link-table">
                    <tr>
                        <td style="padding:2px 8px;">
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
                                    <td style="padding:2px 8px;">
                                        <a class="text-success" href="{{ asset('storage/'.$document->file) }}" target="blank">{{ $value.' - '.($count++) }}</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </table>
            </td>
        </tr>
    @endforeach
</table>
@endif

@if($application->brief_notes)
<table>
    <tr>
        <td>
            <h3 class="">Brief notes</h3>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <p class="briefnotes">{{ $application->brief_notes }}</p>
        </td>
    </tr>
</table>
@endif
</body>
</html>