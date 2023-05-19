<?php

namespace App\Models\Ad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AdBlock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ad_blocks";
    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'description',
        'link',
        'section',
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
        $path = asset('/front/uploads/adBlock');
        return $path . '/img-' . $this->image;
    }

    public static function boot()
    {
        parent::boot();
        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }
}
