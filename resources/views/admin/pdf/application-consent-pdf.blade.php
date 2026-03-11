<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <style>
        .page-break {
            page-break-after: always;
        }

        body,
        .page-break-avoid {
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

        .my-0 {
            margin-top: 0;
            margin-bottom: 0;
        }

        table {
            /*margin-bottom: 12px;*/
        }

        table tr td {
            vertical-align: top;
        }

        h1 {
            font-size: 12px;
        }

        h3 {
            font-size: 14px;
            color: #343a40;
            margin: 0;
        }

        .hr-line {
            border-width: .5px;
            color: #f6f6f6;
        }

        .card-table {
            padding: 0px 10px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .card-table tr td b {
            font-size: 12px !important;
        }

        .card-table tr td,
        .card-table tr th {
            padding: 2px 8px;
            font-size: 12px;
        }

        .applicant-proproetor {
            color: #1abc9c !important;
            font-size: 14px;
        }

        .card-table-2 {
            padding: 0px 10px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .card-table-2 table tr td b {
            font-size: 12px !important;
        }

        .card-table-2 table tr td {
            padding: 2px 8px;
            font-size: 12px;
        }

        .liabilities-title {
            width: 40%;
        }

        .liabilities-limit {
            width: 30%;
            text-align: right;
        }

        .document-table,
        .document-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .document-table tr td {
            border: 1px solid #ccc;
        }

        .document-table tr table {
            margin-bottom: 0px;
        }

        .link-table tr td {
            border: 0px !important;
            border-bottom: 1px solid #ccc !important;
        }

        .link-table tr::last-child td {
            border: 0px !important;
            border-bottom: 0px !important;
        }

        .link {
            text-decoration: none;
            color: #1abc9c !important;
        }

        .briefnotes {
            font-size: 10px;
            color: #343a40;
            margin-top: 0px;
        }
    </style>
</head>

<body>
    @php
        $apply_for = config('constants.apply_for');
        use App\Models\User;
        $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
        $know_about_us_val = $application->know_about_us == 8 ? $application->know_about_us_others : ($KNOW_ABOUT_US_VAL[$application->know_about_us] ?? '');
    @endphp
    <table style="width:100%;">
        <tbody>
            <tr>
                <td>
                    <h1 class="my-0" style="padding-bottom:6px;">Apply For :
                        {{ ($apply_for[$application->apply_for])  }}
                    </h1>
                    <span style="font-size:16px;"><b>Status : </b>{{ $application->current_status->status }}</span>
                </td>
                <td style="text-align:center;vertical-align: top;">
                    <span style="text-align:left;display:block;"><b
                            style="display:block;padding-bottom:5px;">Application
                            Number</b>{{ $application->application_number }}</span>
                </td>
            </tr>
            <tr>
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
            <td>{{ $know_about_us_val }}</td>
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
                        <td style="padding: 2px 8px;"><b class="applicant-proproetor" colspan="2">Applicant/Director/Proprietor
                                : {{ $key_team + 1 }}</b></td>
                    </tr>
                </thead>
                <tbody style="width:100%;">
                    <tr>
                        <td style="width:50%;">
                            <table>
                                <tr>
                                    <td><b>Name :</b></td>
                                    <td>{{ config('constants.people_title')[$team->title] . ' ' . $team->firstname . ' ' . $team->lastname }}
                                    </td>
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
                                    <td>{{ ($team->time_at_business == "") ? '' : $team->time_at_business . ' Years' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Time in Business :</b></td>
                                    <td>{{ ($team->time_in_business == "") ? '' : $team->time_in_business . ' Years' }}</td>
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
                    <h3 class="">Business Financial Information @if(!empty($application->finance_information))
                        {{ '(' . config('constants.finance_periods')[$application->finance_information->finance_periods] . ' - ' . $application->finance_information->business_trade_year . ')' }}
                    @endif
                    </h3>
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
                            <span><b>Gross Income : </b>@if(!empty($application->finance_information))
                                {{ money_format_amount($application->finance_information->gross_income) }}
                            @endif</span>
                        </tr>
                        <tr>
                            <span><b>Total Expense : </b>@if(!empty($application->finance_information))
                                {{ money_format_amount($application->finance_information->total_expenses) }}
                            @endif</span>
                        </tr>
                        <tr>
                            <span><b>Net Income : </b>@if(!empty($application->finance_information))
                                {{ money_format_amount($application->finance_information->net_income) }}
                            @endif</span>
                        </tr>
                    </table>
                </td>
            </tr>
        @else
            @if($application->property_securities->count() > 0)
                @php
                    $type_of_property = config('constants.type_of_property');
                    $property_loan_types = config('constants.property_loan_types');
                @endphp
                @foreach($application->property_securities as $key_property => $property)
                    <tr>
                        <td>
                            @if($application->apply_for == 2)
                                <table class="card-table">
                                    <tr>
                                        <span><b>Type of Property / Security : </b>{{ ($property_loan_types[$property->purpose])  }} -
                                            {{ ($type_of_property[$property->property_type]) }}</span>
                                    </tr>
                                    <tr>
                                        <span><b>Property Address : </b>{{ ($property->property_address) }}</span>
                                    </tr>
                                    <tr>
                                        <span><b>Property Value : </b>{{ money_format_amount($property->property_value) }}</span>
                                    </tr>
                                    <tr>
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
                                        <span><b>Property Owner : </b>{{ $displayOwner }}</span>
                                    </tr>
                                </table>
                            @endif
                            @if($application->apply_for == 3)
                                <table class="card-table">
                                    <tr>
                                        <span><b>Type of Crypto / Security :
                                            </b>{{ ($property_loan_types[$property->property_type]) }}</span>
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
                    $f_exp_row = App\Models\FinanceInformationByPeople::where('application_id', $application->id)->where('team_size_id', $team->id)->first();
                @endphp
                <table style="width:100%;">
                    <tr>
                        <td><b class="applicant-proproetor" colspan="2">Directors Personal Financial information :
                                {{ $key_team + 1 }}</b></td>
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
                                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_primary_residence) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Property (Other) :</b></td>
                                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_property_other) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Bank Account Balance(s) :</b></td>
                                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_bank_account) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Super(s) :</b></td>
                                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_super) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Other assets :</b></td>
                                                <td>@if($f_exp_row != null){{ money_format_amount($f_exp_row->asset_other) }}@endif
                                                </td>
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
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_limit) }}@endif
                                                </td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_homeloan_repayment) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="liabilities-title"><b>Other Loan :</b></td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_limit) }}@endif
                                                </td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_otherloan_repayment) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="liabilities-title"><b>Credit Card (All Cards) :</b></td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_limit) }}@endif
                                                </td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_all_card_repayment) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="liabilities-title"><b>Car/Personal Loan (All Loan) :</b></td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_limit) }}@endif
                                                </td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_car_personal_repayment) }}@endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="liabilities-title"><b>Any Other Expense :</b></td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_limit) }}@endif
                                                </td>
                                                <td class="liabilities-limit">
                                                    @if($f_exp_row != null){{ money_format_amount($f_exp_row->liability_living_expense_repayment) }}@endif
                                                </td>
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
        if ($application->apply_for == 1) {
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
                                        <a class="text-success"
                                            href="{{ asset('storage/' . $application->get_documents_by_type($key)->first()['file']) }}"
                                            target="blank">{{ $value . ' - 1' }}</a>
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
                                                <a class="text-success" href="{{ asset('storage/' . $document->file) }}"
                                                    target="blank">{{ $value . ' - ' . ($count++) }}</a>
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
                    <h3 class="">Exit Strategy and Brief Notes</h3>
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
    <div class="page-break"></div>
    <h3>Authority To Obtain Credit Information</h3>
    <div class=" border p-2">
        <p>I/We declare that the credit to be provided to me/us by Knote Group Aus Pty Ltd for this Credit Application
            is to be applied wholly or predominantly for business purposes; or investment purposes other than investment
            in residential propertie s , i/we understand consent to all matters in the application. We have no reason to
            believe any change in Capacity or position in future.<br>
        </p>
        <p>I/We understand that by signing this application, consent is given to Knote Group Aus Pty Ltd and it’s
            related entities to: </p>
        <p>1) Disclose to a credit reporting agency certain personal information about me/us including: identity
            particulars; amount of credit applied for in this application; payments which may become more than 60 days
            overdue; any serious credit infringement which Knote Group Aus Pty Ltd and it’s related entities believes
            I/we have committed, advice that payments are no longer overdue and/or that credit provided to me/us has
            been discharged.</p>
        <p>2) Obtain from a credit reporting agency a report containing personal credit information about me/us and, a
            report containing information about my/our commercial activities or commercial credit worthiness, to enable
            Knote Group Aus Pty Ltd and it’s related entities to assess this application for credit. I/We further
            consent to and acknowledge that Knote Group Aus Pty Ltd and it’s related entities may at it’s discretion
            obtain second and/or subsequent credit reports prior to funding (settlement) or withdrawal of this
            application, in order to reassess my/our application for credit.</p>
        <p>3) Give and obtain from any credit provider(s) that may be named in this application or in a report held by a
            credit reporting agency information about my/our credit arrangements, including information about my/our
            credit worthiness, credit standing, credit history, credit capacity for the purpose of assessing an
            application for credit, notifying any default by me/us.</p>
        <p>4) Give to any guarantor, proposed Guarantor or person providing security for a loan given by Knote Group Aus
            Pty Ltd and it’s related entities to me/us, any credit information about me/us.</p>
        <div>
            This includes but is not limited to the information about and copies of the following items:<br>
        </div>
        <div class="pl-3">
            <p>1) this and any credit contract or security contract I/we have or had with the Banks/Credit Provider/
                Knote Group Aus Pty Ltd and it’s related entities<br> 2) application information including any financial
                statements or statements of financial position given to us within the last 2 years,<br> 3) any credit
                report or related credit report obtained from a credit reporting agency,<br> 4) a copy of any related
                credit insurance contract,<br> 5) any default notices, statements of account, or dishonour notice on
                this or any related facility I/we have or had with the Banks/Credit Provider/Credit Hub Australia,<br>
                6) any other information we have that they may reasonably request.</p>
        </div>
        <div>We further acknowledge this authority extends to include any information in the Our possession relating to
            the preceding 2 years and continues for the life of the facility now requested.</div>
        <div class="pl-3">
            <p>1) Confirm my employment details from my employer, accountant or tax agent named in this
                application.<br>2) Confirm my income received on an investment property from any nominated real estate
                agent.</p>
        </div>
    </div>
    @if($team_size_data->ip_address)
        <table style="width:100%">
            <tr>
                <td>
                    <h3 class="">IP Address</h3>
                    <p class="briefnotes">{{ $team_size_data->ip_address }}</p>
                </td>
                <td>
                    <h3 class="" style="text-align:right;">Consent By</h3>
                    <p class="briefnotes" style="text-align:right;">{{$team_size_data->firstname}}
                        {{$team_size_data->lastname}}
                    </p>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    <h3 class="">Date & Time</h3>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <p class="briefnotes">{{ date('d-m-Y h:i A') }}</p>
                </td>
            </tr>
        </table>
    @endif
</body>

</html>