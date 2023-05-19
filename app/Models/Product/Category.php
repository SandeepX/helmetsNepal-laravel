<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['image_path'];

    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        $path = asset('/front/uploads/category');
        return $path . '/img-' . $this->image;
    }

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

    /**
     * @return BelongsTo
     */
    public function getParentCategory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function getChildCategory(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
