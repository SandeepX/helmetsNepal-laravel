<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = "product_images";

    protected $fillable = [
        'image',
        'product_id',
        'status',
    ];

    protected $appends = ['product_image'];

    public function getProductImageAttribute(): string
    {
        $path = asset('/front/uploads/product_image');
        return $path . '/img-' . $this->image;
    }
}
