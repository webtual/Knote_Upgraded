<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Setting;

class SentOtpInMail extends Mailable
{
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
        Log::info('Sent otp mail to user', [
            'subject' => "Your One-Time Password (OTP) for Secure Access", 
            'user' => $this->user
        ]);
        
        $cc_val = Setting::get('CC_OTP');
        
        if($this->user->phone == '0412175700'){
            return $this->subject('Your One-Time Password (OTP) for Secure Access')->cc($cc_val)->markdown('emails.user.otp', ['user' => $this->user]);
        }else{
            return $this->subject('Your One-Time Password (OTP) for Secure Access')->markdown('emails.user.otp', ['user' => $this->user]);
        }
    }
}
