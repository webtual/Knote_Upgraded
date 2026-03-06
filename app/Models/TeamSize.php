<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamSize extends Model
{
	use SoftDeletes;

	protected $fillable = ['application_id', 'title', 'firstname', 'lastname'];
    
   	public function applications(){
        return $this->belongsToMany('App\Models\Application');
    }
    
    public function score_seeker_event_logs(){
        return $this->hasMany('App\Models\CreditScoreEventLogs')->where('name', '=','ScoreSeeker Enquiry')->where('status', '=','success')->orderBy('id', 'DESC');
    }
}
