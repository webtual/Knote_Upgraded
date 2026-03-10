<?php

namespace App\Http\Controllers\Broker;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use App\Models\BusinessStructure;
use App\Models\BusinessType;
use App\Models\Application;
use App\Models\TeamSize;
use App\Models\FinanceInformation;
use App\Models\FinanceInformationByPeople;
use App\Models\Document;
use App\Models\Status;
use App\Models\ReviewNote;
use App\Models\Inquiry;
use App\Models\PropertySecurity;
use App\Models\ApplicationDocuments;
use App\Models\User;
use App\Models\EmailSend;
use App\Models\EmailSendAttachment;
use App\Models\EmailTemplate;
use App\Models\StatusHistory;

use App\Models\ApprovedDocuments;
use App\Models\ApplicationApprovedDocuments;

use App\Traits\AbnAcn;

use App\Jobs\LoanApplicationInquiryEmail;
use App\Jobs\LoanApplicationConsentEmail;
use App\Jobs\LoanApplicationConsentCreatePDF;
use App\Jobs\SentConsentOtp;

use DateTime;
use Auth;
use App\Traits\Loggable;
use PDF;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Hash;

class ApplicationController extends Controller
{
    use AbnAcn;

    use Loggable;

    public function create_loan_application(Request $request)
    {

        $application_types = [];
        /*$application_types[] = array('id' => '2', 'title' => 'KF Property Backed Funding');
        $application_types[] = array('id' => '1', 'title' => 'KF Business Cash Flow Funding');*/

        foreach (config('constants.apply_for') as $id => $title) {
            if ($id == 1) {
                continue; // skip id 1
            }

            $application_types[] = [
                'id' => $id,
                'title' => $title,
            ];
        }

        $data['application_types'] = $application_types;
        $data['business_structures'] = BusinessStructure::select('id', 'structure_type')->get();
        $data['business_types'] = BusinessType::select('id', 'business_type')->where('type', 3)->get();
        return view('broker.loan-application.create', $data);
    }

