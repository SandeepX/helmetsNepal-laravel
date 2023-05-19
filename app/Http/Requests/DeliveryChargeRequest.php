<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class DeliveryChargeRequest extends FormRequest
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

    #[ArrayShape(['delivery_charge_amount' => "string"])]
    public function rules(): array
    {
        return [
            'delivery_charge_amount' => 'required',
        ];
    }

    #[ArrayShape(['delivery_charge_amount.required' => "string"])]
    public function messages(): array
    {
        return [
            'delivery_charge_amount.required' => 'Delivery Charge Amount required',
        ];
    }
}
