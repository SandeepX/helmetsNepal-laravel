<?php

namespace App\Models\Faq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class FaqCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "faq_categories";
    protected $fillable = [
        'name',
        'icons',
        'status',
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

    public function getFaq(): HasMany
    {
        return $this->hasMany(Faq::class, 'faq_category_id', 'id');
    }
}
