<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceInformationByPeople extends Model
{
	use SoftDeletes;

	public function applications()
    {
        return $this->belongsToMany('App\Models\Application');
    }
    
    public function team_person()
    {
        return $this->belongsTo('App\Models\TeamSize');
    }
}
