<?php

namespace App\Models\Customer;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,SoftDeletes,Notifiable;

    protected $table = "customers";

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'profile_image',
        'primary_contact_1',
        'Secondary_contact_1',
        'primary_contact_2',
        'Secondary_contact_2',
        'address_line1',
        'address_line2',
        'is_verified',
        'email_verified_at',
        'user_type',
        'fb_id',
        'social_id',
        'social_type',
        'status',
        'last_login',
        'last_login_ipAddress',
    ];

    protected $appends = ['profile_image_path', 'full_name'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return string
     */
    public function getProfileImagePathAttribute(): string
    {
        $path = asset('/front/uploads/customer');
        return $path . '/' . $this->profile_image;
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . " " . $this->middle_name . " " . $this->last_name;
    }


}
