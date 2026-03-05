<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use App\BusinessStructure;
use App\BusinessType;
use App\Application;
use App\TeamSize;
use App\FinanceInformation;
use App\FinanceInformationByPeople;
use App\Document;
use App\Status;
use App\ReviewNote;
use App\Inquiry;
use App\PropertySecurity;
use App\ApplicationDocuments;
use App\User;
use App\EmailSend;
use App\EmailSendAttachment;
use App\EmailTemplate;
use App\StatusHistory;
use App\CreditScoreEventLogs;

use App\ApprovedDocuments;
use App\ApplicationApprovedDocuments;

use App\Traits\AbnAcn;
use App\Traits\EquifaxScore;
use App\Traits\EquifaxHistoryScore;
use App\Traits\EquifaxScoreseeker;

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

class ApplicationController extends Controller
{
    use AbnAcn;

    use Loggable;

    use EquifaxScore;

    use EquifaxHistoryScore;

    use EquifaxScoreseeker;

    public function credit_score_event_log_data(Request $request)
    {
        $html = '';
        $credit_score_event_log_id = $request->credit_score_event_log_id;

        $data = CreditScoreEventLogs::where('id', "=", $credit_score_event_log_id)->first();

        $pdfPathLink = asset('storage' . $data->score_pdf);

        $html .= '<iframe src="' . $pdfPathLink . '" width="100%" height="600px"></iframe>';

        return response()->json(['status' => '200', 'message' => '', 'html' => $html]);
    }

    public function check_user_score_seeker(Request $request)
    {

        try {
            $result = \DB::transaction(function () use ($request) {

                $app_response = [];
                $application_id = $request->application_id;
                $team_size_id = $request->team_size_id;

                $response = $this->company_user_score_seeker_enquiry($application_id, $team_size_id);

                return $response;

                //return response()->json(['status' => 200, 'message' => "Company trading history score checked successfully.", 'data' => $app_response]);

            });
            return $result;
        } catch (\Exception $e) {
            return response()->json(['status' => 422, 'message' => $e->getMessage(), 'data' => '']);
        }

    }

    public function check_company_trading_history_score(Request $request)
    {

        try {
            $result = \DB::transaction(function () use ($request) {

                $app_response = [];
                $application_id = $request->application_id;

                $response = $this->company_trading_history_enquiry($application_id);

                return $response;

                //return response()->json(['status' => 200, 'message' => "Company trading history score checked successfully.", 'data' => $app_response]);

            });
            return $result;
        } catch (\Exception $e) {
            return response()->json(['status' => 422, 'message' => $e->getMessage(), 'data' => '']);
        }

    }

