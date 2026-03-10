<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertySecurity extends Model
{
    use SoftDeletes;

    protected $fillable = ['application_id', 'purpose', 'property_type', 'property_owner', 'property_address', 'property_value', 'is_verified', 'created_at', 'updated_at', 'deleted_at'];

    public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }


}
