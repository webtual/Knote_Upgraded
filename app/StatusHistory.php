<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusHistory extends Model
{
	use SoftDeletes;
    
    public function status_history(){
        return $this->belongsToMany('App\Application');
    }

    public function status(){
        return $this->belongsTo('App\Status', 'status_id');
    }
   
}