    public function store_loan_application(Request $request)
    {

        $apply_for = $request->apply_for;

        //STEP-1 START

        if ($apply_for == 1) {

            $rules = [
                'fullname' => 'required',
                'cust_email_address' => 'required|email',
                'phone' => 'required|min:12',
                'apply_for' => 'required',
                'brief_notes' => 'required',
                'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                'year_established' => 'required',
                'business_structure' => 'required',
                'business_name' => 'required',
                'business_address' => 'required',
                'business_email' => 'required|email',
                'trade' => 'required',
                'mobile_no' => 'required|min:12',
                'm_loan_amount' => 'required',
                //'landline' => 'nullable|min:12',

                "title" => "required|array",
                "title.*" => "required",
                "firstname" => "required|array",
                "firstname.*" => "required",
                "lastname" => "required|array",
                "lastname.*" => "required",
                "address" => "required|array",
                "address.*" => "required",
                "residential_status" => "required|array",
                "residential_status.*" => "required",
                "dob" => "required|array",
                "dob.*" => "required",
                "marital_status" => "required|array",
                "marital_status.*" => "required",
                "gender" => "required|array",
                "gender.*" => "required",
                "position" => "required|array",
                "position.*" => "required",
                "mobile" => "required|array",
                "mobile.*" => "required",
                "license_number" => "required|array",
                "license_number.*" => "required",
                "license_expiry_date" => "required|array",
                "license_expiry_date.*" => "required",
                "license_card_number" => "required|array",
                "license_card_number.*" => "required",
                "email_address" => "required|array",
                "email_address.*" => "required",
                "time_in_business" => "required|array",
                "time_in_business.*" => "required",
                "time_at_business" => "required|array",
                "time_at_business.*" => "required",

                'business_trade_year' => 'required',
                'finance_periods' => 'required',
                'gross_income' => 'required',
                'total_expenses' => 'required',
                'net_income' => 'required',
                'know_about_us' => 'required',

                "asset_property_primary_residence" => "required|array",
                "asset_property_primary_residence.*" => "required",
                "asset_property_other" => "required|array",
                "asset_property_other.*" => "required",
                "asset_bank_account" => "required|array",
                "asset_bank_account.*" => "required",
                "asset_super" => "required|array",
                "asset_super.*" => "required",
                "asset_other" => "required|array",
                "asset_other.*" => "required",
                "liability_homeloan_limit" => "required|array",
                "liability_homeloan_limit.*" => "required",
                "liability_homeloan_repayment" => "required|array",
                "liability_homeloan_repayment.*" => "required",
                "liability_otherloan_limit" => "required|array",
                "liability_otherloan_limit.*" => "required",
                "liability_otherloan_repayment" => "required|array",
                "liability_otherloan_repayment.*" => "required",
                "liability_all_card_limit" => "required|array",
                "liability_all_card_limit.*" => "required",
                "liability_all_card_repayment" => "required|array",
                "liability_all_card_repayment.*" => "required",
                "liability_car_personal_limit" => "required|array",
                "liability_car_personal_limit.*" => "required",
                "liability_car_personal_repayment" => "required|array",
                "liability_car_personal_repayment.*" => "required",
                "liability_living_expense_limit" => "required|array",
                "liability_living_expense_limit.*" => "required",
                "liability_living_expense_repayment" => "required|array",
                "liability_living_expense_repayment.*" => "required",
            ];

        } else {

            if ($apply_for == 2) {
                $rules = [
                    'fullname' => 'required',
                    'cust_email_address' => 'required|email',
                    'phone' => 'required|min:12',
                    'apply_for' => 'required',
                    'brief_notes' => 'required',
                    'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                    'year_established' => 'required',
                    'business_structure' => 'required',
                    'business_name' => 'required',
                    'business_address' => 'required',
                    'business_email' => 'required|email',
                    'trade' => 'required',
                    'mobile_no' => 'required|min:12',
                    'm_loan_amount' => 'required',
                    'landline_phone' => 'nullable|min:12',
                    'know_about_us' => 'required',

                    "title" => "required|array",
                    "title.*" => "required",
                    "firstname" => "required|array",
                    "firstname.*" => "required",
                    "lastname" => "required|array",
                    "lastname.*" => "required",
                    "address" => "required|array",
                    "address.*" => "required",
                    "residential_status" => "required|array",
                    "residential_status.*" => "required",
                    "dob" => "required|array",
                    "dob.*" => "required",
                    "marital_status" => "required|array",
                    "marital_status.*" => "required",
                    "gender" => "required|array",
                    "gender.*" => "required",
                    "position" => "required|array",
                    "position.*" => "required",
                    "mobile" => "required|array",
                    "mobile.*" => "required",
                    "license_number" => "required|array",
                    "license_number.*" => "required",
                    "license_expiry_date" => "required|array",
                    "license_expiry_date.*" => "required",
                    "license_card_number" => "required|array",
                    "license_card_number.*" => "required",
                    "email_address" => "required|array",
                    "email_address.*" => "required",
                    "time_in_business" => "required|array",
                    "time_in_business.*" => "required",
                    "time_at_business" => "required|array",
                    "time_at_business.*" => "required",

                    "property_owner" => "required|array",
                    "property_owner.*" => "required",
                    "property_address" => "required|array",
                    "property_address.*" => "required",
                    "property_value" => "required|array",
                    "property_value.*" => "required",

                    "asset_property_primary_residence" => "required|array",
                    "asset_property_primary_residence.*" => "required",
                    "asset_property_other" => "required|array",
                    "asset_property_other.*" => "required",
                    "asset_bank_account" => "required|array",
                    "asset_bank_account.*" => "required",
                    "asset_super" => "required|array",
                    "asset_super.*" => "required",
                    "asset_other" => "required|array",
                    "asset_other.*" => "required",
                    "liability_homeloan_limit" => "required|array",
                    "liability_homeloan_limit.*" => "required",
                    "liability_homeloan_repayment" => "required|array",
                    "liability_homeloan_repayment.*" => "required",
                    "liability_otherloan_limit" => "required|array",
                    "liability_otherloan_limit.*" => "required",
                    "liability_otherloan_repayment" => "required|array",
                    "liability_otherloan_repayment.*" => "required",
                    "liability_all_card_limit" => "required|array",
                    "liability_all_card_limit.*" => "required",
                    "liability_all_card_repayment" => "required|array",
                    "liability_all_card_repayment.*" => "required",
                    "liability_car_personal_limit" => "required|array",
                    "liability_car_personal_limit.*" => "required",
                    "liability_car_personal_repayment" => "required|array",
                    "liability_car_personal_repayment.*" => "required",
                    "liability_living_expense_limit" => "required|array",
                    "liability_living_expense_limit.*" => "required",
                    "liability_living_expense_repayment" => "required|array",
                    "liability_living_expense_repayment.*" => "required",
                ];
            } else {
                $rules = [
                    'fullname' => 'required',
                    'cust_email_address' => 'required|email',
                    'phone' => 'required|min:12',
                    'apply_for' => 'required',
                    'brief_notes' => 'required',
                    'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                    'year_established' => 'required',
                    'business_structure' => 'required',
                    'business_name' => 'required',
                    'business_address' => 'required',
                    'business_email' => 'required|email',
                    'trade' => 'required',
                    'mobile_no' => 'required|min:12',
                    'm_loan_amount' => 'required',
                    'landline_phone' => 'nullable|min:12',
                    'know_about_us' => 'required',

                    "title" => "required|array",
                    "title.*" => "required",
                    "firstname" => "required|array",
                    "firstname.*" => "required",
                    "lastname" => "required|array",
                    "lastname.*" => "required",
                    "address" => "required|array",
                    "address.*" => "required",
                    "residential_status" => "required|array",
                    "residential_status.*" => "required",
                    "dob" => "required|array",
                    "dob.*" => "required",
                    "marital_status" => "required|array",
                    "marital_status.*" => "required",
                    "gender" => "required|array",
                    "gender.*" => "required",
                    "position" => "required|array",
                    "position.*" => "required",
                    "mobile" => "required|array",
                    "mobile.*" => "required",
                    "license_number" => "required|array",
                    "license_number.*" => "required",
                    "license_expiry_date" => "required|array",
                    "license_expiry_date.*" => "required",
                    "license_card_number" => "required|array",
                    "license_card_number.*" => "required",
                    "email_address" => "required|array",
                    "email_address.*" => "required",
                    "time_in_business" => "required|array",
                    "time_in_business.*" => "required",
                    "time_at_business" => "required|array",
                    "time_at_business.*" => "required",

                    "crypto_property_owner" => "required|array",
                    "crypto_property_owner.*" => "required",
                    "crypto_property_address" => "required|array",
                    "crypto_property_address.*" => "required",
                    "crypto_property_value" => "required|array",
                    "crypto_property_value.*" => "required",

                    "asset_property_primary_residence" => "required|array",
                    "asset_property_primary_residence.*" => "required",
                    "asset_property_other" => "required|array",
                    "asset_property_other.*" => "required",
                    "asset_bank_account" => "required|array",
                    "asset_bank_account.*" => "required",
                    "asset_super" => "required|array",
                    "asset_super.*" => "required",
                    "asset_other" => "required|array",
                    "asset_other.*" => "required",
                    "liability_homeloan_limit" => "required|array",
                    "liability_homeloan_limit.*" => "required",
                    "liability_homeloan_repayment" => "required|array",
                    "liability_homeloan_repayment.*" => "required",
                    "liability_otherloan_limit" => "required|array",
                    "liability_otherloan_limit.*" => "required",
                    "liability_otherloan_repayment" => "required|array",
                    "liability_otherloan_repayment.*" => "required",
                    "liability_all_card_limit" => "required|array",
                    "liability_all_card_limit.*" => "required",
                    "liability_all_card_repayment" => "required|array",
                    "liability_all_card_repayment.*" => "required",
                    "liability_car_personal_limit" => "required|array",
                    "liability_car_personal_limit.*" => "required",
                    "liability_car_personal_repayment" => "required|array",
                    "liability_car_personal_repayment.*" => "required",
                    "liability_living_expense_limit" => "required|array",
                    "liability_living_expense_limit.*" => "required",
                    "liability_living_expense_repayment" => "required|array",
                    "liability_living_expense_repayment.*" => "required",
                ];
            }

        }

        $customMessages = [
            'fullname.required' => 'The full name field is required.',
            'cust_email_address.required' => 'The email address field is required.',
            'cust_email_address.email' => 'Please enter a valid email address.',
            'phone.required' => 'The phone number field is required.',
            'phone.min' => 'Please enter a valid phone number.',
            'm_loan_amount.required' => 'Loan borrow amount field is required',
            'mobile_no.min' => 'The mobile format is invalid.',
            'landline_phone.min' => 'The landline format is invalid.',
            'abn_acn.max' => 'The abn/acn number cannot be longer than 11 characters.',
            'abn_acn.regex' => 'The ABN/ACN number cannot contain spaces.',
        ];


        $this->validate($request, $rules, $customMessages);

        $amount_request = get_num_from_string($request->loan_amount_requested);

        if ($apply_for == 1) {
            //Business Loan 100000
            if ($amount_request < 1 || $amount_request > 100000) {
                $error = array(
                    "message" => "The given data was invalid.",
                    "errors" => array(
                        "m_loan_amount" => array('The loan amount must be between $1 and $100,000')
                    )
                );
                return response()->json($error, 422);
            }
        } else {
            //Secured Loan 10000000
            if ($amount_request < 1 || $amount_request > 10000000) {
                $error = array(
                    "message" => "The given data was invalid.",
                    "errors" => array(
                        "m_loan_amount" => array('The loan amount must be between $1 and $10,000,000')
                    )
                );
                return response()->json($error, 422);
            }
        }

        if (!empty($request->dob)) {
            foreach ($request->dob as $key => $value) {
                if ($value != null) {
                    if (!preg_match("/\d{2}\-\d{2}-\d{4}/", $value)) {
                        $error = array(
                            "message" => "The given data was invalid.",
                            "errors" => array(
                                "dob." . $key => array("The dob does not match the format dd-mm-yyyy.")
                            )
                        );
                        return response()->json($error, 422);
                    }


                    // Convert the date string to a DateTime object
                    $date = DateTime::createFromFormat('d-m-Y', $value);
                    $currentDate = new DateTime();
                    $minimumDate = $currentDate->modify('-18 years');

                    // Check if the date of birth is less than 18 years from the current date
                    if ($date > $minimumDate) {
                        $error = [
                            "message" => "The given data was invalid.",
                            "errors" => [
                                "dob." . $key => ["The dob cannot be less than 18 years from the current date."]
                            ]
                        ];
                        return response()->json($error, 422);
                    }

                }
            }
        }

        if (!empty($request->license_expiry_date)) {
            foreach ($request->license_expiry_date as $key => $value) {
                if ($value != null) {
                    if (!preg_match("/\d{2}\-\d{2}-\d{4}/", $value)) {
                        $error = array(
                            "message" => "The given data was invalid.",
                            "errors" => array(
                                "license_expiry_date." . $key => array("The license expiry date does not match the format dd-mm-yyyy.")
                            )
                        );
                        return response()->json($error, 422);
                    }


                    // Convert the date string to a DateTime object
                    $date = DateTime::createFromFormat('d-m-Y', $value);
                    $currentDate = new DateTime();

                    // Check if the date is in the past
                    if ($date < $currentDate) {
                        $error = [
                            "message" => "The given data was invalid.",
                            "errors" => [
                                "license_expiry_date." . $key => ["The license expiry date cannot be in the past."]
                            ]
                        ];
                        return response()->json($error, 422);
                    }

                }
            }
        }

        $phone = str_replace(' ', '', $request->phone);

        // Check if user exists
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            // Create new user
            $users = new User;
            $customer_no = $users->last_customer_no();

            $user = User::create([
                'name' => $request->fullname,
                'email' => $request->cust_email_address,
                'customer_no' => $customer_no,
                'phone' => $phone,
                'password' => Hash::make($phone),
                'email_verified_at' => now(),
            ]);

            $role = 3;
            $user->roles()->attach($role);
        }

