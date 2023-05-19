<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CareerRequest extends FormRequest
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

    #[ArrayShape(['title' => "string", 'description' => "string", 'department_id' => "string"])]
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'department_id' => 'required',
        ];
    }


    #[ArrayShape(['title.required' => "string", 'description.required' => "string", 'department_id.required' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'description.required' => 'Description required',
            'department_id.required' => 'Department required',
        ];
    }
}
