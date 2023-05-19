<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SlidingContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sliding_contents";
    protected $fillable = [
        'type',
        'title',
        'sub_title',
        'youtube_link',
        'image',
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
        $path = asset('/front/uploads/sliding_content');
        return $path . '/img-' . $this->image;
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