        // Now $user will contain the existing or newly created user
        $userId = $user->id;

        $data = new Application;
        $data->apply_for = $apply_for;
        $data->user_id = $userId;
        $data->broker_id = auth()->user()->id;
        $data->business_type_id = $request->trade;
        $data->business_structures_id = $request->business_structure;
        $data->years_of_established = $request->year_established;
        $data->abn_or_acn = $request->abn_acn;
        $data->business_name = $request->business_name;
        $data->business_address = $request->business_address;
        $data->business_email = $request->business_email;
        $data->business_phone = str_replace(' ', '', $request->mobile_no);
        $data->landline_phone = str_replace(' ', '', $request->landline_phone);
        $data->state = $request->state;
        $data->postcode = $request->postcode;
        $data->brief_notes = $request->brief_notes;
        $data->amount_request = get_num_from_string($request->loan_amount_requested);

        $data->save();

        $application_id = $data->id;

        $ApplicationS = new Application;
        $last_application_number = $ApplicationS->last_application_number();

        $update_num = Application::find($application_id);
        //$update_num->application_number = date('Y').date('m').date('d').$application_id;
        $update_num->application_number = $last_application_number;
        $update_num->save();
        //STEP-1 END

        //STEP-2 START

        $teamSizeIds = [];

        for ($i = 0; $i < count($request->title); $i++):

