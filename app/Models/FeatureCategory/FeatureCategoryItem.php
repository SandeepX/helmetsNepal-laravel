<?php

namespace App\Models\FeatureCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FeatureCategoryItem extends Model
{
    use HasFactory;

    protected $table = "feature_category_items";
    protected $fillable = [
        'product_id',
        'feature_category_id',
        'feature_category_image',
        'created_by',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id;
        });

    }
}
