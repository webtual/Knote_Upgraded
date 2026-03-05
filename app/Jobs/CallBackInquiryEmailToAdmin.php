<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\CallBackInquiryToAdmin;

class CallBackInquiryEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $inquiry;

    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Callback message sent to the Admin
        $admin_contacts = config('constants.admin_sms_lead_receivers');
        $contacts = explode(',',$admin_contacts);
        foreach ($contacts as $admin_phone){
            $sms_text = config('constants.sms_admin_callback_inquiry');
            //$application_type = ($this->inquiry->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
            $application_types = config('constants.apply_for'); 
            $application_type = $application_types[$this->inquiry->apply_for] ?? 'Unknown Funding';
            $client = ($this->inquiry->contact) ? $this->inquiry->contact : '';
            $sms_text = str_replace(
                ['{APPLICATION_TYPE}', '{CLIENT_PHONE_NUMBER}'],
                [$application_type, $client],
                $sms_text
            );
            $sms_status = sent_sms($admin_phone, $sms_text);
            
            Log::info(PHP_EOL);
            Log::info('inquiry callback message sent to the admin', [
                'sms_status' => $sms_status, 
                'sms_message' => $sms_text,
                'inquiry' => $this->inquiry
            ]);
        }
            
        
        Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new CallBackInquiryToAdmin($this->inquiry));
    }
}
