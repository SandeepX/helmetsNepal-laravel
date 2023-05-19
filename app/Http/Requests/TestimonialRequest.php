<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class TestimonialRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'designation' => "string", 'description' => "string"])]
    public function rules(): array
    {

        $rules = [
            'name' => 'required|string',
            'designation' => 'required|string',
            'description' => 'required|string',
        ];
        if ($this->isMethod('put')) {
            $rules['testimonial_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        } else {
            $rules['testimonial_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg','max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['name.required' => "string", 'designation.required' => "string", 'description.required' => "string"])]
    public function messages(): array
    {
        return [
            'name.required' => 'Name required',
            'designation.required' => 'Designation required',
            'description.required' => 'Description required',
        ];
    }
}
