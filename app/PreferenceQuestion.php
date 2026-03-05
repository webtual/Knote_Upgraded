<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PreferenceQuestion extends Model
{
    use SoftDeletes;
    
    public function question_answers(){
    	return $this->hasMany('App\QuestionAnswer');
    }

    public function user_answer(){
    	return $this->hasOne('App\AnswerUser')->where('user_id', auth()->user()->id);	
    }

    public function role(){
        return $this->belongsTo('App\Role');
    }
    

   
    public static function get_question_by_role($role_id){
    	return self::whererole_id($role_id)->get();
    }

    public static function get_question_roles(){
    	return self::select('role_id')->groupBy('role_id')->get();
    }

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

}