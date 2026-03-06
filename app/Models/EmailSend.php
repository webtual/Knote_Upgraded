<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSend extends Model {
	use SoftDeletes;   	
    protected $table = 'email_sends';
     
	public function user(){
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
    
    public function applications(){
        return $this->belongsToMany('App\Models\Application')->withTrashed();
    }
}
