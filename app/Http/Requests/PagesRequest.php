<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class PagesRequest extends FormRequest
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
    #[ArrayShape(['title' => "array", 'details' => "string"])]
    public function rules(): array
    {
        return [
            'title' => ['required', 'string',
                Rule::unique('pages')->ignore($this->page),
            ],
            'details' => 'required',
        ];
    }

    #[ArrayShape(['title.required' => "string", 'title.unique' => "string", 'details.required' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'title.unique' => 'Title must be unique',
            'details.required' => 'Page Details required',
        ];
    }
}
