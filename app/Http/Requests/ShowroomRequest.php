<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ShowroomRequest extends FormRequest
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
    #[ArrayShape(['name' => "string", 'address' => "string", 'email' => "string", 'contact_no' => "string", 'contact_person' => "string", 'showroom_image' => "string[]"])]
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string',
            'contact_no' => 'required|string',
            'contact_person' => 'required|string',
        ];
        if ($this->isMethod('put')) {
            $rules['showroom_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        } else {
            $rules['showroom_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name required',
            'address.required' => 'Address required',
            'email.required' => 'Email required',
            'contact_no.required' => 'Contact no required',
            'contact_person.required' => 'Contact Person required',
        ];
    }
}
