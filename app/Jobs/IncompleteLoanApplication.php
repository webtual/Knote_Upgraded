<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\IncompleteLoanApplicationClient;
use App\Mail\IncompleteLoanApplicationAdmin;

class IncompleteLoanApplication implements ShouldQueue
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
            
        //Reminder Mail For client
        Mail::to($this->loan_application->user->email)->send(new IncompleteLoanApplicationClient($this->loan_application));
            
        //Reminder Mail For Admin
        Mail::to([config('constants.contact_inquiry_receiver_email'), config('constants.contact_inquiry_receiver_email_cc')])->send(new IncompleteLoanApplicationAdmin($this->loan_application));
        
    }
}
