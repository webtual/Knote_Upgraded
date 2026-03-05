<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLogs extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    
   
    public function user(){
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }
    
    /*public static function store_logs($type, $title, $body){
      $logs = New UserLogs;
      $logs->user_id = (auth()->check()) ? auth()->user()->id : '1';
      $logs->type = $type;
      $logs->title = $title;
      $logs->body = $body;
      $logs->save();
    }*/
}
