<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerUser extends Model
{
    use SoftDeletes;
    
    public $timestamps = true;
    
    public function preference_question()
    {
        return $this->belongsTo('App\PreferenceQuestion');
    }

    public static function get_user_answer($preference_question_id, $user_id){
        return self::where('preference_question_id', $preference_question_id)->where('user_id', $user_id)->first(); 
    }
    
    public static function get_inquiry_answer($preference_question_id, $inquiry_id){
        return self::where('preference_question_id', $preference_question_id)->where('inquiry_id', $inquiry_id)->first(); 
    }
    
}
