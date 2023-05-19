<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = "cart_products";
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_custom_attributes',
        'product_custom_attribute_value',
        'product_color_id',
        'product_size_id',
        'product_color',
        'product_size',
        'product_price',
        'quantity',
        'note',
    ];
}
