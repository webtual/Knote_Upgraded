<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Resource extends Model
{
    use SoftDeletes;
 	
 	
 	public function favourites()
    {
        return $this->morphMany('App\Favourite', 'favouriteable');
    }

    /*public function inquiries()
    {
        return $this->morphMany('App\Inquiry', 'inquirieable');
    }*/


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function business_types(){
        return $this->belongsToMany('App\BusinessType', 'business_type_resources')->withTimestamps();
    }
    
    public function user_is_favourite(){
        return $this->hasOne('App\Favourite', 'favouriteable_id')->where('favouriteable_type', 'App\Resource')->where('user_id', auth()->user()->id);
    }

    public function user_favourites()
    {
        return $this->belongsToMany('App\User');
    }



    public function getTitleAttribute($value) {
        return ucfirst($value);
    }

   
    public function slug(){
    	return (str_slug($this->title, '-').'-'.$this->id);
    }

    public function money_format_amount()
	{
		return ($this->amount == "") ? 'FREE' : 'A$ '.number_format($this->amount);
	}

    public function time_ago()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

}