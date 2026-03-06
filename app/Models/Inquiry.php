<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Inquiry extends Model
{
    use SoftDeletes;


    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }

}
