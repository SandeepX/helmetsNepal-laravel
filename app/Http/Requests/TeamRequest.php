<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class TeamRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'description' => "string", 'designation_id' => "string", 'team_image' => "string[]"])]
    public function rules(): array
    {

        $rules = [
            'name' => 'required|string',
            'description' => 'required|string',
            'designation_id' => 'required',
        ];
        if ($this->isMethod('put')) {
            $rules['team_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['team_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['name.required' => "string", 'description.required' => "string", 'designation_id.required' => "string"])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name required',
            'description.required' => 'Description required',
            'designation_id.required' => 'Please select designation',
        ];
    }
}
