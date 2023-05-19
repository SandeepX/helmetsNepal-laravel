<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerResetPassword extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "customer_reset_passwords";
    protected $fillable = [
        'email',
        'verification_token',
        'customer_id',
    ];
}
