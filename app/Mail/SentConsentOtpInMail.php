<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

//class SentConsentOtpInMail extends Mailable implements ShouldQueue
class SentConsentOtpInMail extends Mailable
{
    //use Queueable, SerializesModels;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;

    public function __construct($user)
    {
        //
        $this->user = $user;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info(PHP_EOL);
        Log::info('Sent otp mail to team', [
            'subject' => "Your Consent One-Time Password (OTP) for Secure Access", 
            'user' => $this->user
        ]);
        
        return $this->subject('Your Consent One-Time Password (OTP) for Secure Access')->markdown('emails.user.consent-otp', ['user' => $this->user]);
    }
}
