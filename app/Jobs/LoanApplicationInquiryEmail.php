<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\LoanApplicationInquiry;
use App\Mail\ThankYouForInquiry;

class LoanApplicationInquiryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $loan_application;

    public function __construct($loan_application)
    {
        $this->loan_application = $loan_application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Sent SMS to Admin
        
        //Callback message sent to the Admin
        $admin_contacts = config('constants.admin_sms_lead_receivers');
        $contacts = explode(',',$admin_contacts);
        foreach ($contacts as $admin_phone){
            $sms_text = config('constants.sms_admin_loan_application_inquiry');
            
            
            //$application_type = ($this->loan_application->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
            $application_types = config('constants.apply_for'); 
            $application_type = $application_types[$this->loan_application->apply_for] ?? 'Unknown Funding';
            $application_number = $this->loan_application->application_number;
            
            
            $sms_text = str_replace(
                ['{APPLICATION_TYPE}', '{APPLICATION_NUMBER}'],
                [$application_type, $application_number],
                $sms_text
            );
            $sms_status = sent_sms($admin_phone, $sms_text);
            
            Log::info(PHP_EOL);
            Log::info('initial loan application message sent to the admin', [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
        }
        
        
        //Sent SMS to Client
        if($this->loan_application->broker_id != null){
            $client_phone = $this->loan_application->broker->phone;
            $client_email = $this->loan_application->broker->email;
            $msg_log_text = 'initial loan application message sent to the broker';
        }else{
            $client_phone = $this->loan_application->user->phone;
            $client_email = $this->loan_application->user->email;
            $msg_log_text = 'initial loan application message sent to the client';
        }
        
        $sms_text = config('constants.sms_client_loan_application_inquiry');
            
        //$application_type = ($this->loan_application->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
        $application_types = config('constants.apply_for'); 
        $application_type = $application_types[$this->loan_application->apply_for] ?? 'Unknown Funding';
        $application_number = $this->loan_application->application_number;
        
        $sms_text = str_replace(
            ['{APPLICATION_TYPE}', '{APPLICATION_NUMBER}'],
            [$application_type, $application_number],
            $sms_text
        );
        $sms_status = sent_sms($client_phone, $sms_text);
        
        Log::info(PHP_EOL);
        
        Log::info($msg_log_text, [
            'sms_status' => $sms_status, 
            'sms_message' => $sms_text,
            'loan_application' => $this->loan_application
        ]);
        
        //New lead for admin
        Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new LoanApplicationInquiry($this->loan_application));
                        
        //Thank you for client/broker
        Mail::to($client_email)->send(new ThankYouForInquiry($this->loan_application));
    }
}
