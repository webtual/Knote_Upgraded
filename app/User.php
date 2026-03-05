<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Auth;

use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    const ADMIN_TYPE = '1';
    const USER_TYPE = '0';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone',
        'avtar',
        'customer_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/


    public const KNOW_ABOUT_US_VAL = [
        1 => 'Social Media (Facebook, Instagram, Youtube etc)',
        2 => 'Google/Search Engine',
        3 => 'Email Newsletter',
        4 => 'Flyer',
        5 => 'Billboard',
        6 => 'Word of mouth (family and friends)',
        7 => 'Broker',
        8 => 'Other',
    ];


    public function last_customer_no()
    {
        $data = User::select('users.id as userId', 'users.*')->where('customer_no', '!=', null)->whereHas('roles', function ($query) {
            $query->where('type', '=', '0');
        })->orderBy('users.id', 'DESC')->first();

        $pretax = "KN";
        $last_year = date("Y", strtotime("-1 year"));
        $prefix_last_year = $pretax . "" . $last_year;
        $year = date('Y');
        $prefix = $pretax . "" . $year;

        if ($data != null) {
            $customer_no = str_replace($prefix_last_year, '', $data->customer_no);
        } else {
            $vals = 'KN202401';
            $customer_no = str_replace($prefix_last_year, '', $vals);
        }

        $customer_no = str_replace($prefix, '', $customer_no);
        $new_customer_no = str_pad($customer_no + 1, 2, 0, STR_PAD_LEFT);

        $new_customer_no_val = $prefix . "" . $new_customer_no;

        return $new_customer_no_val;
    }


    public function roles()
    {
        /**
         * The roles that belong to the user.
         */
        return $this->belongsToMany('App\Role')->withTimestamps();
    }


    public function applications()
    {
        return $this->hasMany('App\Application');
    }

    public function stage_application()
    {
        return $this->hasOne('App\Application')->where('stage', '!=', null)->orderBy('created_at', 'desc')->first();
    }

    /*public function stage_application_edit(){
        return $this->hasOne('App\Application')
                    ->where('stage', '=', null)
                    ->when($this->applications()->count() >= 2, function ($query) {
                        $query->latest('created_at')->first();
                    });
    }*/

    public function stage_application_edit()
    {
        return $this->hasOne('App\Application')->where('stage', '=', null)->latest('created_at')->first();
    }



    public function createdAt()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function is_user()
    {
        return $this->roles->first()->type == self::USER_TYPE;
    }

    /*public function is_admin()
    {
       return $this->roles->first()->type == self::ADMIN_TYPE;
    }*/

    /*public function is_broker()
    {
       return $this->roles->first()->type == self::ADMIN_TYPE;
    }*/

    public function is_admin()
    {
        return $this->roles->contains('slug', 'admin');
    }

    public function is_broker()
    {
        return $this->roles->contains('slug', 'broker');
    }

    public static function count_users($role_id)
    {
        return self::whereHas('roles', function ($q) use ($role_id) {
            $q->where('role_id', '=', $role_id);
        })->count();
    }


    public static function force_logout()
    {
        return Auth::logout();
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    /*public static function check_users_credential($type, $email, $password)
    {
        echo $email;
        echo Hash::make($password);
        return self::wheretype($type)->whereemail($email)->wherepassword(Hash::make($password))->get()->count();
    }*/


}
