<?php

namespace App\Models\FeatureCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class FeatureCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "feature_categories";
    protected $fillable = [
        'name',
        'slug',
        'detail',
        'sale_start_date',
        'sale_end_date',
        'status',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(static function ($model) {
            $model->created_by = Auth::user()->id ?? 1;
            $model->updated_by = Auth::user()->id ?? 1;
        });

        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }
}
