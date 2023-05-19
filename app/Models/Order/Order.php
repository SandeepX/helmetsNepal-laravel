<?php

namespace App\Models\Order;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $fillable = [
        'order_code',
        'order_date',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'payment_method_name',
        'payment_transaction_id',
        'delivery_status',
        'coupon_value',
        'coupon_code',
        'coupon_id',
        'deliveryCharge_id',
        'sub_total',
        'discount',
        'deliveryCharge_amount',
        'total'
    ];

    public function getOrderProductDetail()
    {
        return $this->hasMany(OrderProductDetail::class , 'order_id' ,'id');
    }

    public function getCustomer()
    {
        return $this->belongsTo(Customer::class , 'customer_id' ,'id');
    }
    public function getDeliveryCharge()
    {
        return $this->belongsTo(DeliveryCharge::class , 'deliveryCharge_id' ,'id');
    }
}
