<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemEventLog extends Model
{
    protected $table = 'system_event_logs';
    	
	use SoftDeletes;
    
    public static function send_email_log($email_data, $is_sent=1, $error=null){
        
        $email_log = new SystemEventLog;
        $email_log->type = "emailLog";
        $email_log->from_email = $email_data['from_email'];
        //$email_log->to_email = $email_data['to'];
        $email_log->to_email = is_array($email_data['to']) ? implode(',', $email_data['to']) : $email_data['to'];
        $email_log->cc_email = $email_data['cc'];
        $email_log->bcc_email = $email_data['bcc'];
        $email_log->reply_to_email = $email_data['reply_to'];
        $email_log->to_name = $email_data['name'];
        $email_log->subject = $email_data['subject'];
        $email_log->body = $email_data['message'];
        $email_log->is_sent = $is_sent;
        $email_log->error_message = $error;
        $email_log->user_id = (auth()->check()) ? auth()->user()->id : '1';
        $email_log->save();
    }
    
}
