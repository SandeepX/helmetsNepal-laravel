<?php

namespace App\Models\AboutUS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Showroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "showrooms";
    protected $fillable = [
        'name',
        'address',
        'google_map_link',
        'youtube_link',
        'email',
        'contact_no',
        'contact_person',
        'showroom_image',
        'is_feature',
        'show_in_contactUs',
        'status',
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
        $path = asset('/front/uploads/showroom');
        return $path . '/img-' . $this->showroom_image;
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
