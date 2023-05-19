<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerVerifyEmails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "customer_verify_emails";
    protected $fillable = [
        'email',
        'token',
        'customer_id',
    ];
}
