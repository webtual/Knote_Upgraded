<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Application extends Model
{

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function previous_application()
    {
        return $this->belongsTo(Application::class, 'previous_application_id');
    }

    public function broker()
    {
        return $this->belongsTo('App\User', 'broker_id')->withTrashed();
    }

    public function latest_status_history()
    {
        return $this->hasOne('App\StatusHistory', 'application_id')->latest();
    }

    public function application_approved_document()
    {
        return $this->hasMany('App\ApplicationApprovedDocuments', 'application_id');
    }

    public function application_documents()
    {
        return $this->hasMany('App\ApplicationDocuments', 'application_id')->where('is_type', 0)->orderBy('id', 'DESC');
    }

    public function business_structure()
    {
        return $this->belongsTo('App\BusinessStructure', 'business_structures_id');
    }

    public function business_type()
    {
        return $this->belongsTo('App\BusinessType');
    }

    public function current_status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }

    /*
    public function status_history(){
        return $this->hasMany('App\ApplicationStatus');
    }
    */

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function get_documents_by_type($type)
    {
        return $this->documents->where('type', $type);
    }

    public function finance_information()
    {
        return $this->hasOne('App\FinanceInformation');
    }

    public function review_documents()
    {
        return $this->hasMany('App\ReviewDocument');
    }

    public function review_notes()
    {
        return $this->hasMany('App\ReviewNote')->orderBy('id', 'Desc');
    }

    public function assessor_review_notes()
    {
        return $this->hasMany('App\AssessorReviewNote')->orderBy('id', 'Desc');
    }

    public function latest_company_enquiry_credit_score_event_logs()
    {
        return $this->hasMany('App\CreditScoreEventLogs')->where('name', '=', 'Company Enquiry')->where('status', '=', 'success')->orderBy('id', 'DESC');
    }

    public function latest_company_trading_enquiry_credit_score_event_logs()
    {
        return $this->hasMany('App\CreditScoreEventLogs')->where('name', '=', 'Company Trading History')->where('status', '=', 'success')->orderBy('id', 'DESC');
    }

    public function team_sizes()
    {
        return $this->hasMany('App\TeamSize')->orderBy('id', 'Asc');
    }

    public function property_securities()
    {
        return $this->hasMany('App\PropertySecurity')->orderBy('id', 'Asc');
    }

    public function loan_request_amount()
    {
        return '$' . number_format($this->amount_request);
    }

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function last_application_number()
    {

        $data = Application::select('*')->where('application_number', '!=', NULL)->orderBy('id', 'DESC')->first();

        $pretax = "";
        $last_year = date("Y", strtotime("-1 year"));
        $prefix_last_year = $pretax . "" . $last_year;
        $year = date('Y');
        $prefix = $pretax . "" . $year;

        if ($data != null) {
            $application_number = str_replace($prefix_last_year, '', $data->application_number);
        } else {
            $vals = '202401';
            $application_number = str_replace($prefix_last_year, '', $vals);
        }

        $application_number = str_replace($prefix, '', $application_number);
        $new_application_number = str_pad($application_number + 1, 2, 0, STR_PAD_LEFT);

        $new_application_number_val = $prefix . "" . $new_application_number;

        return $new_application_number_val;
    }

}