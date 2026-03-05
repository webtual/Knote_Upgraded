<?php

namespace App\Mail;

use App\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoanApplicationConsent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info(PHP_EOL);
        Log::info('Sent mail to client', [
            'subject' => "consent loan application message sent to the director", 
            'loan_application' => $this->loan_application,
            'team_size_data' => $this->team_size_data
        ]);
        
        return $this->subject('Consent Loan Application Submitted for Review on Knote')->markdown('emails.loan_application.consent', ['loan_application' => $this->loan_application, 'team_size_data' => $this->team_size_data]);
    }
}
