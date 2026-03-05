<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationApprovedDocuments extends Model
{
    use SoftDeletes;
    
    protected $table = 'application_approved_documents';
    
    
    public function approved_document(){
        return $this->belongsTo('App\ApprovedDocuments', 'approved_document_id');
    }
    
    public function application(){
        return $this->belongsTo('App\Application')->withTrashed();
    }
}