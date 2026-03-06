<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class BusinessType extends Model
{
    use SoftDeletes;

    public function applications()
    {
        return $this->hasMany('App\Models\Application');
    }

    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public static function count_business_type($type)
    {
        return self::wheretype($type)->get()->count();
    }
}
