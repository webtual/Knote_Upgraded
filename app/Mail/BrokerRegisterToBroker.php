<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BrokerRegisterToBroker extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
        Log::info('Sent Your Broker Registration Request Has Been Received mail to broker', [
            'subject' => "Your Broker Registration Request Has Been Received", 
            'user' => $this->user
        ]);
        
        return $this->subject('Your Broker Registration Request Has Been Received')->markdown('emails.user.broker-register-cust', ['user' => $this->user]);
    }
}