            $street_number = null;
            $street_name = null;
            $street_type = null;
            $locality = null;
            $state = null;
            $postcode = null;

            if ($request->address[$i]) {
                $my_address = $request->address[$i];
                $geo_address_data = getAddressDetails($my_address);
                if ($geo_address_data['success']) {
                    $street_number = $geo_address_data['data']['street_number'];
                    $street_name = $geo_address_data['data']['street_name'];
                    $street_type = $geo_address_data['data']['street_type'];
                    $locality = $geo_address_data['data']['locality'];
                    $state = $geo_address_data['data']['state'];
                    $postcode = $geo_address_data['data']['postcode'];
                }
            }

            $data_set = [
                'title' => $request->title[$i],
                'firstname' => $request->firstname[$i],
                'lastname' => $request->lastname[$i],
                'address' => $request->address[$i],
                'street_number' => $street_number,
                'street_name' => $street_name,
                'street_type' => $street_type,
                'locality' => $locality,
                'state' => $state,
                'postcode' => $postcode,
                'residential_status' => $request->residential_status[$i],
                'dob' => ($request->dob[$i] == "") ? NULL : convert_date_format($request->dob[$i]),
                'marital_status' => $request->marital_status[$i],
                'gender' => $request->gender[$i],
                'position' => $request->position[$i],
                'mobile' => str_replace(' ', '', $request->mobile[$i]),
                'landline' => str_replace(' ', '', $request->landline[$i]),
                'license_number' => $request->license_number[$i],
                'license_expiry_date' => ($request->license_expiry_date[$i] == "") ? NULL : convert_date_format($request->license_expiry_date[$i]),
                'time_in_business' => $request->time_in_business[$i],
                'time_at_business' => $request->time_at_business[$i],
                'card_number' => $request->license_card_number[$i],
                'email_address' => $request->email_address[$i],
                'application_id' => $application_id
            ];

            /*if(!empty($data_set)):
                $lastInsertId = TeamSize::insertGetId($data_set);
            endif;*/

            if (!empty($data_set)):
                $insertedId = TeamSize::insertGetId($data_set);
                $teamSizeIds[] = $insertedId; // Store each ID
            endif;

        endfor;
        //STEP-2 END

        //STEP-3 START
        if ($apply_for == 1) {
            $data1 = new FinanceInformation;
            $data1->application_id = $application_id;
            $data1->business_trade_year = $request->business_trade_year;
            $data1->finance_periods = $request->finance_periods;
            $data1->gross_income = get_num_from_string($request->gross_income);
            $data1->total_expenses = get_num_from_string($request->total_expenses);
            $data1->net_income = get_num_from_string($request->net_income);
            $data1->save();
        } else {

            if ($apply_for == 3) {
                for ($j = 0; $j < count($request->crypto_property_address); $j++):
                    $data_set1 = [
                        'application_id' => $application_id,
                        'purpose' => $request->crypto_hidden_purpose[$j],
                        'property_type' => $request->crypto_hidden_property_type[$j],
                        'property_owner' => $request->crypto_property_owner[$j],
                        'property_address' => $request->crypto_property_address[$j],
                        'property_value' => get_num_from_string($request->crypto_property_value[$j])
                    ];
                    if (!empty($data_set1)):
                        PropertySecurity::insert($data_set1);
                    endif;
                endfor;
            } else {
                for ($j = 0; $j < count($request->property_address); $j++):
                    $data_set1 = [
                        'application_id' => $application_id,
                        'purpose' => $request->hidden_purpose[$j],
                        'property_type' => $request->hidden_property_type[$j],
                        'property_owner' => $request->property_owner[$j],
                        'property_address' => $request->property_address[$j],
                        'property_value' => get_num_from_string($request->property_value[$j])
                    ];
                    if (!empty($data_set1)):
                        PropertySecurity::insert($data_set1);
                    endif;
                endfor;
            }
        }

