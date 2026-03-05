<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BlogCategory extends Model
{
    use SoftDeletes;
    
    /*public function blogs()
    {
        return $this->hasMany('App\Blog');
    }*/

    public function blogs()
    {
        return $this->belongsToMany('App\Blog')->withTimestamps();
    }

    public function createdAt()
	{
    	return Carbon::parse($this->created_at)->format('Y-m-d');
	}


    public function slug(){
        return (str_slug($this->name, '-').'-'.$this->id);
    }


}