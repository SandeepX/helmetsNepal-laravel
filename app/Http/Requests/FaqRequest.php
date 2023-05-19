<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class FaqRequest extends FormRequest
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
    #[ArrayShape(['question' => "string", 'answer' => "string", 'faq_category_id' => "string"])]
    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'answer' => 'required|string',
            'faq_category_id' => 'required',
        ];
    }

    #[ArrayShape(['question.required' => "string", 'answer.required' => "string", 'faq_category_id.required' => "string"])]
    public function messages(): array
    {
        return [
            'question.required' => 'Question required',
            'answer.required' => 'Answer required',
            'faq_category_id.required' => 'Faq Category required',
        ];
    }
}