        for ($k = 0; $k < count($request->asset_property_primary_residence); $k++):
            $data_set2 = [
                'application_id' => $application_id,
                //'team_size_id' => $lastInsertId,
                'team_size_id' => $teamSizeIds[$k],
                'asset_property_primary_residence' => ($request->asset_property_primary_residence[$k] == "") ? "0" : get_num_from_string($request->asset_property_primary_residence[$k]),
                'asset_property_other' => ($request->asset_property_other[$k] == "") ? "0" : get_num_from_string($request->asset_property_other[$k]),
                'asset_bank_account' => ($request->asset_bank_account[$k] == "") ? "0" : get_num_from_string($request->asset_bank_account[$k]),
                'asset_super' => ($request->asset_super[$k] == "") ? "0" : get_num_from_string($request->asset_super[$k]),
                'asset_other' => ($request->asset_other[$k] == "") ? "0" : get_num_from_string($request->asset_other[$k]),
                'liability_homeloan_limit' => ($request->liability_homeloan_limit[$k] == "") ? "0" : get_num_from_string($request->liability_homeloan_limit[$k]),
                'liability_homeloan_repayment' => ($request->liability_homeloan_repayment[$k] == "") ? "0" : get_num_from_string($request->liability_homeloan_repayment[$k]),
                'liability_otherloan_limit' => ($request->liability_otherloan_limit[$k] == "") ? "0" : get_num_from_string($request->liability_otherloan_limit[$k]),
                'liability_otherloan_repayment' => ($request->liability_otherloan_repayment[$k] == "") ? "0" : get_num_from_string($request->liability_otherloan_repayment[$k]),
                'liability_all_card_limit' => ($request->liability_all_card_limit[$k] == "") ? "0" : get_num_from_string($request->liability_all_card_limit[$k]),
                'liability_all_card_repayment' => ($request->liability_all_card_repayment[$k] == "") ? "0" : get_num_from_string($request->liability_all_card_repayment[$k]),
                'liability_car_personal_limit' => ($request->liability_car_personal_limit[$k] == "") ? "0" : get_num_from_string($request->liability_car_personal_limit[$k]),
                'liability_car_personal_repayment' => ($request->liability_car_personal_repayment[$k] == "") ? "0" : get_num_from_string($request->liability_car_personal_repayment[$k]),
                'liability_living_expense_limit' => ($request->liability_living_expense_limit[$k] == "") ? "0" : get_num_from_string($request->liability_living_expense_limit[$k]),
                'liability_living_expense_repayment' => ($request->liability_living_expense_repayment[$k] == "") ? "0" : get_num_from_string($request->liability_living_expense_repayment[$k])
            ];
            if (!empty($data_set2)):
                FinanceInformationByPeople::insert($data_set2);
            endif;
        endfor;
        //STEP-3 END

        //STEP-4 START
        if ($request->has('document_type')):
            for ($l = 0; $l < count($request->document_type); $l++):
                $image = $request->image[$l];

                if (strpos($image, 'data:application/pdf') !== false) {
                    $image = preg_replace('#^data:application/\w+;base64,#i', '', $image);
                    $imageName = 'document/' . str_random(40) . '.pdf';
                } else {
                    $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                    $imageName = 'document/' . str_random(40) . '.png';
                }

                $status = Storage::disk('public')->put($imageName, base64_decode($image));
                $image_path = ($status) ? $imageName : '';

                $data2 = new Document;
                $data2->application_id = $application_id;
                $data2->file = $image_path;
                $data2->type = $request->document_type[$l];
                $data2->save();
            endfor;
        endif;

        $enc_id = Crypt::encrypt($application_id);
        $application = $this->get_single_application($enc_id);

        $data_stage = Application::find($application_id);
        $data_stage->stage = null;
        $data_stage->status_id = 3;
        $data_stage->is_accept_terms = 1;
        $data_stage->save();

        //Status History Added Code Start
        $status_name_val = 'Submitted';
        $statushistory = new StatusHistory;
        $statushistory->user_id = $data_stage->user_id;
        $statushistory->application_id = $data_stage->id;
        $statushistory->status_id = 3;
        $statushistory->body = "Status Update To - " . $status_name_val;
        $statushistory->save();
        //Status History Added Code End

        $status_send_mail = dispatch(new LoanApplicationInquiryEmail($application))->delay(now()->addSeconds(10));

