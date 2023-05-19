<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class FaqCategoryRequest extends FormRequest
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
    #[ArrayShape(['name' => "array", 'icons' => "string"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string',
                Rule::unique('faq_categories')->ignore($this->faq_category),
            ],
            'icons' => 'required',
        ];
    }

    #[ArrayShape(['name.required' => "string", 'name.unique' => "string", 'icons.required' => "string"])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name required',
            'name.unique' => 'Name must be unique',
            'icons.required' => 'Icons required',
        ];
    }
}
