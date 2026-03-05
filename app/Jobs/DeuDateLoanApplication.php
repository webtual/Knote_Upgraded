<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\DeuDateLoanApplicationAdmin;

class DeuDateLoanApplication implements ShouldQueue
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
            
        //Reminder Mail For Admin
        Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new DeuDateLoanApplicationAdmin($this->loan_application));
        
    }
}
