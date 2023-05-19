<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "users";
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'last_login',
        'last_login_ipAddress',
        'user_type',
        'user_image',
        'status',
        'two_factor_code',
        'two_factor_expires_at',
        'otp_verify_status',
        'role_id',
        'password',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['image_path'];
    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        $path = asset('/admin/uploads/users');
        return $path . '/img-' . $this->user_image;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id ?? 1;
            $model->updated_by = Auth::user()->id ?? 1;
        });

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id ?? 1;
        });
    }
}
