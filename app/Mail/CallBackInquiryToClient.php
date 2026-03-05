<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CallBackInquiryToClient extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $inquiry;

    public function __construct($inquiry)
    {
        //
        $this->inquiry = $inquiry;
        
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
            'subject' => "Your request has been successfully submitted", 
            'inquiry' => $this->inquiry
        ]);
        
        return $this->subject('Your request has been successfully submitted')->markdown('emails.callback.client', ['inquiry' => $this->inquiry]);
    }
}
