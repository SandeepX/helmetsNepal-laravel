<?php

namespace App\Models\Product;

use App\Models\ProductAttribute\Color;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductColor extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "product_colors";
    protected $fillable = [
        'product_id',
        'color_id_1',
        'color_id_2',
        'color_gradient',
        'product_image_color',
        'quantity',
        'barcode',
    ];
    protected $appends = ['product_image_color_path'];

    public function getProductImageColorPathAttribute(): string
    {
        $path = asset('/front/uploads/productColor');
        return $path . '/img-' . $this->product_image_color;
    }

    public function getColorOne(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id_1', 'id');
    }

    public function getColorTwo(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id_2', 'id');
    }
}
