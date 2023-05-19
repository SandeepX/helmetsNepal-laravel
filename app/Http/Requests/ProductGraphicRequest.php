<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ProductGraphicRequest extends FormRequest
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
    #[ArrayShape(['name' => "string"])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string',
                Rule::unique('product_graphics')->ignore($this->productGraphic),
            ],
        ];
    }

    #[ArrayShape(['name.required' => "string", 'name.unique' => "string"])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name required',
            'name.unique' => 'Name must be unique',
        ];
    }
}
