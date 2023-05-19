<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class DepartmentRequest extends FormRequest
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
    #[ArrayShape(['title' => "array", 'image' => "string[]"])]
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string',
                Rule::unique('departments')->ignore($this->department),
            ]
        ];
        if ($this->isMethod('put')) {
            $rules['image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        } else {
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['title.required' => "string", 'title.unique' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'title.unique' => 'Title must be unique',
        ];
    }
}
