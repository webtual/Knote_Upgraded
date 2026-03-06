<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceInformation extends Model
{
    use SoftDeletes;
    
   	public function application()
    {
        return $this->belongsTo('App\Models\Application');
    }


    
    


}
