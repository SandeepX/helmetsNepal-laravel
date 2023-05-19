<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class BannerRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'sub_title' => "string", 'description' => "string", 'link' => "string", 'banner_image' => "string[]"])]
    public function rules(): array
    {
        $rules = [
            'title' => 'nullable|string',
            'sub_title' => 'nullable|string',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
        ];
        if ($this->isMethod('put')) {
            $rules['banner_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['banner_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }
}
