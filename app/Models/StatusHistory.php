<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusHistory extends Model
{
	use SoftDeletes;
    
    public function status_history(){
        return $this->belongsToMany('App\Models\Application');
    }

    public function status(){
        return $this->belongsTo('App\Models\Status', 'status_id');
    }
   
}
