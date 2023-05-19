<?php

namespace App\Models\Order;

use App\Models\Customer\Customer;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnOrder extends Model
{
    use HasFactory;

    protected $table = "return_orders";
    protected $fillable = [
        'order_product_detail_id',
        'product_id',
        'customer_id',
        'return_order_date',
        'customer_name',
        'customer_phone',
        'customer_address',
        'product_price',
        'quantity',
        'terms_and_conditions',
        'note',
        'status',
    ];



    public function getProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getOrderProductDetail(): BelongsTo
    {
        return $this->belongsTo(OrderProductDetail::class, 'order_product_detail_id', 'id');
    }

    public function getCustomer()
    {
        return $this->belongsTo(Customer::class , 'customer_id','id');
    }
}