    public function check_company_enquiry_score(Request $request)
    {
        $app_response = [];
        try {
            $result = \DB::transaction(function () use ($request, $app_response) {

                $application_id = $request->application_id;
                $response = $this->company_enquiry($application_id);

                return $response;
                //return response()->json(['status' => 200, 'message' => "Company enquiry score checked successfully.", 'data' => $app_response]);

            });
            return $result;
        } catch (\Exception $e) {
            return response()->json(['status' => 423, 'message' => $e->getMessage(), 'data' => '']);
        }

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

    public function conditionally_approved(Request $request)
    {

        $rules = [
            'facility_limit' => 'required',
            'facility_term' => 'required',
            'applied_interest_rate_per_month' => 'required',
            'applied_annual_interest' => 'required',
            'payment_type' => 'required',
            'repayment_amount' => 'required',
            'repayment_description' => 'required',
            'application_fee' => 'required',
            'documentation_fee' => 'required',
            'valuation_fee' => 'required',
            'discharge_fee' => 'required',
            'disbursement_fees' => 'required',
            'other_fee' => 'required',
            'settlement_conditions_descriptions' => 'required',
            'ppsr_value' => 'required',
            'lvr_current' => 'required',
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);
        $application_id = $request->conditionally_approved_application_id;

        $update = Application::find($application_id);
        $update->facility_limit = (float) $request->facility_limit;
        $update->facility_term = $request->facility_term;
        $update->applied_interest_rate_per_month = $request->applied_interest_rate_per_month;
        $update->applied_annual_interest = $request->applied_annual_interest;
        $update->payment_type = $request->payment_type;
        $update->repayment_amount = $request->repayment_amount;
        $update->total_repayment_amount = $request->total_repayment_amount;
        $update->repayment_description = $request->repayment_description;
        $update->application_fee = $request->application_fee;
        $update->documentation_fee = $request->documentation_fee;
        $update->valuation_fee = $request->valuation_fee;
        $update->monthly_acc_fee = $request->monthly_acc_fee;
        $update->interest_capitalized = $request->interest_capitalized;

        if ($request->discharge_fee == 'noval') {
            $update->discharge_fee = $request->discharge_fee;
            $update->discharge_fee_val = $request->discharge_fee_val;
        } else {
            $update->discharge_fee = $request->discharge_fee;
            $update->discharge_fee_val = null;
        }

        $update->disbursement_fees = $request->disbursement_fees;
        $update->other_fee = $request->other_fee;
        $update->settlement_conditions_descriptions = $request->settlement_conditions_descriptions;
        $update->security_descriptions = $request->security_descriptions;
        $update->mortgage_type_descriptions = $request->mortgage_type_descriptions;
        $update->land_address_descriptions = $request->land_address_descriptions;
        $update->grantor_descriptions = $request->grantor_descriptions;
        $update->ppsr_value = $request->ppsr_value;
        $update->lvr_current = $request->lvr_current;

        if ($request->is_edit_val != 1) {
            $update->status_id = 5;
            $update->reminder_sent_at = null;

            //Status History Added Code Start
            $status_name_val = 'Conditionally Approved';
            $statushistory = new StatusHistory;
            $statushistory->user_id = $update->user_id;
            $statushistory->application_id = $update->id;
            $statushistory->status_id = 5;
            $statushistory->body = "Status Update To - " . $status_name_val;
            $statushistory->save();
            //Status History Added Code End
        }
        $update->save();

        //ADMIN LOG START
        $data = Application::find($application_id);
        $body = 'An conditionally approved status information has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Conditionally Approved Status Information Updated to Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'An conditionally approved status information has been successfully updated.', 'data' => $app_response]);
    }

    public function directors_financial(Request $request)
    {

        $app_response = FinanceInformationByPeople::find($request->id);

        return response()->json(['status' => 200, 'message' => 'Suceess', 'data' => $app_response]);
    }

    public function update_directors_financial(Request $request)
    {

        $rules = [
            'asset_property_primary_residence' => 'required',
            'asset_property_other' => 'required',
            'asset_bank_account' => 'required',
            'asset_super' => 'required',
            'asset_other' => 'required',
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;
        $directors_financial_id = $request->directors_financial_id;

        $data_set = [
            'application_id' => $application_id,
            'team_size_id' => $request->team_size_id,
            'asset_property_primary_residence' => ($request->asset_property_primary_residence == "") ? "0" : get_num_from_string($request->asset_property_primary_residence),
            'asset_property_other' => ($request->asset_property_other == "") ? "0" : get_num_from_string($request->asset_property_other),
            'asset_bank_account' => ($request->asset_bank_account == "") ? "0" : get_num_from_string($request->asset_bank_account),
            'asset_super' => ($request->asset_super == "") ? "0" : get_num_from_string($request->asset_super),
            'asset_other' => ($request->asset_other == "") ? "0" : get_num_from_string($request->asset_other),
            'liability_homeloan_limit' => ($request->liability_homeloan_limit == "") ? "0" : get_num_from_string($request->liability_homeloan_limit),
            'liability_homeloan_repayment' => ($request->liability_homeloan_repayment == "") ? "0" : get_num_from_string($request->liability_homeloan_repayment),
            'liability_otherloan_limit' => ($request->liability_otherloan_limit == "") ? "0" : get_num_from_string($request->liability_otherloan_limit),
            'liability_otherloan_repayment' => ($request->liability_otherloan_repayment == "") ? "0" : get_num_from_string($request->liability_otherloan_repayment),
            'liability_all_card_limit' => ($request->liability_all_card_limit == "") ? "0" : get_num_from_string($request->liability_all_card_limit),
            'liability_all_card_repayment' => ($request->liability_all_card_repayment == "") ? "0" : get_num_from_string($request->liability_all_card_repayment),
            'liability_car_personal_limit' => ($request->liability_car_personal_limit == "") ? "0" : get_num_from_string($request->liability_car_personal_limit),
            'liability_car_personal_repayment' => ($request->liability_car_personal_repayment == "") ? "0" : get_num_from_string($request->liability_car_personal_repayment),
            'liability_living_expense_limit' => ($request->liability_living_expense_limit == "") ? "0" : get_num_from_string($request->liability_living_expense_limit),
            'liability_living_expense_repayment' => ($request->liability_living_expense_repayment == "") ? "0" : get_num_from_string($request->liability_living_expense_repayment)
        ];

        if (!empty($data_set)):
            $affectedRows = FinanceInformationByPeople::where('id', $directors_financial_id)->update($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'An Applicant/Director/Proprietor finance information has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Applicant/Director/Proprietor Finance Information  Updated to Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your directors personal financial information has been successfully updated.', 'data' => $app_response]);
    }

    public function business_financial(Request $request)
    {

        $app_response = FinanceInformation::find($request->id);

        return response()->json(['status' => 200, 'message' => 'Suceess', 'data' => $app_response]);
    }

    public function update_business_financial(Request $request)
    {

        $rules = [
            'business_trade_year' => 'required',
            'finance_periods' => 'required',
            'gross_income' => 'required',
            'total_expenses' => 'required',
            'net_income' => 'required',
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;
        $business_financial_id = $request->business_financial_id;

        $data_set = [
            'application_id' => $application_id,
            'business_trade_year' => $request->business_trade_year,
            'finance_periods' => $request->finance_periods,
            'gross_income' => get_num_from_string($request->gross_income),
            'total_expenses' => get_num_from_string($request->total_expenses),
            'net_income' => get_num_from_string($request->net_income)
        ];

        if (!empty($data_set)):
            $affectedRows = FinanceInformation::where('id', $business_financial_id)->update($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Business finance information has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information  Updated to Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your business financial information has been successfully updated.', 'data' => $app_response]);
    }

    public function add_business_financial(Request $request)
    {

        $rules = [
            'business_trade_year' => 'required',
            'finance_periods' => 'required',
            'gross_income' => 'required',
            'total_expenses' => 'required',
            'net_income' => 'required',
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;

        $data_set = [
            'application_id' => $application_id,
            'business_trade_year' => $request->business_trade_year,
            'finance_periods' => $request->finance_periods,
            'gross_income' => get_num_from_string($request->gross_income),
            'total_expenses' => get_num_from_string($request->total_expenses),
            'net_income' => get_num_from_string($request->net_income)
        ];

        if (!empty($data_set)):
            FinanceInformation::insert($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Business finance information has been added for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information Added To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your business financial information has been successfully saved.', 'data' => $app_response]);
    }

    public function property_security(Request $request)
    {

        $app_response = PropertySecurity::find($request->id);

        return response()->json(['status' => 200, 'message' => 'Suceess', 'data' => $app_response]);
    }

    public function update_property_security(Request $request)
    {

        $rules = [
            "property_address" => "required",
            "property_value" => "required",
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;
        $security_id = $request->security_id;

        $data_set = [
            'application_id' => $application_id,
            'purpose' => $request->hidden_purpose,
            'property_type' => $request->hidden_property_type,
            'property_address' => $request->property_address,
            'property_value' => get_num_from_string($request->property_value)
        ];

        if (!empty($data_set)):
            $affectedRows = PropertySecurity::where('id', $security_id)->update($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Property/Security information has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information Updated To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your property security details have been successfully updated.', 'data' => $app_response]);
    }

    public function add_property_security(Request $request)
    {

        $rules = [
            "property_address" => "required",
            "property_value" => "required",
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;

        $data_set = [
            'application_id' => $application_id,
            'purpose' => $request->hidden_purpose,
            'property_type' => $request->hidden_property_type,
            'property_address' => $request->property_address,
            'property_value' => get_num_from_string($request->property_value)
        ];

        if (!empty($data_set)):
            PropertySecurity::insert($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Property/Security information has been added for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information Added To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your property security details have been successfully saved.', 'data' => $app_response]);
    }

    public function crypto_security(Request $request)
    {

        $app_response = PropertySecurity::find($request->id);

        return response()->json(['status' => 200, 'message' => 'Suceess', 'data' => $app_response]);
    }

    public function update_crypto_security(Request $request)
    {

        $rules = [
            "property_value" => "required",
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;
        $security_id = $request->security_id;

        $data_set = [
            'application_id' => $application_id,
            'purpose' => $request->hidden_purpose,
            'property_type' => $request->hidden_property_type,
            'property_address' => $request->property_address,
            'property_value' => get_num_from_string($request->property_value)
        ];

        if (!empty($data_set)):
            $affectedRows = PropertySecurity::where('id', $security_id)->update($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Crypto/Security information has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information Updated To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your crypto security details have been successfully updated.', 'data' => $app_response]);
    }

    public function add_crypto_security(Request $request)
    {

        $rules = [
            "property_value" => "required",
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $application_id = $request->application_id;

        $data_set = [
            'application_id' => $application_id,
            'purpose' => $request->hidden_purpose,
            'property_type' => $request->hidden_property_type,
            'property_address' => $request->property_address,
            'property_value' => get_num_from_string($request->property_value)
        ];

        if (!empty($data_set)):
            PropertySecurity::insert($data_set);
        endif;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'Crypto/Security information has been added for Loan Application Number : ' . $data->application_number;
        $title = 'Business Finance Information Added To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your crypto security details have been successfully saved.', 'data' => $app_response]);
    }

    public function loan_team(Request $request)
    {

        $app_response = TeamSize::find($request->id);

        return response()->json(['status' => 200, 'message' => 'Suceess', 'data' => $app_response]);
    }

    public function update_director(Request $request)
    {

        $rules = [
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
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $apply_for = $request->apply_for;

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

        $application_id = $request->application_id;

        for ($i = 0; $i < count($request->title); $i++):

            $team_size_id = $request->team_size_id[$i];

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

            if (!empty($data_set)):
                $affectedRows = TeamSize::where('id', $team_size_id)->update($data_set);
            endif;
        endfor;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'An Applicant/Director/Proprietor has been updated for Loan Application Number : ' . $data->application_number;
        $title = 'Applicant/Director/Proprietor Updated to Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your people details have been successfully saved.', 'data' => $app_response]);
    }

    public function add_director(Request $request)
    {

        $rules = [
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
        ];

        $customMessages = [

        ];

        $this->validate($request, $rules, $customMessages);

        $apply_for = $request->apply_for;

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

        $application_id = $request->application_id;

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
            if (!empty($data_set)):
                $lastInsertId = TeamSize::insertGetId($data_set);

                $data_set2 = [
                    'application_id' => $application_id,
                    'team_size_id' => $lastInsertId,
                    'asset_property_primary_residence' => "0",
                    'asset_property_other' => "0",
                    'asset_bank_account' => "0",
                    'asset_super' => "0",
                    'asset_other' => "0",
                    'liability_homeloan_limit' => "0",
                    'liability_homeloan_repayment' => "0",
                    'liability_otherloan_limit' => "0",
                    'liability_otherloan_repayment' => "0",
                    'liability_all_card_limit' => "0",
                    'liability_all_card_repayment' => "0",
                    'liability_car_personal_limit' => "0",
                    'liability_car_personal_repayment' => "0",
                    'liability_living_expense_limit' => "0",
                    'liability_living_expense_repayment' => "0",
                ];

                if (!empty($data_set2)):
                    FinanceInformationByPeople::insert($data_set2);
                endif;

            endif;
        endfor;

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $application_id)->first();
        $body = 'An Applicant/Director/Proprietor has been added for Loan Application Number : ' . $data->application_number;
        $title = 'Applicant/Director/Proprietor Added to Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your people details have been successfully saved.', 'data' => $app_response]);
    }

    public function loan_finance_document(Request $request)
    {

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your application has been successfully updated.', 'data' => $app_response]);
    }

    public function loan_finance_edit(Request $request, $enc_id)
    {

        $application = $this->get_single_application($enc_id);
        $application_id = Crypt::decrypt($enc_id);

        return view('admin.loan-application.finance', compact('application', 'enc_id', 'application_id'));
    }

    public function loan_update_document(Request $request)
    {
        if ($request->has('document_type')):
            for ($i = 0; $i < count($request->document_type); $i++):
                $image = $request->image[$i];

                if (strpos($image, 'document/') === 0) {

                } else {

                    if (strpos($image, 'data:application/pdf') !== false) {
                        $image = preg_replace('#^data:application/\w+;base64,#i', '', $image);
                        $imageName = 'document/' . str_random(40) . '.pdf';
                    } else {
                        $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                        $imageName = 'document/' . str_random(40) . '.png';
                    }

                    $status = Storage::disk('public')->put($imageName, base64_decode($image));
                    $image_path = ($status) ? $imageName : '';

                    $data = new Document;
                    $data->application_id = $request->application_id;
                    $data->file = $image_path;
                    $data->type = $request->document_type[$i];
                    $data->save();
                }

            endfor;
        endif;

        $count_document_exit = Document::where('application_id', $request->application_id)->select('id')->get()->count();

        if ($count_document_exit == 0) {
            //return response()->json(['status' => 422, 'message' => 'Please upload any one document file.']);
            return response()->json(['message' => 'Please upload any one document file.'], 422);
        }



        //ADMIN LOG START
        $data = Application::select('*')->where('id', $request->application_id)->first();

        //$is_stage = $this->progess($data);
        $data->stage = null;
        $data->is_accept_terms = 1;
        $data->save();

        $body = 'Document has been Updated for Loan Application Number : ' . $data->application_number;
        $title = 'Document Updated To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your document has been successfully updated.', 'data' => $app_response]);
    }

    public function loan_document_edit(Request $request, $enc_id)
    {

        $application = $this->get_single_application($enc_id);
        $application_id = Crypt::decrypt($enc_id);

        return view('admin.loan-application.document', compact('application', 'enc_id', 'application_id'));
    }

    public function document_destory(Request $request)
    {
        $application_id = $request->application_id;
        $id = $request->document_id;
        $data = Document::find($id);
        $data->delete();

        //ADMIN LOG START
        $data = Application::select('*')->where('id', $request->application_id)->first();
        $body = 'Document has been deleted for Loan Application Number: ' . $data->application_number;
        $title = 'Document Deleted To Loan Application';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        return response()->json(['status' => 201, 'message' => 'The document has been successfully deleted.']);
    }

    public function loan_update_business(Request $request)
    {

        $rules = [
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
            'landline' => 'nullable|min:12',
        ];

        $customMessages = [
            'm_loan_amount.required' => 'Loan borrow amount field is required',
            'mobile_no.min' => 'The mobile format is invalid.',
            'landline_phone.min' => 'The landline format is invalid.',
            'abn_acn.max' => 'The abn/acn number cannot be longer than 11 characters.',
            'abn_acn.regex' => 'The ABN/ACN number cannot contain spaces.',
        ];

        $this->validate($request, $rules, $customMessages);

        $amount_request = get_num_from_string($request->loan_amount_requested);

        $apply_for = $request->apply_for;

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


        $data = Application::find($request->application_id);
        $data->business_type_id = $request->trade;
        $data->business_structures_id = $request->business_structure;
        $data->years_of_established = $request->year_established;
        $data->abn_or_acn = $request->abn_acn;
        $data->know_about_us = $request->know_about_us;
        $data->know_about_us_others = $request->know_about_us_others ?? null;
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

        //ADMIN LOG START
        $body = 'The Business Information of Loan Application Number : ' . $data->application_number . ' has been updated';
        $title = 'Loan Application Business Information Update';
        $this->store_logs('admin', $title, $body, $data->id);
        //ADMIN LOG END

        $app_response = [];

        return response()->json(['status' => 200, 'message' => 'Your application has been successfully updated.', 'data' => $app_response]);
    }

    public function loan_edit(Request $request, $enc_id)
    {

        $business_structures = BusinessStructure::get();
        $business_types = BusinessType::wheretype(3)->get();
        $application = $this->get_single_application($enc_id);
        $check_status_array = [1, 3];
        $application_id = Crypt::decrypt($enc_id);

        return view('admin.loan-application.edit', compact('business_structures', 'business_types', 'application', 'enc_id', 'application_id'));
    }

    public function admin_create_loan_application(Request $request, $enc_user_id)
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

        $userid = Crypt::decrypt($enc_user_id);

        $data['application_types'] = $application_types;
        $data['business_structures'] = BusinessStructure::select('id', 'structure_type')->get();
        $data['business_types'] = BusinessType::select('id', 'business_type')->where('type', 3)->get();
        $data['user_id'] = $userid;
        $data['user_data'] = User::find($userid);
        return view('admin.loan-application.create', $data);
    }

    public function admin_store_loan_application(Request $request)
    {

        $apply_for = $request->apply_for;

        //STEP-1 START

        if ($apply_for == 1) {

            $rules = [
                'apply_for' => 'required',
                'brief_notes' => 'required',
                'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                'year_established' => 'required',
                'business_structure' => 'required',
                'business_name' => 'required',
                'business_address' => 'required',
                'business_email' => 'required|email',
                'trade' => 'required',
                'know_about_us' => 'required',
                'mobile_no' => 'required|min:12',
                'm_loan_amount' => 'required',
                //'landline' => 'nullable|min:12',
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

                'business_trade_year' => 'required',
                'finance_periods' => 'required',
                'gross_income' => 'required',
                'total_expenses' => 'required',
                'net_income' => 'required',


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
                    'apply_for' => 'required',
                    'brief_notes' => 'required',
                    'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                    'year_established' => 'required',
                    'business_structure' => 'required',
                    'business_name' => 'required',
                    'business_address' => 'required',
                    'business_email' => 'required|email',
                    'trade' => 'required',
                    'know_about_us' => 'required',
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
                    'apply_for' => 'required',
                    'brief_notes' => 'required',
                    'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
                    'year_established' => 'required',
                    'business_structure' => 'required',
                    'business_name' => 'required',
                    'business_address' => 'required',
                    'business_email' => 'required|email',
                    'trade' => 'required',
                    'know_about_us' => 'required',
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


        $data = new Application;
        $data->apply_for = $apply_for;
        $data->user_id = $request->user_id;
        $data->business_type_id = $request->trade;
        $data->business_structures_id = $request->business_structure;
        $data->years_of_established = $request->year_established;
        $data->abn_or_acn = $request->abn_acn;
        $data->know_about_us = $request->know_about_us;
        $data->know_about_us_others = $request->know_about_us_others ?? null;
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
            if (!empty($data_set)):
                $lastInsertId = TeamSize::insertGetId($data_set);
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
                        'property_address' => $request->property_address[$j],
                        'property_value' => get_num_from_string($request->property_value[$j])
                    ];
                    if (!empty($data_set1)):
                        PropertySecurity::insert($data_set1);
                    endif;
                endfor;
            }
        }

        for ($k = 0; $k < 1; $k++):
            $data_set2 = [
                'application_id' => $application_id,
                'team_size_id' => $lastInsertId,
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
        if (sizeof($application->team_sizes) != 0) {
            $team_sizes_data = $application->team_sizes;

            foreach ($team_sizes_data as $val) {

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

                if ($team_size_data->consent_slug == null) {
                    $team_size_data->consent_slug = $consent_slug;
                    $team_size_data->consent_otp = $consent_otp;
                    $team_size_data->consent_sent_at = now();
                    $team_size_data->save();

                    Log::info('Phone.' . $application->user->phone);
                    Log::info('D-Mobile' . $d_mobile);

                    if ($application->user->phone == $d_mobile) {
                        //PDF CODE START
                        $team_size_data_1 = TeamSize::find($team_size_data->id);
                        $team_size_data_1->is_accept_terms = 1;
                        $team_size_data_1->consent_status = 1;
                        $team_size_data_1->ip_address = $request->ip();
                        $team_size_data_1->verified_at = now();
                        $team_size_data_1->save();

                        $consent_pdf_created = dispatch(new LoanApplicationConsentCreatePDF($team_size_data, $application))->delay(now()->addSeconds(10));
                        //PDF CODE END
                    } else {
                        $consent_send_mail = dispatch(new LoanApplicationConsentEmail($team_size_data, $application))->delay(now()->addSeconds(10));
                    }
                }

            }
        }
        //consent code end
        //STEP-4 END

        $app_response = [];
        return response()->json(['status' => 200, 'message' => 'Your application successfully created.', 'data' => $app_response]);
    }

    //Current Loan Application
    public function index()
    {
        $data['application_status'] = Status::whereNotIn('id', [8, 10, 11])->orderBy('order_number', 'ASC')->get();
        return view('admin.loan-application.index', $data);
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
            ->with([
                'user',
                'current_status',
                'latest_status_history',
                'previous_application.current_status'
            ])
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
                    // Ensure status relationship exists
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('admin/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('admin/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->user->customer_no . '</b></a>';
                return $html;
            })
            ->addColumn('broker_info', function ($row) {
                return $row->broker->name ?? '-';
            })
            ->addColumn('apply_for', function ($row) use ($apply_for) {
                return $apply_for[$row->apply_for];
            })
            ->addColumn('loan_request_amount', function ($row) {
                return $row->loan_request_amount();
            })
            /*->addColumn('current_status', function ($row) {
                $latestStatus = $row->latest_status_history;
                $class = '';

                if ($latestStatus) {
                    $created_at = $latestStatus->created_at;
                    $hours_diff = now()->diffInHours($created_at);

                    if (in_array($latestStatus->status_id, [2, 4, 6]) && $hours_diff >= 4) {
                        $class = 'font-weight-bold text-white bg-danger p-2';
                    } elseif ($latestStatus->status_id == 9 && $hours_diff >= 24) {
                        $class = 'font-weight-bold text-white bg-danger p-2';
                    } elseif ($latestStatus->status_id == 12 && $hours_diff >= 72) {
                        $class = 'font-weight-bold text-white bg-danger p-2';
                    }
                }

                $status_val_name = $row->current_status ? $row->current_status->status : '';

                return '<span class="' . $class . '">' . $status_val_name .'</span>';
            })*/
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
                /*$latestStatus = $row->latest_status_history;
                $class = ''; // No default class

                // Set default class if status_id is 2, 4, 6, 9, or 12
                if ($latestStatus && in_array($latestStatus->status_id, [2, 4, 6, 9, 12])) {
                    $class = 'font-weight-bold text-white bg-info p-2'; // Default class
                }

                if ($latestStatus) {
                    $created_at = $latestStatus->created_at;
                    $hours_diff = now()->diffInHours($created_at);

                    // Define status-based conditions for time thresholds
                    $statusConditions = [
                        2 => 4, 4 => 4, 6 => 4, // 4 hours
                        9 => 24, // 24 hours
                        12 => 72 // 72 hours
                    ];

                    // Check if status matches and time exceeds the limit
                    if (isset($statusConditions[$latestStatus->status_id]) && $hours_diff >= $statusConditions[$latestStatus->status_id]) {
                        $class = 'font-weight-bold text-white bg-danger p-2';
                    }
                }*/

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
                $html = '';
                $html .= '<a href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="text-success" ><strong>' . $row->business_name . '</strong></a>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a title="View" href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('admin/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information', 'current_status_val', 'broker_info'])
            ->make(true);

    }

    public function indexExport(Request $request)
    {
        $t = time();

        $filename = "Current-Loan-Applications-Export" . $t;


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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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

        $columns = array('Application.No', 'Last Application', 'Apply For', 'Know About Us', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);
                $abn_or_acn = $row->abn_or_acn;
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    // Ensure status relationship exists
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $know_about_us_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //Declined Loan Application
    public function index_declined()
    {
        $data['application_status'] = Status::whereIn('id', [8])->orderBy('order_number', 'ASC')->get();
        return view('admin.loan-application.declined', $data);
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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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
                    // Ensure status relationship exists
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('admin/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('admin/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->user->customer_no . '</b></a>';
                return $html;
            })
            ->addColumn('broker_info', function ($row) {
                return $row->broker->name ?? '-';
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
                $html = '';
                $html .= '<a href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="text-success" ><strong>' . $row->business_name . '</strong></a>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a title="View" href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('admin/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information'])
            ->make(true);

    }

    public function declined_application_export(Request $request)
    {
        $t = time();

        $filename = "Declined-Loan-Applications-Export" . $t;


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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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


        $columns = array('Application.No', 'Last Application', 'Apply For', 'Know About Us', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date', 'broker_info');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                $apply_for_val = $apply_for[$row->apply_for];
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                $business_phone = $row->business_phone;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    // Ensure status relationship exists
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $know_about_us_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
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
        return view('admin.loan-application.archived', $data);
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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    // Ensure status relationship exists
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('admin/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('admin/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->user->customer_no . '</b></a>';
                return $html;
            })
            ->addColumn('broker_info', function ($row) {
                return $row->broker->name ?? '-';
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
                $html = '';
                $html .= '<a href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="text-success" ><strong>' . $row->business_name . '</strong></a>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a title="View" href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('admin/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information', 'broker_info'])
            ->make(true);

    }

    public function archived_application_export(Request $request)
    {
        $t = time();

        $filename = "Archived-Loan-Applications-Export" . $t;


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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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

        $columns = array('Application.No', 'Last Application', 'Apply For', 'Know About Us', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                $business_phone = $row->business_phone;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    // Ensure status relationship exists
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $know_about_us_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //settled
    public function index_settled()
    {
        $data['application_status'] = Status::whereIn('id', [11])->orderBy('order_number', 'ASC')->get();
        return view('admin.loan-application.settled', $data);
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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    // Ensure status relationship exists
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('admin/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('admin/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->user->customer_no . '</b></a>';
                return $html;
            })
            ->addColumn('broker_info', function ($row) {
                return $row->broker->name ?? '-';
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
                $html = '';
                $html .= '<a href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="text-success" ><strong>' . $row->business_name . '</strong></a>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a title="View" href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('admin/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information', 'broker_info'])
            ->make(true);

    }

    public function settled_application_export(Request $request)
    {
        $t = time();

        $filename = "Settled-Loan-Applications-Export" . $t;


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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
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

        $columns = array('Application.No', 'Last Application', 'Apply For', 'Know About Us', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                $business_phone = $row->business_phone;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    // Ensure status relationship exists
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $know_about_us_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    //Customer Loan Application
    public function user_index($user_id)
    {
        $user_id = Crypt::decrypt($user_id);
        $user_data = User::where('id', $user_id)->first();
        $data['application_status'] = Status::orderBy('order_number', 'ASC')->get();
        $data['user_id'] = $user_id;
        $data['user_data'] = $user_data;

        $phone = str_replace(' ', '', $user_data->phone);
        $team_size_data = TeamSize::where('mobile', $phone)->first();
        $business_score = $team_size_data ? $team_size_data->seeker_score : null;

        $data['business_score'] = $business_score;

        return view('admin.loan-application.loan-application-customer', $data);
    }

    public function index_users_ajax(Request $request)
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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
            ->where('user_id', $request->user_id);

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
            ->addIndexColumn()
            ->addColumn('last_application', function ($row) {
                $last_app = $row->previous_application;

                if ($last_app) {
                    // Ensure status relationship exists
                    $status = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date = display_date_format_time($last_app->created_at);

                    $url = url('admin/loan/details/' . Crypt::encrypt($last_app->id));
                    return '<a class="text-success" href="' . $url . '"><b>' . $last_app->application_number . '</b></a><br><b>' . $status . '</b><br>' . $date;
                }
                return '-';
            })
            ->addColumn('application_no', function ($row) {
                $url = url('admin/loan/details/' . Crypt::encrypt($row->id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->application_number . '</b></a>';
                return $html;
            })
            ->addColumn('customer_no', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a class="text-success" href="' . $url . '"><b>' . $row->user->customer_no . '</b></a>';
                return $html;
            })
            ->addColumn('broker_info', function ($row) {
                return $row->broker->name ?? '-';
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
            ->addColumn('score_info', function ($row) {
                $html = '';
                if ($row->business_score) {
                    $color = $row->business_score < 600 ? '#dc3545' : '#28a745';
                    $html .= '<div class="col-md-6 text-md-right">
                    <h3 class="header-title font-18 score-title-com" style="color: ' . $color . ';">
                        ' . $row->business_score . '
                    </h3>
                </div>';
                }
                return $html;
            })
            ->addColumn('business_information', function ($row) {
                $html = '';
                $html .= '<a href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="text-success" ><strong>' . $row->business_name . '</strong></a>';
                return $html;
            })
            ->addColumn('action', function ($row) {
                $url = url('admin/users/loan-applications/' . Crypt::encrypt($row->user_id));
                $html = '';
                $html .= '<a title="View" href="' . url('admin/loan/details/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"> <i class="fe-file-text"></i></a>';
                $html .= '<a title="Download" href="' . url('admin/loan/details/download/' . Crypt::encrypt($row->id)) . '" class="action-icon text-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
                return $html;
            })
            ->rawColumns(['order_by_val', 'last_application', 'application_no', 'customer_no', 'apply_for', 'loan_request_amount', 'current_status', 'action', 'business_information', 'broker_info', 'score_info'])
            ->make(true);

    }

    public function user_index_export(Request $request)
    {
        $t = time();

        $filename = "Customer-Loan-Applications-Export" . $t;


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
            ->with([
                'user',
                'current_status',
                'previous_application.current_status'
            ])
            ->where('user_id', $request->user_id);

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

        $columns = array('Application.No', 'Last Application', 'Apply For', 'Know About Us', 'Business Information', 'ABN or ACN', 'Business Structure', 'Year Established', 'Business Address', 'Mailing Address', 'Mobile', 'Request Amount', 'Status', 'Created Date');

        $callback = function () use ($data, $columns, $bom) {
            $file = fopen('php://output', 'w');
            echo $bom;

            fputcsv($file, $columns);

            foreach ($data as $row) {
                $application_number = $row->application_number;
                $business_name = $row->business_name;
                $loan_request_amount = $row->loan_request_amount();
                $status = $row->current_status->status;
                $apply_for = config('constants.apply_for');
                $KNOW_ABOUT_US_VAL = User::KNOW_ABOUT_US_VAL;
                $know_about_us_val = $row->know_about_us == 8 ? $row->know_about_us_others : ($KNOW_ABOUT_US_VAL[$row->know_about_us] ?? '');
                $apply_for_val = $apply_for[$row->apply_for];
                $created_at = display_date_format($row->created_at);

                $abn_or_acn = $row->abn_or_acn;
                $structure_type = $row->business_structure->structure_type;
                $years_of_established = $row->years_of_established;
                $business_address = $row->business_address;
                $business_email = $row->business_email;
                $business_phone = $row->business_phone;

                $business_phone = $row->business_phone;

                $last_app_val = '';
                $last_app = $row->previous_application;
                if ($last_app) {
                    // Ensure status relationship exists
                    $status_last = $last_app->status_id == 8 ? 'Declined' : ($last_app->current_status->status ?? '-');
                    $date_last = display_date_format_time($last_app->created_at);
                    $last_app_val = "Application No: " . $last_app->application_number . "\nStatus: " . $status_last . "\nDate: " . $date_last;
                }

                fputcsv($file, array($application_number, $last_app_val, $apply_for_val, $know_about_us_val, $business_name, $abn_or_acn, $structure_type, $years_of_established, $business_address, $business_email, $business_phone, $loan_request_amount, $status, $created_at));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

        die();
    }

    public function save_exit(Request $request)
    {
        Auth::logout();
        session()->invalidate();
        $app_response = [];
        return response()->json(['status' => 201, 'message' => 'Your application successfully updated.', 'data' => $app_response]);
    }

    public function create($enc_id = "")
    {
        $business_structures = BusinessStructure::get();
        $business_types = BusinessType::wheretype(3)->get();
        $application = $this->get_single_application($enc_id);
        //dd($enc_id);
        $check_status_array = [1, 3];

        if (($application != null) && ($application->status_id >= 3)) {
            //if ($application !== null && in_array($application->status_id, $check_status_array)) {
            return redirect('loan/edit/review/' . Crypt::encrypt($application->id));
        } else {
            //$application = null;
        }

        return view('applicant.loan.create', compact(
            'business_structures',
            'business_types',
            'application',
            'enc_id'
        ));
    }

    public function storeBusinessInformation(Request $request)
    {

        $rules = [
            'abn_acn' => 'required|max:11|regex:/^[^\s]*$/',
            'year_established' => 'required',
            'business_structure' => 'required',
            'business_name' => 'required',
            'business_address' => 'required',
            'business_email' => 'required|email',
            'trade' => 'required',
            'mobile' => 'required|min:12',
            'loan_amount_requested' => 'required',
            'm_loan_amount' => 'required',
            'landline' => 'nullable|min:12',
        ];
        $customMessages = [
            'm_loan_amount.required' => 'Loan borrow amount field is required',
            'mobile.min' => 'The mobile format is invalid.',
            'landline.min' => 'The landline format is invalid.',
            'abn_acn.max' => 'The abn/acn number cannot be longer than 11 characters.',
            'abn_acn.regex' => 'The ABN/ACN number cannot contain spaces.',
        ];
        $this->validate($request, $rules, $customMessages);

        //Detect apply for using session object
        $initial_session_obj = session('otp_verification_obj');
        $request_information = json_decode($initial_session_obj->request_information);
        $apply_for = $request_information->apply_for;

        $know_about_us = $request_information->know_about_us;
        $know_about_us_others = $request_information->know_about_us_others;

        $amount_request = get_num_from_string($request->loan_amount_requested);
        //$amount_request = get_num_from_string($request->m_loan_amount);

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


        $data = ($request->application_id == "") ? new Application : Application::find($request->application_id);
        $data->apply_for = $apply_for;
        $data->know_about_us = $know_about_us;
        $data->know_about_us_others = $know_about_us_others;
        $data->user_id = auth()->user()->id;
        $data->business_type_id = $request->trade;
        $data->business_structures_id = $request->business_structure;
        $data->years_of_established = $request->year_established;
        $data->abn_or_acn = $request->abn_acn;
        $data->business_name = $request->business_name;
        $data->business_address = $request->business_address;
        $data->business_email = $request->business_email;
        $data->business_phone = str_replace(' ', '', $request->mobile);
        $data->landline_phone = str_replace(' ', '', $request->landline);
        // $data->fax = $request->fax;
        $data->state = $request->state;
        $data->postcode = $request->postcode;
        $data->amount_request = get_num_from_string($request->loan_amount_requested);
        //$data->amount_request = get_num_from_string($request->m_loan_amount);
        $data->status_id = 1;
        $data->stage = 1;
        $data->save();

        //Status History Added Code Start
        $status_name_val = 'Incomplete';
        $statushistory = new StatusHistory;
        $statushistory->user_id = $data->user_id;
        $statushistory->application_id = $data->id;
        $statushistory->status_id = 1;
        $statushistory->body = "Status Update To - " . $status_name_val;
        $statushistory->save();
        //Status History Added Code End

        $ApplicationS = new Application;
        $last_application_number = $ApplicationS->last_application_number();

        $update_num = Application::find($data->id);
        //$update_num->application_number = date('Y').date('m').date('d').$data->id;
        $update_num->application_number = $last_application_number;
        $update_num->save();

        if ($request->application_id == ""):
            $app_response = array('application_id' => $data->id);
            return response()->json(['status' => 201, 'message' => 'Your business information successfully added.', 'data' => $app_response]);
        else:
            $app_response = array('application_id' => $request->application_id);
            return response()->json(['status' => 201, 'message' => 'Your business information successfully updated.', 'data' => $app_response]);
        endif;
    }

    public function people($enc_id = "")
    {
        $application = $this->get_single_application($enc_id);

        if (empty($application)):
            return redirect('loan/create');
        endif;
        return view('applicant.loan.people', compact('application', 'enc_id'));
    }

    public function storePeople(Request $request)
    {

        $this->validate($request, [
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
        ]);


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



        $data_stage = Application::find($request->application_id);
        $data_stage->team_sizes()->delete();


        $finance_information_by_people = FinanceInformationByPeople::where('application_id', $request->application_id)->get();


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
                'application_id' => $request->application_id
            ];
            if (!empty($data_set)):
                $lastInsertId = TeamSize::insertGetId($data_set);
                if ($finance_information_by_people->count() > 0) {

                    if (isset($finance_information_by_people[$i]['team_size_id'])) {
                        $i_exit = FinanceInformationByPeople::where('application_id', $request->application_id)
                            ->where('team_size_id', $finance_information_by_people[$i]['team_size_id'])->first();
                        if ($i_exit) {
                            FinanceInformationByPeople::where('application_id', $request->application_id)
                                ->where('team_size_id', $finance_information_by_people[$i]['team_size_id'])
                                ->update([
                                    'team_size_id' => $lastInsertId
                                ]);
                        }

                    } else {
                        $data_set2 = [
                            'application_id' => $request->application_id,
                            'team_size_id' => $lastInsertId,
                            'asset_property_primary_residence' => "0",
                            'asset_property_other' => "0",
                            'asset_bank_account' => "0",
                            'asset_super' => "0",
                            'asset_other' => "0",
                            'liability_homeloan_limit' => "0",
                            'liability_homeloan_repayment' => "0",
                            'liability_otherloan_limit' => "0",
                            'liability_otherloan_repayment' => "0",
                            'liability_all_card_limit' => "0",
                            'liability_all_card_repayment' => "0",
                            'liability_car_personal_limit' => "0",
                            'liability_car_personal_repayment' => "0",
                            'liability_living_expense_limit' => "0",
                            'liability_living_expense_repayment' => "0",
                        ];

                        if (!empty($data_set2)):
                            FinanceInformationByPeople::insert($data_set2);
                        endif;
                    }


                } else {
                    $data_set2 = [
                        'application_id' => $request->application_id,
                        'team_size_id' => $lastInsertId,
                        'asset_property_primary_residence' => "0",
                        'asset_property_other' => "0",
                        'asset_bank_account' => "0",
                        'asset_super' => "0",
                        'asset_other' => "0",
                        'liability_homeloan_limit' => "0",
                        'liability_homeloan_repayment' => "0",
                        'liability_otherloan_limit' => "0",
                        'liability_otherloan_repayment' => "0",
                        'liability_all_card_limit' => "0",
                        'liability_all_card_repayment' => "0",
                        'liability_car_personal_limit' => "0",
                        'liability_car_personal_repayment' => "0",
                        'liability_living_expense_limit' => "0",
                        'liability_living_expense_repayment' => "0",
                    ];

                    if (!empty($data_set2)):
                        FinanceInformationByPeople::insert($data_set2);
                    endif;
                }

            endif;
        endfor;


        $data_stage = Application::find($request->application_id);
        $data_stage->stage = 2;
        $data_stage->save();

        if ($request->has('team_size_id')):
            $message = 'Your people information successfully updated.';
        else:
            $message = 'Your people information successfully added.';
        endif;

        $app_response = array('application_id' => $request->application_id);
        return response()->json(['status' => 201, 'message' => $message, 'data' => $app_response]);

    }

    public function finance($enc_id = "")
    {
        $application = $this->get_single_application($enc_id);

        if (empty($application)):
            return redirect('loan/create');
        endif;

        return view('applicant.loan.finance', compact('application', 'enc_id'));
    }

    public function storeFinance(Request $request)
    {

        $data_stage = Application::find($request->application_id);
        $apply_for = $data_stage->apply_for;

        if ($apply_for == 1) {
            $request->validate([
                'business_trade_year' => 'required',
                'finance_periods' => 'required',
                'gross_income' => 'required',
                'total_expenses' => 'required',
                'net_income' => 'required',
                /*
                'asset_property_primary_residence' => 'sometimes|numeric',
                'asset_property_other' => 'numeric',
                'asset_bank_account' => 'numeric',
                'asset_super' => 'numeric',
                'asset_other' => 'numeric',
                'liability_homeloan' => 'numeric',
                'liability_otherloan' => 'numeric',
                'liability_all_card' => 'numeric',
                'liability_car_personal' => 'numeric',
                'liability_living_expense' => 'numeric', */
            ]);
        } else {
            if ($apply_for == 2) {
                $request->validate([
                    "property_address" => "required|array",
                    "property_address.*" => "required",
                    "property_value" => "required|array",
                    "property_value.*" => "required",
                ]);
            } else {
                $request->validate([
                    "property_value" => "required|array",
                    "property_value.*" => "required",
                ]);
            }
            /*
            $request->validate([
                'type_of_property' => 'required',
                'property_loan_type' => 'required',
                'property_address' => 'required',
                'property_value' => 'required',
            ]);
            */
        }

        $data = ($request->finance_id == "") ? new FinanceInformation : FinanceInformation::find($request->finance_id);
        $data->application_id = $request->application_id;

        if ($apply_for == 1) {
            $data->business_trade_year = $request->business_trade_year;
            $data->finance_periods = $request->finance_periods;
            $data->gross_income = get_num_from_string($request->gross_income);
            $data->total_expenses = get_num_from_string($request->total_expenses);
            $data->net_income = get_num_from_string($request->net_income);
            $data->save();
        } else {
            /*
            $data->type_of_property = $request->type_of_property;
            $data->property_loan_type = $request->property_loan_type;
            $data->property_address = $request->property_address;
            $data->property_value = get_num_from_string($request->property_value);
            */

            $is_exit_count = PropertySecurity::select('id')->where('application_id', $request->application_id)->get()->count();
            if ($is_exit_count > 0) {
                PropertySecurity::select('id')->where('application_id', $request->application_id)->delete();
            }

            for ($i = 0; $i < count($request->property_address); $i++):

                //$purpose = ($request->input('purpose_'.$i)) ? $request->input('purpose_'.$i)[0] : 1;
                //$property_type = ($request->input('property_type_'.$i)) ? $request->input('property_type_'.$i)[0] : 1;
                $data_set = [
                    'application_id' => $request->application_id,
                    'purpose' => $request->hidden_purpose[$i],
                    'property_type' => $request->hidden_property_type[$i],
                    'property_address' => $request->property_address[$i],
                    'property_value' => get_num_from_string($request->property_value[$i])
                ];
                if (!empty($data_set)):
                    PropertySecurity::insert($data_set);
                endif;
            endfor;
        }

        $is_exit_count = FinanceInformationByPeople::select('id')->where('application_id', $request->application_id)->get()->count();
        if ($is_exit_count > 0) {
            FinanceInformationByPeople::select('id')->where('application_id', $request->application_id)->delete();
        }

        for ($i = 0; $i < count($request->team_size_id); $i++):
            $data_set = [
                'application_id' => $request->application_id,
                'team_size_id' => $request->team_size_id[$i],
                'asset_property_primary_residence' => ($request->asset_property_primary_residence[$i] == "") ? "0" : get_num_from_string($request->asset_property_primary_residence[$i]),
                'asset_property_other' => ($request->asset_property_other[$i] == "") ? "0" : get_num_from_string($request->asset_property_other[$i]),
                'asset_bank_account' => ($request->asset_bank_account[$i] == "") ? "0" : get_num_from_string($request->asset_bank_account[$i]),
                'asset_super' => ($request->asset_super[$i] == "") ? "0" : get_num_from_string($request->asset_super[$i]),
                'asset_other' => ($request->asset_other[$i] == "") ? "0" : get_num_from_string($request->asset_other[$i]),
                'liability_homeloan_limit' => ($request->liability_homeloan_limit[$i] == "") ? "0" : get_num_from_string($request->liability_homeloan_limit[$i]),
                'liability_homeloan_repayment' => ($request->liability_homeloan_repayment[$i] == "") ? "0" : get_num_from_string($request->liability_homeloan_repayment[$i]),
                'liability_otherloan_limit' => ($request->liability_otherloan_limit[$i] == "") ? "0" : get_num_from_string($request->liability_otherloan_limit[$i]),
                'liability_otherloan_repayment' => ($request->liability_otherloan_repayment[$i] == "") ? "0" : get_num_from_string($request->liability_otherloan_repayment[$i]),
                'liability_all_card_limit' => ($request->liability_all_card_limit[$i] == "") ? "0" : get_num_from_string($request->liability_all_card_limit[$i]),
                'liability_all_card_repayment' => ($request->liability_all_card_repayment[$i] == "") ? "0" : get_num_from_string($request->liability_all_card_repayment[$i]),
                'liability_car_personal_limit' => ($request->liability_car_personal_limit[$i] == "") ? "0" : get_num_from_string($request->liability_car_personal_limit[$i]),
                'liability_car_personal_repayment' => ($request->liability_car_personal_repayment[$i] == "") ? "0" : get_num_from_string($request->liability_car_personal_repayment[$i]),
                'liability_living_expense_limit' => ($request->liability_living_expense_limit[$i] == "") ? "0" : get_num_from_string($request->liability_living_expense_limit[$i]),
                'liability_living_expense_repayment' => ($request->liability_living_expense_repayment[$i] == "") ? "0" : get_num_from_string($request->liability_living_expense_repayment[$i])
            ];
            if (!empty($data_set)):
                FinanceInformationByPeople::insert($data_set);
            endif;
        endfor;



        //$data_stage = Application::find($request->application_id);
        $data_stage->stage = 3;
        $data_stage->save();

        if ($request->finance_id == ""):
            $message = "Your finance information has been successfully added.";
        else:
            $message = "Your finance information has been successfully updated.";
        endif;
        return response()->json(['status' => 201, 'message' => $message]);
        //$request->request->add(['application_id' => $request]);
    }

    public function document($enc_id = "")
    {
        $application = $this->get_single_application($enc_id);
        if (empty($application)):
            return redirect('loan/create');
        endif;
        return view('applicant.loan.document', compact('application', 'enc_id'));
    }

    public function documentStore(Request $request)
    {

        if ($request->brief_notes == '') {
            return response()->json(['status' => 422, 'message' => 'Please add brief notes.']);
        }

        if ($request->has('document_type')):
            for ($i = 0; $i < count($request->document_type); $i++):
                $image = $request->image[$i];

                if (strpos($image, 'data:application/pdf') !== false) {
                    $image = preg_replace('#^data:application/\w+;base64,#i', '', $image);
                    $imageName = 'document/' . str_random(40) . '.pdf';
                } else {
                    $image = preg_replace('#^data:image/\w+;base64,#i', '', $image);
                    $imageName = 'document/' . str_random(40) . '.png';
                }

                $status = Storage::disk('public')->put($imageName, base64_decode($image));
                $image_path = ($status) ? $imageName : '';

                $data = new Document;
                $data->application_id = $request->application_id;
                $data->file = $image_path;
                $data->type = $request->document_type[$i];
                $data->save();
            endfor;

            $data_stage = Application::find($request->application_id);
            $data_stage->stage = 4;
            $data_stage->save();
        endif;

        $data_stages = Application::find($request->application_id);
        $data_stages->brief_notes = $request->brief_notes;
        $data_stages->save();

        $count_document_exit = Document::where('application_id', $request->application_id)->select('id')->get()->count();
        if ($count_document_exit == 0) {
            return response()->json(['status' => 422, 'message' => 'Please upload any one document file.']);
        }

        return response()->json(['status' => 201, 'message' => 'Document has been successfully added.']);
    }

    public function review($enc_id = "")
    {
        $application = $this->get_single_application($enc_id);
        if (empty($application)):
            return redirect('loan/create');
        endif;
        return view('applicant.loan.review', compact('application', 'enc_id'));
    }

    public function reviewStore(Request $request)
    {
        $enc_id = Crypt::encrypt($request->application_id);
        $application = $this->get_single_application($enc_id);
        if (empty($application)):
            return response()->json(['status' => 201, 'message' => 'Something wrong.']);
        endif;
        $request->validate(
            [
                'privacy_policy' => 'required',
                'authority_to_obtain_credit_information' => 'required'
            ],
            [
                'privacy_policy.required' => 'Please agree privacy policy terms.',
                'authority_to_obtain_credit_information.required' => 'Please agree authority to obtain credit information.',
            ]
        );


        $data_stage = Application::find($request->application_id);
        $data_stage->stage = null;
        $data_stage->status_id = 3;

        //Status History Added Code Start
        $status_name_val = 'Submitted';
        $statushistory = new StatusHistory;
        $statushistory->user_id = $data_stage->user_id;
        $statushistory->application_id = $data_stage->id;
        $statushistory->status_id = 3;
        $statushistory->body = "Status Update To - " . $status_name_val;
        $statushistory->save();
        //Status History Added Code End

        if ($data_stage->is_accept_terms != 1) {
            $status_send_mail = dispatch(new LoanApplicationInquiryEmail($application))->delay(now()->addSeconds(10));
        }
        $data_stage->is_accept_terms = 1;
        $data_stage->save();

        //consent code start
        if (sizeof($application->team_sizes) != 0) {
            $team_sizes_data = $application->team_sizes;

            foreach ($team_sizes_data as $val) {
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

                if ($team_size_data->consent_slug == null) {
                    $team_size_data->consent_slug = $consent_slug;
                    $team_size_data->consent_otp = $consent_otp;
                    $team_size_data->consent_sent_at = now();
                    $team_size_data->save();

                    if ($application->user->phone == $d_mobile) {
                        //PDF CODE START

                        $team_size_data_1 = TeamSize::find($team_size_data->id);
                        $team_size_data_1->is_accept_terms = 1;
                        $team_size_data_1->consent_status = 1;
                        $team_size_data_1->ip_address = $request->ip();
                        $team_size_data_1->verified_at = now();
                        $team_size_data_1->save();

                        $consent_pdf_created = dispatch(new LoanApplicationConsentCreatePDF($team_size_data, $application))->delay(now()->addSeconds(10));
                        //PDF CODE END
                    } else {
                        $consent_send_mail = dispatch(new LoanApplicationConsentEmail($team_size_data, $application))->delay(now()->addSeconds(10));
                    }
                }
            }
        }
        //consent code end

        return response()->json(['status' => 201, 'message' => 'Your application has been successfully submited.']);
    }

    public function getAbnAcn(Request $request)
    {
        $request->validate([
            'abn_acn' => 'required',
            'type' => 'required'
        ]);
        $response_json = $this->search_abn_acn($request->abn_acn, $request->type);
        //$response = json_decode($response);
        return $response_json;
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

    public function show($enc_id)
    {
        $application = Application::with('application_approved_document')->whereid(Crypt::decrypt($enc_id))->first();

        $body = 'View Loan Application Number : ' . $application->application_number;

        //ADMIN LOG START
        $this->store_logs('admin', 'Loan Application View', $body, $application->id);
        //ADMIN LOG END

        $status = Status::orderBy('order_number', 'ASC')->get();

        $email_template = EmailTemplate::wherestatus(1)->whereis_active_email_indent(1)->get();

        $approved_documents_data = ApprovedDocuments::wherestatus(1)->orderBy('sort_by', 'ASC')->get();

        return view('admin.loan-application.show', compact('application', 'enc_id', 'status', 'email_template', 'approved_documents_data'));
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

    public function consentResent(Request $request)
    {
        $team_id = $request->team_id;
        $team_size_data = TeamSize::where('id', $team_id)->first();
        $application = Application::whereId($team_size_data->application_id)->first();

        $consent_otp = sprintf("%06d", mt_rand(1, 999999));
        $consent_slug = generateUniqueSlug();

        if ($team_size_data) {

            if ($team_size_data->consent_slug === null) {
                $team_size_data->consent_slug = $consent_slug;
            }

            if ($team_size_data->consent_otp === null) {
                $team_size_data->consent_otp = $consent_otp;
            }

            $team_size_data->consent_sent_at = now();

            $team_size_data->is_accept_terms = 0;
            $team_size_data->ip_address = null;
            $team_size_data->consent_status = 0;
            $team_size_data->verified_at = null;
            $team_size_data->consent_pdf_file = null;

            $team_size_data->save();

            $consent_send_mail = dispatch(new LoanApplicationConsentEmail($team_size_data, $application))->delay(now()->addSeconds(10));
        }

        return response()->json(['status' => 201, 'message' => "Consent successfully resent to the Applicant/Director/Proprietor.", 'data' => $team_size_data]);
    }

    public function consent_redirect($slug)
    {
        $team_data = TeamSize::where('consent_slug', $slug)->first();

        if ($team_data != null) {
            /*if($team_data->consent_status == 0){*/
            return redirect('loan/consent/verify/' . Crypt::encrypt($team_data->application_id) . '/' . Crypt::encrypt($team_data->id));
            /*}else{
                return redirect('');
            }*/
        } else {
            return redirect('');
        }
    }

    public function consentSentOtp(Request $request)
    {
        $token = csrf_token();

        $submittedToken = request()->input('_token');

        if ($token === $submittedToken) {

            $team_id = $request->team_id_val;

            $request->validate([
                'mobile_number' => 'required|min:12'
            ]);

            $phone = str_replace(' ', '', $request->mobile_number);

            $teamsize = TeamSize::where('mobile', $phone)->where('id', $team_id)->first();

            if ($teamsize == null) {
                return response()->json(['status' => 403, 'message' => 'Input mobile number does not exist.']);
            }

            $otp = sprintf("%06d", mt_rand(1, 999999));

            $sms_text = config('constants.sms_consent_otp_text');
            $sms_text = str_replace("{OTP}", $otp, config('constants.sms_consent_otp_text'));
            $sms_status = sent_sms($phone, $sms_text);

            $teamsize->consent_otp = $otp;
            $teamsize->save();

            $team_object = new \stdClass();
            $team_object->name = $teamsize->firstname . " " . $teamsize->lastname;
            $team_object->email = $teamsize->email_address;
            $team_object->otp = $otp;

            (new SentConsentOtp($team_object))->handle();


            return response()->json(['status' => 201, 'message' => "OTP has been sent to input mobile number.", 'data' => []]);
        } else {
            return response()->json(['status' => 403, 'message' => "CSRF token mismatch", 'data' => []]);
        }
    }

    public function consent_verify($enc_id = "", $id = "")
    {
        try {
            $application_id = Crypt::decrypt($enc_id);
            $team_id = Crypt::decrypt($id);
            $application = Application::whereId($application_id)->first();
            $team_data = TeamSize::where('id', $team_id)->first();
            return view('applicant.loan.consent-verify', compact('application', 'enc_id', 'team_id', 'application_id', 'team_data'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('');
        }
    }

    public function consent_review($enc_id = "", $id = "")
    {
        try {
            $application_id = Crypt::decrypt($enc_id);
            $team_id = Crypt::decrypt($id);
            $application = Application::whereId($application_id)->first();
            $team_data = TeamSize::where('id', $team_id)->first();

            $client_ip = request()->ip();

            return view('applicant.loan.consent-review', compact('application', 'enc_id', 'team_id', 'application_id', 'team_data', 'client_ip'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect('');
        }
    }

    public function consentSave(Request $request)
    {
        $request->validate(
            [
                'privacy_policy' => 'required',
                'authority_to_obtain_credit_information' => 'required'
            ],
            [
                'privacy_policy.required' => 'Please agree privacy policy terms.',
                'authority_to_obtain_credit_information.required' => 'Please agree authority to obtain credit information.',
            ]
        );

        $team_id = $request->team_id;

        $team_data = TeamSize::where('id', $team_id)->first();
        $team_data->is_accept_terms = 1;
        $team_data->consent_status = 1;
        $team_data->ip_address = $request->ip_address;
        $team_data->verified_at = now();
        $team_data->save();

        //PDF CODE START
        $team_size_data = TeamSize::find($team_id);
        $enc_id = Crypt::encrypt($request->application_id);
        $application = $this->get_single_application($enc_id);
        $consent_pdf_created = dispatch(new LoanApplicationConsentCreatePDF($team_size_data, $application))->delay(now()->addSeconds(10));
        //PDF CODE END

        return response()->json(['status' => 201, 'message' => "Thank you for providing your consent! We appreciate your prompt response.", 'data' => $team_data]);
    }

    public function consentVerifyOtp(Request $request)
    {
        // Retrieve the CSRF token value
        $token = csrf_token();

        // Retrieve the CSRF token submitted with the request
        $submittedToken = request()->input('_token');

        // Compare the tokens
        if ($token === $submittedToken) {

            $redirect_url = "";

            $request->validate([
                'otp_number' => 'required|min:6|max:6'
            ]);

            $request_otp = $request->otp_number;

            $team_data = TeamSize::where('id', $request->team_id)->first();

            if (config('constants.sms_sent_flag') == 1) {
                $exit_otp = $team_data->consent_otp;
            } else {
                $exit_otp = "123456";
            }

            if ($exit_otp != $request_otp) {
                return response()->json(['status' => 403, 'message' => 'Entered OTP number does not match.']);
            } else {
                $redirect_url = url('loan/consent/review/' . Crypt::encrypt($team_data->application_id) . '/' . Crypt::encrypt($team_data->id));
            }

            return response()->json(['status' => 201, 'message' => "OTP number is successfully verified.", 'data' => $redirect_url]);

        } else {
            return response()->json(['status' => 403, 'message' => "CSRF token mismatch", 'data' => []]);
        }
    }

}