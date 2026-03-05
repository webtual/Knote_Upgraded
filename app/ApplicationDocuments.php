<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationDocuments extends Model
{
    protected $table = 'application_documents';
     
	use SoftDeletes;
    
    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }
    
    public function application(){
        return $this->belongsTo('App\Application')->withTrashed();
    }
    
    public function document_file_path(){
        return asset('storage/mail_document/'.$this->id.'_'.$this->title.'.'.$this->file_extension);
    }
}