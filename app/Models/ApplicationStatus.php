<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationStatus extends Model
{
	use SoftDeletes;
    
    public function status_history()
    {
        /**
        * The roles that belong to the user.
        */
        return $this->belongsToMany('App\Models\Application');
    }

   
}
