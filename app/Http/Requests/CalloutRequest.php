<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class CalloutRequest extends FormRequest
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

    #[ArrayShape(['title' => "array", 'description' => "string", 'image' => "string[]"])]
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string',
                Rule::unique('callouts')->ignore($this->coreValue),
            ],
            'description' => 'required|string',
        ];
        if ($this->isMethod('put')) {
            $rules['image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['title.required' => "string", 'title.unique' => "string", 'description.required' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'title.unique' => 'Title must be unique',
            'description.required' => 'Description required',
        ];
    }
}
