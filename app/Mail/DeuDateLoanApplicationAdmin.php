<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeuDateLoanApplicationAdmin extends Mailable implements ShouldQueue
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
        $status_val_name = $this->loan_application->current_status ? $this->loan_application->current_status->status : '';
        
        if(in_array($status_val_name, ['Completed', 'Under Review', 'Assessment'])){
            $sub = "Reminder: This application has been in ".$status_val_name." status for more than 4 hours and now requires urgent action.";
        }elseif($status_val_name == 'Fast Track'){
            $sub = "Reminder: This application has been in Fast Track status for more than 24 hours and requires immediate attention.";
        }elseif($status_val_name == 'Full Assessment'){
            $sub = "Reminder: This application has been in Full Assessment status for more than 72 hours and is now overdue.";
        }
        
        Log::info(PHP_EOL);
        Log::info('Sent mail to admin '.$status_val_name.' loan application', [
            'subject' => $sub, 
            'loan_application' => $this->loan_application
        ]);
        
        return $this->subject($sub)->markdown('emails.loan_application.admin-duedate', ['loan_application' => $this->loan_application]);
    }
}