        //consent code start
        /*if(sizeof($application->team_sizes) != 0){
            $team_sizes_data = $application->team_sizes;

            foreach ($team_sizes_data as $val){

                $d_id = $val->id;
                $d_mobile = $val->mobile;

                $d_email_address = $val->email_address;
                $consent_otp = sprintf("%06d", mt_rand(1, 999999));
                $consent_slug = generateUniqueSlug();

                $existingSlug = TeamSize::where('consent_slug', $consent_slug)->exists();
                if ($existingSlug) {
                    $consent_slug = generateUniqueSlug();
                }

                $team_size_data = TeamSize::find($d_id);

                if($team_size_data->consent_slug == null){
                    $team_size_data->consent_slug = $consent_slug;
                    $team_size_data->consent_otp = $consent_otp;
                    $team_size_data->consent_sent_at = now();
                    $team_size_data->save();

                    Log::info('Phone.'.$application->user->phone);
                    Log::info('D-Mobile'.$d_mobile);

                    if($application->user->phone == $d_mobile){
                        //PDF CODE START
                        $team_size_data_1 = TeamSize::find($team_size_data->id);
                        $team_size_data_1->is_accept_terms = 1;
                        $team_size_data_1->consent_status = 1;
                        $team_size_data_1->ip_address = $request->ip();
                        $team_size_data_1->verified_at = now();
                        $team_size_data_1->save();

                        $consent_pdf_created = dispatch(new LoanApplicationConsentCreatePDF($team_size_data, $application))->delay(now()->addSeconds(10));
                        //PDF CODE END
                    }else{
                        $consent_send_mail = dispatch(new LoanApplicationConsentEmail($team_size_data, $application))->delay(now()->addSeconds(10));
                    }
                }

            }
        }*/
        //consent code end
        //STEP-4 END

