<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CompanyDetailRequest extends FormRequest
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
   public function rules(): array
    {
        {
            return [
                'address' => 'required|string',
                'email' => 'required|string',
                'contact_no' => 'required|string',
                'contact_person' => 'required|string',
                'google_map_link' => 'required|string',
                'facebook_link' => 'nullable|url',
                'instagram_link' => 'nullable|url',
                'twitter_link' => 'nullable|url',
                'youtube_link' => 'nullable|url',
                'frontend_link' => 'nullable|url',
            ];
        }
    }


    #[ArrayShape(['address.required' => "string", 'email.required' => "string", 'contact_no.required' => "string", 'contact_person.required' => "string", 'google_map_link.required' => "string"])]
    public function messages(): array
    {
        return [
            'address.required' => 'Address required',
            'email.required' => 'Email required',
            'contact_no.required' => 'Contact no required',
            'contact_person.required' => 'Contact Person required',
            'google_map_link.required' => 'Google map Link required',
        ];
    }
}
