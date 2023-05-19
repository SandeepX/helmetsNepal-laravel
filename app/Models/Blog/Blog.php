<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "blogs";
    protected $fillable = [
        'title',
        'blog_image',
        'description',
        'blog_created_by',
        'blog_creator_image',
        'blog_publish_date',
        'blog_read_time',
        'blog_category_id',
        'status',
        'is_featured',
        'created_by',
        'updated_by',
    ];
    protected $appends = ['blog_image_path', 'blog_creator_image_path'];

    /**
     * @return string
     */
    public function getBlogImagePathAttribute(): string
    {
        $path = asset('/front/uploads/blog');
        return $path . '/img-' . $this->blog_image;
    }

    /**
     * @return string
     */
    public function getBlogCreatorImagePathAttribute(): string
    {
        $path = asset('/front/uploads/blog');
        return $path . '/img-' . $this->blog_creator_image;
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

    public function getBlogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }
}
