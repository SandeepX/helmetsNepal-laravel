<?php

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;

    protected $table = "applications";
    protected $fillable = [
        'name',
        'email',
        'cv_file',
        'career_id',
    ];

    /**
     * @return BelongsTo
     */
    public function getCareer(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id', 'id');
    }
}
