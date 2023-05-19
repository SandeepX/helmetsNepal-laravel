<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerLog extends Model
{
    use HasFactory;
    protected $table = "customer_logs";
    protected $fillable = [
        'category_id_array',
        'customer_id'
    ];
}
