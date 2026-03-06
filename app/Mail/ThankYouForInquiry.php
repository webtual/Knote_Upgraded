<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ThankYouForInquiry extends Mailable implements ShouldQueue
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
        Log::info(PHP_EOL);
        Log::info('Sent mail to client', [
            'subject' => "Thank You for Your Loan Inquiry on Knote", 
            'loan_application' => $this->loan_application
        ]);
        
        return $this->subject('Thank You for Your Loan Inquiry on Knote')->markdown('emails.loan_application.thank_you', ['loan_application' => $this->loan_application]);
    }
}
