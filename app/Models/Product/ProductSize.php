<?php

namespace App\Models\Product;

use App\Models\ProductAttribute\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSize extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "product_sizes";
    protected $fillable = [
        'product_id',
        'size_id',
    ];

    public function getSize(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
}
