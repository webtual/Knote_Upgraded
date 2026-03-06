<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationDocuments extends Model
{
    protected $table = 'application_documents';
     
	use SoftDeletes;
    
    public function user(){
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
    
    public function application(){
        return $this->belongsTo('App\Models\Application')->withTrashed();
    }
    
    public function document_file_path(){
        return asset('storage/mail_document/'.$this->id.'_'.$this->title.'.'.$this->file_extension);
    }
}
