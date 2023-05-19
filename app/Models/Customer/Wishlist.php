<?php

namespace App\Models\Customer;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = "wishlists";
    protected $fillable = [
        'product_id',
        'customer_id'
    ];

    public function getProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
