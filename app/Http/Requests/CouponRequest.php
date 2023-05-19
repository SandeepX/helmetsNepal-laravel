<?php

namespace App\Http\Requests;

use App\Models\Order\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class CouponRequest extends FormRequest
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

    #[ArrayShape([
        'campaign_name' => "array",
        'campaign_code' => "array",
        'coupon_type' => "string",
        'coupon_value' => "string",
        'min_amount' => "string",
        'max_amount' => "string",
        'starting_date' => "string",
        'expiry_date' => "string",
        'campaign_image' => "string[]",
        'coupon_for' => "string",
        'coupon_apply_on' => "integer",
    ])]
    public function rules(): array
    {
        $rules = [
            'campaign_name' => ['required', 'string',
                Rule::unique('coupons')->ignore($this->coupon),
            ],
            'campaign_code' => ['required', 'string',
                Rule::unique('coupons')->ignore($this->coupon),
            ],
            'coupon_type' => 'required',
            'coupon_value' => 'required|numeric',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric|gt:min_amount',
            'expiry_date' => 'required|date|after:starting_date',
            'coupon_for' => ['required',Rule::in(Coupon::COUPON_FOR)],
        ];

        if($this->coupon_for == 'category'){
            $rules['coupon_apply_on'] = ['required_if:coupon_for,category','exists:categories,id'];
        }
        if($this->coupon_for == 'product'){
            $rules['coupon_apply_on'] = ['required_if:coupon_for,product','exists:products,id'];
        }
        if($this->coupon_for == 'brand'){
            $rules['coupon_apply_on'] = ['required_if:coupon_for,brand','exists:brands,id'];
        }
        if($this->coupon_for == 'all'){
            $rules['coupon_apply_on'] = ['nullable'];
        }

        if ($this->isMethod('put')) {
            $rules['campaign_image'] = ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
            $rules['starting_date'] = 'required|date';
        } else {
            $rules['starting_date'] = 'required|date|after_or_equal:today';
            $rules['campaign_image'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5048'];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'campaign_name.required' => 'Campaign Name required',
            'campaign_name.unique' => 'Campaign Name  must be unique',
            'campaign_code.required' => 'Campaign code required',
            'campaign_code.unique' => 'Campaign code  must be unique',
            'coupon_apply_on.required_if' => 'Please select '.$this->coupon_for. ' to apply coupon',
        ];
    }
}
