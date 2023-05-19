<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class YoutubeTypeRequest extends FormRequest
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
    #[ArrayShape(['title' => "string", 'youtube_link' => "string"])]
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string',
            'youtube_link' => 'required|string',
        ];
        if ($this->isMethod('put')) {
            $rules['sliding_content_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        } else {
            $rules['sliding_content_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        }
        return $rules;
    }

    #[ArrayShape(['title.required' => "string", 'youtube_link.required' => "string"])]
    public function messages(): array
    {
        return [
            'title.required' => 'Title required',
            'youtube_link.required' => 'Youtube Link required',
        ];
    }
}
