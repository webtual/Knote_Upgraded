<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class BusinessProposal extends Model
{
    use SoftDeletes;
    


    public function favourites()
    {
        return $this->morphMany('App\Favourite', 'favouriteable');
    }

    /* public function inquiries()
    {
        return $this->morphMany('App\Inquiry', 'inquirieable');
    }
    */

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function business_types()
    {
        return $this->belongsToMany('App\BusinessType')->withTimestamps();
    }

    /*public function business_type(){
        return $this->belongsTo('App\BusinessType');
    }*/

    public function user_is_favourite(){
        return $this->hasOne('App\Favourite', 'favouriteable_id')->where('favouriteable_type', 'App\BusinessProposal')->where('user_id', auth()->user()->id);
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

    public function money_format_target()
	{
		return 'A$ '.number_format($this->target);
	}

	public function money_format_min_per_investor()
	{
		return 'A$ '.number_format($this->min_per_investor);
	}

    public function time_ago()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
    

}