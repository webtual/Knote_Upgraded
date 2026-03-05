<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use SoftDeletes;
    
    public function preference_question()
    {
        return $this->belongsTo('App\PreferenceQuestion');
    }

}