<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\LoanApplicationConsent;

class LoanApplicationConsentEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $team_size_data;
    protected $loan_application;

    public function __construct($team_size_data, $loan_application)
    {
        $this->team_size_data = $team_size_data;
        $this->loan_application = $loan_application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Sent SMS to Client
        $customer_phone = $this->team_size_data->mobile;
        $customer_email_address = $this->team_size_data->email_address;
        $consent_slug = $this->team_size_data->consent_slug;
        $consent_otp = $this->team_size_data->consent_otp;
        $consent_slug_link = url('s/'.$consent_slug);
        $sms_text = config('constants.sms_director_consent_loan_application_inquiry');
            
        //$application_type = ($this->loan_application->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
        $application_types = config('constants.apply_for'); 
        $application_type = $application_types[$this->loan_application->apply_for] ?? 'Unknown Funding';
        $application_number = $this->loan_application->application_number;
        
        
        $sms_text = str_replace(
            ['{APPLICATION_TYPE}', '{APPLICATION_NUMBER}', '{LINK}', '{OTP}'],
            [$application_type, $application_number, $consent_slug_link, $consent_otp],
            $sms_text
        );
        $sms_status = sent_sms($customer_phone, $sms_text);
        
        Log::info(PHP_EOL);
        Log::info('consent loan application message sent to the director', [
            'sms_status' => $sms_status, 
            'sms_message' => $sms_text,
            'loan_application' => $this->loan_application,
            'team_size_data' => $this->team_size_data
        ]);
                        
        //Thank you for customer
        Mail::to($customer_email_address)->send(new LoanApplicationConsent($this->team_size_data, $this->loan_application));
    }
}
