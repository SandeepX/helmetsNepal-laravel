<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class BrandRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'description' => "string", 'link' => "string", 'brand_image' => "string[]"])]
    public function rules(): array
    {

        $rules = [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
        ];
        if ($this->isMethod('put')) {
            $rules['brand_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['brand_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['title.required' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
        ];
    }
}
