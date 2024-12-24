<?php

namespace App\Http\Requests\User;

use App\Traits\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    use ValidationResponse;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string|max:100',
            'last_name' => 'string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'min:8',
                'max:32',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#%^&*_\-])(?=.*[0-9])(?=.*[!@#%^&*_\-])/'
            ],
        ];
    }

    /**
     * Custom messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "regex" => "Password should be alphanumeric and contain special character."
        ];
    }
}
