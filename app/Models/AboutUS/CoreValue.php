<?php

namespace App\Models\AboutUS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CoreValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "core_values";
    protected $fillable = [
        'title',
        'description',
        'png_image',
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
        $path = asset('/front/uploads/coreValue');
        return $path . '/img-' . $this->png_image;
    }

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
}
