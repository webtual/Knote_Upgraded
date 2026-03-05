<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


use App\Mail\CallBackInquiryToClient;

class CallBackInquiryEmailToClient implements ShouldQueue
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
        
        //Sent SMS to Client
        $customer_phone = $this->inquiry->contact;
        $sms_text = config('constants.sms_client_callback_inquiry');
            
        //$application_type = ($this->inquiry->apply_for == 2) ? "KF Property Backed Funding" : "KF Business Cash Flow Funding";
        $application_types = config('constants.apply_for'); 
        $application_type = $application_types[$this->inquiry->apply_for] ?? 'Unknown Funding';
        
        $sms_text = str_replace(
            ['{APPLICATION_TYPE}'],
            [$application_type],
            $sms_text
        );
        $sms_status = sent_sms($customer_phone, $sms_text);
        
        Log::info(PHP_EOL);
        Log::info('inquiry callback message sent to the client', [
            'sms_status' => $sms_status, 
            'sms_message' => $sms_text,
            'inquiry' => $this->inquiry
        ]);
        
        // Sent mail to client
        Mail::to($this->inquiry->email)->send(new CallBackInquiryToClient($this->inquiry));
    }
}
