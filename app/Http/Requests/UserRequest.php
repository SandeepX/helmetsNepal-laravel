<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UserRequest extends FormRequest
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
    #[ArrayShape(['username' => "string", 'email' => "string", 'phone' => "string", 'name' => "string"])]
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', Rule::unique('users')->ignore($this->user),],
            'email' => ['required', 'string','email', Rule::unique('users')->ignore($this->user),],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($this->user),],
            'name' => 'required|string',
        ];
    }

    #[ArrayShape(['username.required' => "string", 'username.unique' => "string", 'email.required' => "string", 'email.unique' => "string", 'phone.required' => "string", 'phone.unique' => "string", 'name.required' => "string"])]
    public function messages(): array
    {
        return [
            'username.required' => 'Username required',
            'username.unique' => 'Username must be unique',
            'email.required' => 'Email required',
            'email.unique' => 'Email must be unique',
            'phone.required' => 'Phone no required',
            'phone.unique' => 'Phone no must be unique',
            'name.required' => 'Name required',

        ];
    }
}
