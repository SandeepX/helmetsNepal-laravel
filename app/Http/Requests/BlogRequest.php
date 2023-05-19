<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class BlogRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'title' => "string",
        'description' => "string",
        'blog_created_by' => "string",
        'blog_publish_date' => "string",
        'blog_read_time' => "string",
        'blog_category_id' => "string",
        'blog_creator_image' => "string[]",
        'blog_image' => "string[]"
    ])]
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'blog_created_by' => 'required|string',
            'blog_publish_date' => 'required|string',
            'blog_read_time' => 'required|string',
            'blog_category_id' => 'required',
        ];
        if ($this->isMethod('put')) {
            $rules['blog_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
            $rules['blog_creator_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['blog_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
            $rules['blog_creator_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'description.required' => 'Description required',
            'blog_category_id.required' => 'Blog Category required',
        ];
    }
}
