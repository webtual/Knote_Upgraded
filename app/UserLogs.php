<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLogs extends Model
{
  use SoftDeletes;

  public $timestamps = true;


  public function user()
  {
    return $this->belongsTo('App\User', 'user_id')->withTrashed();
  }

}