        $app_response = [];
        return response()->json(['status' => 200, 'message' => 'Your application successfully created.', 'data' => $app_response]);
    }

    public function get_single_application($enc_id)
    {
        if ($enc_id == ""):
            $application = auth()->user()->stage_application();
        else:
            $application = Application::whereid(Crypt::decrypt($enc_id))->first();
        endif;

        if ($application) {
            $application->progress = $this->progess($application);
        }


        return $application;
    }

    public function progess($application)
    {

        if ($application == null) {
            $fill_business_information = $file_people_information = $fill_finance_information = $fill_document_information = $is_submit = false;
        } else {
            $fill_business_information = empty($application) ? false : true;
            $file_people_information = (TeamSize::where("application_id", $application->id)->select('id')->count() > 0) ? true : false;
            if ($application->apply_for == 1) {
                $fill_finance_information = (FinanceInformation::where("application_id", $application->id)->select('id')->count() > 0) ? true : false;
            } else {
                $fill_finance_information = (PropertySecurity::where("application_id", $application->id)->select('id')->count() > 0) ? true : false;
            }
            $fill_document_information = (Document::where("application_id", $application->id)->select('id')->count() > 0) ? true : false;
            $is_submit = ($application->is_accept_terms == 1) ? true : false;

        }


        return array(
            "fill_business_information" => $fill_business_information,
            "file_people_information" => $file_people_information,
            "fill_finance_information" => $fill_finance_information,
            "fill_document_information" => $fill_document_information,
            "is_submit" => $is_submit
        );

    }

    //Declined Loan Application
    public function index_declined()
    {
        $data['application_status'] = Status::whereIn('id', [8])->orderBy('order_number', 'ASC')->get();
        return view('broker.loan-application.declined', $data);
    }

    public function index_declined_ajax(Request $request)
    {

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [8]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('broker/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                return $row->user->customer_no;
            })
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('loan_request_amount', function ($row) {
                return $row->loan_request_amount();
            })
            ->addColumn('current_status', function ($row) {
                //return $row->current_status->status;
                return $row->current_status ? $row->current_status->status : '';
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('business_information', function ($row) {
                return $row->business_name;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $show_url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html .= '<a title="View" href="' . $show_url . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('broker/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information'])
            ->make(true);

    }

    public function declined_application_export(Request $request)
    {
        $t = time();

        $filename = "Broker-Declined-Loan-Applications-Export" . $t;


        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [8]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');


        $columns = array('Application.No', 'Last Application', 'Apply For', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //Archived Loan Application
    public function index_archived()
    {
        $data['application_status'] = Status::whereIn('id', [10])->orderBy('order_number', 'ASC')->get();
        return view('broker.loan-application.archived', $data);
    }

    public function index_archived_ajax(Request $request)
    {

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [10]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('broker/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                return $row->user->customer_no;
            })
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('loan_request_amount', function ($row) {
                return $row->loan_request_amount();
            })
            ->addColumn('current_status', function ($row) {
                //return $row->current_status->status;
                return $row->current_status ? $row->current_status->status : '';
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('business_information', function ($row) {
                return $row->business_name;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $show_url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html .= '<a title="View" href="' . $show_url . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('broker/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information'])
            ->make(true);

    }

    public function archived_application_export(Request $request)
    {
        $t = time();

        $filename = "Broker-Archived-Loan-Applications-Export" . $t;


        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [10]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');


        $columns = array('Application.No', 'Last Application', 'Apply For', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //Settled Loan Application
    public function index_settled()
    {
        $data['application_status'] = Status::whereIn('id', [11])->orderBy('order_number', 'ASC')->get();
        return view('broker.loan-application.settled', $data);
    }

    public function index_settled_ajax(Request $request)
    {

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [11]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('broker/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                return $row->user->customer_no;
            })
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('loan_request_amount', function ($row) {
                return $row->loan_request_amount();
            })
            ->addColumn('current_status', function ($row) {
                //return $row->current_status->status;
                return $row->current_status ? $row->current_status->status : '';
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('business_information', function ($row) {
                return $row->business_name;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $show_url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html .= '<a title="View" href="' . $show_url . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('broker/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information'])
            ->make(true);

    }

    public function settled_application_export(Request $request)
    {
        $t = time();

        $filename = "Broker-Settled-Loan-Applications-Export" . $t;


        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereIn('status_id', [11]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');


        $columns = array('Application.No', 'Last Application', 'Apply For', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //Current Loan Application
    public function index()
    {
        $data['application_status'] = Status::whereNotIn('id', [8, 10, 11])->orderBy('order_number', 'ASC')->get();
        return view('broker.loan-application.index', $data);
    }

    public function indexAjax(Request $request)
    {

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'latest_status_history', 'previous_application.current_status'])
            ->where('broker_id', auth()->user()->id)
            ->whereNotIn('status_id', [8, 10, 11]);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();

        $apply_for = config('constants.apply_for');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('broker/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                return $row->user->customer_no;
            })
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('loan_request_amount', function ($row) {
                return $row->loan_request_amount();
            })
            ->addColumn('current_status_val', function ($row) {
                $latestStatus = $row->latest_status_history;
                $class = ''; // No default class
    
                // Set default class if status_id is 2, 4, 6, 9, or 12
                if ($latestStatus && in_array($row->status_id, [2, 4, 6, 9, 12])) {
                    $class = 'font-weight-bold text-white bg-warning-tr'; // Default class
                }

                if ($latestStatus) {
                    $created_at = $latestStatus->created_at;
                    $hours_diff = now()->diffInHours($created_at);

                    // Define status-based conditions for time thresholds
                    $statusConditions = [
                        2 => 4,
                        4 => 4,
                        6 => 4, // 4 hours
                        9 => 24, // 24 hours
                        12 => 72 // 72 hours
                    ];

                    // Check if status matches and time exceeds the limit
                    if (isset($statusConditions[$latestStatus->status_id]) && $hours_diff >= $statusConditions[$latestStatus->status_id]) {
                        $class = 'font-weight-bold text-white bg-danger-tr';
                    }
                }

                return $class;
            })
            ->addColumn('current_status', function ($row) {
                $class = "";
                $status_val_name = $row->current_status ? $row->current_status->status : '';

                return '<span class="' . $class . '">' . $status_val_name . '</span>';
            })
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('business_information', function ($row) {
                return $row->business_name;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $show_url = url('broker/loan/details/' . Crypt::encrypt($row->id));
                $html .= '<a title="View" href="' . $show_url . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('broker/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information', 'current_status_val'])
            ->make(true);

    }

    public function indexExport(Request $request)
    {
        $t = time();

        $filename = "Broker-Current-Loan-Applications-Export" . $t;


        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=" . $filename . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM

        $data = Application::select('applications.*')
            ->addSelect([
                'previous_application_id' => Application::from('applications as prev_app')
                    ->select('prev_app.id')
                    ->whereColumn('prev_app.user_id', 'applications.user_id')
                    ->whereColumn('prev_app.id', '<', 'applications.id')
                    ->orderBy('prev_app.created_at', 'desc')
                    ->limit(1)
            ])
            ->with(['user', 'current_status', 'previous_application.current_status'])
            ->whereNotIn('status_id', [8, 10, 11])
            ->where('broker_id', auth()->user()->id);

        if ($request->has('search_customer_number') && $request->filled('search_customer_number')) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('customer_no', 'LIKE', '%' . $request->search_customer_number . '%');
            });
        }

        if ($request->has('search_status_id') && $request->filled('search_status_id')) {
            $data->where('status_id', $request->search_status_id);
        }

        if ($request->has('search_apply_for') && $request->filled('search_apply_for')) {
            $data->where('apply_for', $request->search_apply_for);
        }


        if ($request->has('search_business_name') && $request->filled('search_business_name')) {
            $data->where('business_name', 'like', '%' . $request->search_business_name . '%');
        }

        if ($request->has('search_application_number') && $request->filled('search_application_number')) {
            $data->where('application_number', 'like', '%' . $request->search_application_number . '%');
        }


        if ($request->filled('search_daterange')) {
            list($search_start_date, $search_end_date) = explode(' - ', $request['search_daterange']);
            $search_start_date = str_replace('/', '-', $search_start_date);
            $search_end_date = str_replace('/', '-', $search_end_date);
            $from_date = date('Y-m-d', strtotime($search_start_date));
            $to_date = date('Y-m-d', strtotime($search_end_date));
            $to_date = date('Y-m-d', strtotime($to_date . ' + 1 days'));
            $data->whereBetween('created_at', [$from_date, $to_date]);
        }

        $data = $data->orderBy('id', 'DESC')->get();
        $apply_for = config('constants.apply_for');


        $columns = array('Application.No', 'Last Application', 'Apply For', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function application_download($enc_id)
    {
        $application = Application::whereid(Crypt::decrypt($enc_id))->first();

        $file_name = $application->application_number . ".pdf";

        $viewLoad = view('admin.pdf.application-pdf', compact('application'))->render();

        $pdf = PDF::loadHTML($viewLoad)->setWarnings(false);

        Storage::put('public/application/' . $file_name, $pdf->output());
        $application->application_pdf = 'application/' . $file_name;
        $application->save();
        //return $pdf->stream($file_name);
        return $pdf->download($file_name);

        //Storage::put('public/application/'.$file_name, $pdf->output());
        //return $file_name_return = asset('storage/application/'.$file_name);
        //$file_name_path = asset('storage/application/');
        //$file_name_image = $file_name;
        //return $pdf->download($file_name);
    }

    public function show($enc_id)
    {
        $application = Application::with('application_approved_document')->whereid(Crypt::decrypt($enc_id))->first();

        $body = 'View Loan Application Number : ' . $application->application_number;

        //ADMIN LOG START
        $this->store_logs('broker', 'Loan Application View By Broker', $body, $application->id);
        //ADMIN LOG END

        $status = Status::orderBy('order_number', 'ASC')->get();

        $email_template = EmailTemplate::wherestatus(1)->whereis_active_email_indent(1)->get();

        $approved_documents_data = ApprovedDocuments::wherestatus(1)->orderBy('sort_by', 'ASC')->get();

        return view('broker.loan-application.show', compact('application', 'enc_id', 'status', 'email_template', 'approved_documents_data'));
    }

    public function get_error_mail_data(Request $request)
    {
        $html = '';
        $email_id = $request->email_id;
        $data = EmailSend::where('id', "=", $email_id)->first();
        $html .= '<div class="row" style="margin-left: 5px;">
                    <div class="form-group">
                        <p style="text-align: initial;margin-top: 5px;white-space: pre-line;">' . $data->error_message . '</p>
                    </div>
                </div>';

        return response()->json(['status' => '200', 'message' => '', 'html' => $html]);
    }

    public function get_mail_data(Request $request)
    {
        $html = '';
        $email_id = $request->email_id;
        $data = EmailSend::where('id', "=", $email_id)->first();

        if ($data == null) {
            return response()->json(['status' => '200', 'message' => '', 'html' => $html]);
        }

        $attachment_data = EmailSendAttachment::where('email_send_id', $data->id)->get();

        $full_name = $data->to_name;
        $app_url = url('/');
        $str_rep = '[Knote](' . $app_url . ')';
        $body_val = str_replace($str_rep, '', $data->body);
        $html .= '<div class="row" style="margin-left: 5px;">
                    <div class="form-group mb-0">
                        <label for="bs" style="float: left;" class="font-weight-bold">Name: &nbsp;</label>
                        <span>' . $full_name . '</span>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-left: 5px;">
                    <div class="form-group mb-0">
                        <label for="bs" style="float: left;" class="font-weight-bold">Email To: &nbsp;</label>
                        <span>' . $data->to_email . '</span>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-left: 5px;">
                    <div class="form-group mb-0">
                        <label for="bs" style="float: left;" class="font-weight-bold">Subject: &nbsp;</label>
                        <span>' . $data->subject . '</span>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin-left: 5px;">
                    <div class="form-group">
                        <p style="text-align: initial;margin-top: 0px;white-space: pre-line;">' . $body_val . '</p>
                    </div>
                </div>';

        if (sizeof($attachment_data) != 0) {
            $html .= '<hr><div class="row" style="margin-left: 5px;">
                <div class="w-100 mb-0">
                    <label for="bs" class="font-weight-bold">Document Attachment</label><hr>';
            foreach ($attachment_data as $vals) {
                $file_name = asset('storage/mail_document/' . $vals->file_name);
                $html .= '<a href="' . $file_name . '" style="color: #007BFF;" target="blank">' . $vals->file_name . ' <i class="mdi mdi-download mr-1 fs-22"></i></a><br>';
            }
            $html .= '</div>
            </div>';
        }

        return response()->json(['status' => '200', 'message' => '', 'html' => $html]);
    }

    public function ajax_emaillogs(Request $request)
    {

        $data = EmailSend::where('application_id', $request->application_id);

        $data = $data->orderBy('id', 'DESC')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return display_date_format_time($row->created_at);
            })
            ->addColumn('order_by_val', function ($row) {
                return strtotime($row->created_at);
            })
            ->addColumn('from_name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('to_name_details', function ($row) {
                return $row->to_name . '<br>' . str_replace(',', '<br>', $row->to_email);
            })
            ->addColumn('cc_details', function ($row) {
                return "cc : " . $row->cc_email . '<br>reply : ' . $row->reply_to_email;
            })
            ->addColumn('subject', function ($row) {
                return $row->subject;
            })
            ->addColumn('action', function ($row) {
                $html = '';
                $html .= '<a href="javascript:void(0)" onclick="get_mail_data(' . $row->id . ')" title="Show" class="action-icon"><i class="fa fa-envelope text-success"></i></a>';

                if ($row->is_sent == 0) {
                    $html .= '<a href="javascript:void(0)" onclick="get_error_data(' . $row->id . ')" title="Error" class="action-icon"><i class="fa fa-info-circle text-danger"></i></a>';
                }

                return $html;
            })
            ->rawColumns(['order_by_val', 'action', 'from_name', 'to_name_details', 'cc_details', 'subject'])
            ->make(true);
    }
}
