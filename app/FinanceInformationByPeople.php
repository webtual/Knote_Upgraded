<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceInformationByPeople extends Model
{
	use SoftDeletes;

	public function applications()
    {
        return $this->belongsToMany('App\Application');
    }
    
    public function team_person()
    {
        return $this->belongsTo('App\TeamSize');
    }
}