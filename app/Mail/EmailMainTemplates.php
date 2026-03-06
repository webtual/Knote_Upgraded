<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Setting;


class EmailMainTemplates extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;        
    
    public $email_data;
    public $html_data;
    public $attachment_files;
    public $from_email;
    public $cc_email;
    public $reply_to;
    
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_data)
    {
    	$this->html_data = $email_data['message'];
        $this->subject = $email_data['subject'];
        $this->attachment_files = $email_data['attachments'];
        $this->from_email = $email_data['from_email'];
        $this->cc_email = $email_data['cc'];
        $this->reply_to = $email_data['reply_to'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

        if(empty($this->attachment_files)){
        	if($this->from_email == ""){
        		return $this->subject($this->subject)->markdown('emails.temp-html-email', ['html_data' => $this->html_data]);	
        	}else{
        		$bcc_emails = explode(', ', Setting::get('BCC'));
        		return $this->from($this->from_email, config('app.name'))
        					->subject($this->subject)
        					->cc($this->cc_email)
        					//->bcc($bcc_emails, config('app.name'))
							->replyTo($this->reply_to, config('app.name'))
        					->markdown('emails.temp-html-email', ['html_data' => $this->html_data]);
        	}
        }else{
            if($this->from_email == ""){
            	$email = $this->subject($this->subject)->markdown('emails.temp-html-email',['html_data' => $this->html_data]);
            }else{
            	$email = $this->from($this->from_email, config('app.name'))
            				  ->subject($this->subject)
            				  ->cc($this->cc_email)
            				  //->bcc(Setting::get('BCC'), config('app.name'))
							  ->replyTo($this->reply_to, config('app.name'))
            				  ->markdown('emails.temp-html-email',['html_data' => $this->html_data]);
            }
            // $attachments is an array with file paths of attachments
            foreach($this->attachment_files as $file){
                $filename = parse_url($file, PHP_URL_PATH);
                $email->attachFromStorage('public/mail_document/'.basename($filename));
            }
            return $email;
        }
    }
}
