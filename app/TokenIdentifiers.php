<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TokenIdentifiers extends Model
{
    use SoftDeletes;
    
    protected $table = 'token_identifiers';
    
    
}