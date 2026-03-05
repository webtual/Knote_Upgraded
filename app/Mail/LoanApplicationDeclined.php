<?php

namespace App\Mail;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoanApplicationDeclined extends Mailable implements ShouldQueue
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
        $sub = "Your Loan Application (Application Number: ".$this->loan_application->application_number .") Has been declined.";
        Log::info(PHP_EOL);
        Log::info('Sent mail to client declined loan application', [
            'subject' => $sub, 
            'loan_application' => $this->loan_application
        ]);
        
        return $this->subject($sub)->markdown('emails.loan_application.declined', ['loan_application' => $this->loan_application]);
    }
}
