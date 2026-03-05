<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class AssessorReviewDocuments extends Model
{
    use SoftDeletes;
    
    public function review(){
        return $this->belongsTo('App\AssessorReviewNote', 'assessor_review_note_id');
    }
    
}