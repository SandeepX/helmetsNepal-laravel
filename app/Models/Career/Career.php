<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Career extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "careers";
    protected $fillable = [
        'title',
        'salary_details',
        'description',
        'department_id',
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

    public function getDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
