<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Inquiry extends Model
{
    use SoftDeletes;
    

    /* public function inquiryable()
    {
        return $this->morphTo();
    }
    
    public static function check_visitor_inquiry_is_exit($inquirieable_id, $contact, $email){
    	return self::where('inquirieable_id', $inquirieable_id)->where('contact', $contact)->where('email', $email)->first();
    }*/
    
   	public function createdAt()
	{
    	return Carbon::parse($this->created_at)->format('Y-m-d');
	}
	
	public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

}