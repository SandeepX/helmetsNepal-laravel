<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'about_us_title' => 'required|string',
            'about_us_sub_title' => 'required|string',
            'about_us_description' => 'required|string',

            'core_value_title' => 'required|string',
            'core_value_sub_title' => 'required|string',
            'core_value_description' => 'required|string',

            'who_we_are_title' => 'required|string',
            'who_we_are_sub_title' => 'required|string',
            'who_we_are_description' => 'required|string',
            'who_we_are_youtube' => 'required|string',

            'slogan_title' => 'required|string',
            'slogan_sub_title' => 'required|string',
            'slogan_description' => 'required|string',

            'slogan_title_1' => 'required|string',
            'slogan_description_1' => 'required|string',
            'slogan_title_2' => 'required|string',
            'slogan_description_2' => 'required|string',

            'team_title' => 'required|string',
            'team_description' => 'required|string',

            'career_title' => 'required|string',
            'career_sub_title' => 'required|string',

            'testimonial_title' => 'required|string',
            'testimonial_sub_title' => 'required|string',
            'testimonial_description' => 'required|string',

            'rider_story_title' => 'required|string',
            'rider_story_sub_title' => 'required|string',
            'rider_story_description' => 'required|string',

            'showroom_title' => 'required|string',
            'showroom_description' => 'required|string',

            'brand_title' => 'required|string',
            'brand_description' => 'required|string',

            'newsletter_title' => 'required|string',
            'newsletter_description' => 'required|string',

            'blog_title' => 'required|string',
            'blog_sub_title' => 'required|string',
            'blog_description' => 'required|string',
            'career_image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'],
            'who_we_are_image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'],
            'rider_story_image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'],
        ];
        return $rules;
    }
}
