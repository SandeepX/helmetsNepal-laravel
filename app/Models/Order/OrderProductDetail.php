<?php

namespace App\Models\Order;

use App\Models\Customer\Customer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductDetail extends Model
{
    use HasFactory;

    protected $table = "order_product_details";
    protected $fillable = [
        'order_id',
        'product_id',
        'product_code',
        'product_price',
        'quantity',
        'total',
        'product_color_id',
        'product_size_id',
        'product_custom_attributes',
        'product_custom_attribute_value',
        'product_color',
        'product_size',
        'status',
    ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'product_id' , 'id');
    }

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id' , 'id');
    }

}
