<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PageBanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "page_banners";
    protected $fillable = [
        'page_name',
        'page_title',
        'page_sub_title',
        'page_title_description',
        'page_image',
        'created_by',
        'updated_by',
    ];


    protected $appends = ['page_image_path'];

    public static function boot()
    {
        parent::boot();
        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }

    /**
     * @return string
     */
    public function getPageImagePathAttribute(): string
    {
        $path = asset('/front/uploads/pageBanner');
        return $path . '/img-' . $this->page_image;
    }
}
