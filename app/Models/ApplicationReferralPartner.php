<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationReferralPartner extends Model
{
    protected $table = 'application_referral_partners';

    protected $fillable = [
        'application_id',
        'name',
        'phone',
        'email',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}
