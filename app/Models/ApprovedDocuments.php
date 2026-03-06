<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovedDocuments extends Model
{
    use SoftDeletes;
    
    protected $table = 'approved_documents';
    
    
}
