<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditScoreEventLogs extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
   
    public function application(){
        return $this->belongsTo('App\Models\Application', 'application_id')->withTrashed();
    }
}
