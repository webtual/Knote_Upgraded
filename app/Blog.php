<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Blog extends Model
{
    use SoftDeletes;
    

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*public function category()
    {
        return $this->belongsTo('App\BlogCategory', 'blog_category_id');
    }*/
    
    public function category()
    {
        return $this->belongsToMany('App\BlogCategory', 'blog_blog_categories')->withTimestamps();
    }



    public function slug(){
    	return (str_slug($this->title, '-').'-'.$this->id);
    }
    
    public function time_ago()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

}