<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";
    protected $fillable = [
        'customer_id',
        'cart_number',
        'created_on',
        'total_price',
        'note',
    ];

    public function getCartItem(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'cart_id', 'id');
    }


}
