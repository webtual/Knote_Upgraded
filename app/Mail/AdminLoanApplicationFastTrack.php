<?php

namespace App\Mail;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AdminLoanApplicationFastTrack extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $loan_application;

    public function __construct($loan_application)
    {
        //
        $this->loan_application = $loan_application;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sub = "Fast-Track Update - Decision Within 24 Hours (Application Number: ".$this->loan_application->application_number .")";
        Log::info(PHP_EOL);
        Log::info('Sent mail to admin Fast Track loan application', [
            'subject' => $sub, 
            'loan_application' => $this->loan_application
        ]);
        
        return $this->subject($sub)->markdown('emails.loan_application.admin-fasttrack', ['loan_application' => $this->loan_application]);
    }
}
