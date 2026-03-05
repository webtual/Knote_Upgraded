<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSend extends Model {
	use SoftDeletes;   	
    protected $table = 'email_sends';
     
	public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }
    
    public function applications(){
        return $this->belongsToMany('App\Application')->withTrashed();
    }
}