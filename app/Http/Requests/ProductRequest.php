<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class ProductRequest extends FormRequest
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

        $rules = [
            'title' => ['required', 'string', Rule::unique('products')->ignore($this->product),],
            'product_code' => 'required|string',
            'main_category_id' => 'required',
            'product_price' => 'required|numeric',
            'details' => 'required|string|min:20',
        ];

        if ($this->isMethod('put')) {
            $rules['cover_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['cover_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'title.unique' => 'Title must be unique',
        ];
    }
}
