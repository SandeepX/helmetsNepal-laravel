<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustom extends Model
{
    use HasFactory;

    protected $table = "product_customs";
    protected $fillable = [
        'product_id',
        'product_custom_attributes',
        'product_custom_attribute_value',
    ];
}
