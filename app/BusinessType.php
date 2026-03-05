<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class BusinessType extends Model
{
    use SoftDeletes;
    
  	public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function business_proposals()
    {
        return $this->belongsToMany('App\BusinessProposal')->withTimestamps();
    }

    public function resources()
    {
        return $this->belongsToMany('App\Resource')->withTimestamps();
    }

    /*public function business_proposals()
    {
        return $this->hasMany('App\BusinessProposal');
    }

    public function resources()
    {
        return $this->hasMany('App\Resource');
    }*/

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public static function count_business_type($type){
        return self::wheretype($type)->get()->count();
    }
}