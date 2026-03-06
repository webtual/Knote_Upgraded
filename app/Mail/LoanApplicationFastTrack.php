<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoanApplicationFastTrack extends Mailable implements ShouldQueue
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
        Log::info('Sent mail to client Fast Track loan application', [
            'subject' => $sub, 
            'loan_application' => $this->loan_application
        ]);
        
        return $this->subject($sub)->markdown('emails.loan_application.fasttrack', ['loan_application' => $this->loan_application]);
    }
}
