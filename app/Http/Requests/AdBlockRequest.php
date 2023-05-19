<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class AdBlockRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'sub_title' => "string", 'description' => "string", 'link' => "string"])]
    public function rules(): array
    {
        {
            return [
                'title' => 'required|string',
                'sub_title' => 'required|string',
                'description' => 'required|string',
                'link' => 'string',
            ];
        }
    }

    #[ArrayShape(['title.required' => "string", 'description.required' => "string"])] public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'description.required' => 'description required',
        ];
    }
}
