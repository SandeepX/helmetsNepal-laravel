<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HomePageSection extends Model
{
    use HasFactory;

    protected $table = "home_page_sections";
    protected $fillable = [
        'name',
        'position',
        'status',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();
        static::updating(static function ($model) {
            $model->updated_by = Auth::user()->id;
        });
    }
}
