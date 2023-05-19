<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "team";
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'designation_id',
        'is_featured',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $appends = ['image_path', 'designation_name'];

    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        $path = asset('/front/uploads/team');
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

    public function getDesignationNameAttribute(): string
    {
        return $this->getDesignation?->name ?? "";
    }

    public function getDesignation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
