<?php

namespace App\Models\AboutUS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AboutUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "about_us";
    protected $fillable = [

        'about_us_title',
        'about_us_sub_title',
        'about_us_description',

        'core_value_title',
        'core_value_sub_title',
        'core_value_description',

        'who_we_are_title',
        'who_we_are_sub_title',
        'who_we_are_description',
        'who_we_are_image',
        'who_we_are_youtube',

        'slogan_title',
        'slogan_sub_title',
        'slogan_description',

        'slogan_title_1',
        'slogan_description_1',
        'slogan_title_2',
        'slogan_description_2',

        'team_title',
        'team_description',

        'career_title',
        'career_sub_title',
        'career_image',

        'testimonial_title',
        'testimonial_sub_title',
        'testimonial_description',

        'rider_story_title',
        'rider_story_sub_title',
        'rider_story_description',
        'rider_story_image',

        'showroom_title',
        'showroom_description',

        'brand_title',
        'brand_description',

        'newsletter_title',
        'newsletter_description',

        'blog_title',
        'blog_sub_title',
        'blog_description',

        'contactUs_title',
        'contactUs_description',

        'contactUsGetInTouch_title',
        'contactUsGetInTouch_description',

        'flash_sale_title',
        'flash_sale_description',

        'created_by',
        'updated_by',
    ];
    protected $appends = ['career_image_path', 'who_we_are_image_path', 'rider_story_image_path'];

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
    public function getWhoWeAreImagePathAttribute(): string
    {
        $path = asset('/front/uploads/aboutUs');
        return $path . '/img-' . $this->who_we_are_image;
    }

    /**
     * @return string
     */
    public function getCareerImagePathAttribute(): string
    {
        $path = asset('/front/uploads/aboutUs');
        return $path . '/img-' . $this->career_image;
    }

    /**
     * @return string
     */
    public function getRiderStoryImagePathAttribute(): string
    {
        $path = asset('/front/uploads/aboutUs');
        return $path . '/img-' . $this->rider_story_image;
    }
}
