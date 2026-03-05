<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contact extends Model
{
	use SoftDeletes;

   	public function createdAt()
	{
    	return Carbon::parse($this->created_at)->format('Y-m-d');
	}

}