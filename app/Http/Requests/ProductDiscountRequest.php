<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductDiscountRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'discount_amount' => 'required|numeric',
            'discount_percent' => 'required|numeric|between:0,100',
            'discount_start_date' => 'required|date',
            'discount_end_date' => 'required|date|after:discount_start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'discount_amount.required' => 'Discount Amount Required',
            'discount_percent.required' => 'Discount Amount  required',
            'discount_start_date.required' => 'Discount start date required',
            'discount_end_date.required' => 'Discount end date required',
        ];
    }
}
