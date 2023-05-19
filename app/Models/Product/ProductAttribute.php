<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = "product_attributes";

    protected $fillable = [
        'product_id',
        'product_attributes_one',
        'product_attributes_one_type',
        'product_attributes_one_value',
        'product_attributes_two',
        'product_attributes_two_type',
        'product_attributes_two_value',
        'product_attributes_three',
        'product_attributes_three_type',
        'product_attributes_three_value',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    protected $appends = ['product_attribute_image_path'];

    public function getProductAttributeImagePathAttribute(): string
    {
        return asset('/front/uploads/product_attribute/');
    }
}
