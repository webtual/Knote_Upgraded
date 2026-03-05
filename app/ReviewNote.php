<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class ReviewNote extends Model
{
    use SoftDeletes;

    public function applications()
    {
        return $this->belongsToMany('App\Application');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'reviewer_id');
    }
    public function time_ago()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}