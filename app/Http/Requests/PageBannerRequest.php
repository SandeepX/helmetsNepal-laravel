<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class PageBannerRequest extends FormRequest
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
    #[ArrayShape(['page_title' => "string", 'page_sub_title' => "string", 'page_title_description' => "string", 'page_image' => "string[]"])]
    public function rules(): array
    {
        $rules = [
            'page_title' => 'required|string',
            'page_sub_title' => 'required|string',
            'page_title_description' => 'required|string',
        ];
        if ($this->isMethod('put')) {
            $rules['page_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        } else {
            $rules['page_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'page_title.required' => 'Page Title required',
            'page_sub_title.required' => 'Page Sub Title required',
            'page_title_description.required' => 'Description required',
        ];
    }
}
