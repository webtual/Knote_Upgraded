<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\LoanApplicationApproved;
use App\Mail\LoanApplicationSettled;
use App\Mail\LoanApplicationDeclined;
use App\Mail\LoanApplicationFastTrack;
use App\Mail\LoanApplicationFullAssessment;


use App\Mail\AdminLoanApplicationApproved;
use App\Mail\AdminLoanApplicationSettled;
use App\Mail\AdminLoanApplicationDeclined;
use App\Mail\AdminLoanApplicationFastTrack;
use App\Mail\AdminLoanApplicationFullAssessment;

class LoanApplicationStatusUpdate implements ShouldQueue
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
        $admin_mail = config('constants.contact_inquiry_receiver_email');
        
        if($this->loan_application->broker_id != null){
            $client_phone = $this->loan_application->broker->phone;
            $client_email = $this->loan_application->broker->email;
            $msg_log_text = 'broker';
        }else{
            $client_phone = $this->loan_application->user->phone;
            $client_email = $this->loan_application->user->email;
            $msg_log_text = 'client';
        }
        
        //Full Assessment
        if($this->loan_application->status_id == 12){
            //Sent SMS to Client
            //$client_phone = $this->loan_application->user->phone;
            
            $sms_text = config('constants.sms_client_loan_application_full_assessment');
                
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
            Log::info('Full Assessment loan application message sent to the '.$msg_log_text, [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
            
            
            $admin_contacts = config('constants.admin_sms_lead_receivers');
            $contacts = explode(',',$admin_contacts);
            foreach ($contacts as $admin_phone){
                $sms_text = config('constants.sms_admin_loan_application_full_assessment');
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
                Log::info('Full Assessment loan application message sent to the admin', [
                    'sms_status' => $sms_status, 
                    'sms_message' => $sms_text,
                    'loan_application' => $this->loan_application
                ]);
            }
            
            //Thank you for client
            Mail::to($client_email)->send(new LoanApplicationFullAssessment($this->loan_application));
            
            
            //Reminder Mail For Admin
            Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new AdminLoanApplicationFullAssessment($this->loan_application));
        }
        
        //Fast Track
        if($this->loan_application->status_id == 9){
            //Sent SMS to Client
            //$client_phone = $this->loan_application->user->phone;
            $sms_text = config('constants.sms_client_loan_application_fast_track');
                
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
            Log::info('Fast Track loan application message sent to the '.$msg_log_text, [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
            
            
            $admin_contacts = config('constants.admin_sms_lead_receivers');
            $contacts = explode(',',$admin_contacts);
            foreach ($contacts as $admin_phone){
                $sms_text = config('constants.sms_admin_loan_application_fast_track');
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
                Log::info('Fast Track loan application message sent to the admin', [
                    'sms_status' => $sms_status, 
                    'sms_message' => $sms_text,
                    'loan_application' => $this->loan_application
                ]);
            }
            
            //Thank you for client
            Mail::to($client_email)->send(new LoanApplicationFastTrack($this->loan_application));
            
            
            //Reminder Mail For Admin
            Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new AdminLoanApplicationFastTrack($this->loan_application));
        }
        
        //Settled
        if($this->loan_application->status_id == 11){
            //Sent SMS to Client
            //$client_phone = $this->loan_application->user->phone;
            $sms_text = config('constants.sms_client_loan_application_settled');
                
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
            Log::info('settled loan application message sent to the '.$msg_log_text, [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
            
            
            $admin_contacts = config('constants.admin_sms_lead_receivers');
            $contacts = explode(',',$admin_contacts);
            foreach ($contacts as $admin_phone){
                $sms_text = config('constants.sms_admin_loan_application_settled');
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
                Log::info('settled loan application message sent to the admin', [
                    'sms_status' => $sms_status, 
                    'sms_message' => $sms_text,
                    'loan_application' => $this->loan_application
                ]);
            }
            
            //Thank you for client
            Mail::to($client_email)->send(new LoanApplicationSettled($this->loan_application));
            
            //Reminder Mail For Admin
            Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new AdminLoanApplicationSettled($this->loan_application));
        }
        
        //Approved
        if($this->loan_application->status_id == 7){
            //Sent SMS to Client
            //$customer_phone = $this->loan_application->user->phone;
            $sms_text = config('constants.sms_client_loan_application_approved');
                
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
            Log::info('approved loan application message sent to the client', [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
            
            
            $admin_contacts = config('constants.admin_sms_lead_receivers');
            $contacts = explode(',',$admin_contacts);
            foreach ($contacts as $admin_phone){
                $sms_text = config('constants.sms_admin_loan_application_approved');
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
                Log::info('approved loan application message sent to the admin', [
                    'sms_status' => $sms_status, 
                    'sms_message' => $sms_text,
                    'loan_application' => $this->loan_application
                ]);
            }
            
            //Thank you for client
            Mail::to($client_email)->send(new LoanApplicationApproved($this->loan_application));
            
            
            //Reminder Mail For Admin
            Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new AdminLoanApplicationApproved($this->loan_application));
        }
        
        //Decline
        if($this->loan_application->status_id == 8){
            //Sent SMS to Client
            //$customer_phone = $this->loan_application->user->phone;
            $sms_text = config('constants.sms_client_loan_application_declined');
                
            //$application_type = ($this->loan_application->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
            $application_types = config('constants.apply_for');
            $application_type = $application_types[$this->loan_application->apply_for] ?? 'Unknown Funding';
            $application_number = $this->loan_application->application_number;
            $client_name = $this->loan_application->user->name;
            
            $sms_text = str_replace(
                ['{APPLICATION_TYPE}', '{APPLICATION_NUMBER}', '{CLIENT_NAME}',''],
                [$application_type, $application_number, $client_name],
                $sms_text
            );
            $sms_status = sent_sms($client_phone, $sms_text);
            
            Log::info(PHP_EOL);
            Log::info('decline loan application message sent to the client', [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'loan_application' => $this->loan_application
            ]);
            
            
            $admin_contacts = config('constants.admin_sms_lead_receivers');
            $contacts = explode(',',$admin_contacts);
            foreach ($contacts as $admin_phone){
                $sms_text = config('constants.sms_admin_loan_application_declined');
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
                Log::info('declined loan application message sent to the admin', [
                    'sms_status' => $sms_status, 
                    'sms_message' => $sms_text,
                    'loan_application' => $this->loan_application
                ]);
            }
            
            //Decline for client
            Mail::to($client_email)->send(new LoanApplicationDeclined($this->loan_application));
            
            //Reminder Mail For Admin
            Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new AdminLoanApplicationDeclined($this->loan_application));
        }
        
    }
}
