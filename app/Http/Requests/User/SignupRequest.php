<?php

namespace App\Http\Requests\User;

use App\Trait\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    use ValidationTrait;
    
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
            "email" => "required|email|unique:users,email",
            "password" => [
                "required",
                "min:8",
                "max:32",
                "regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#%^&*_\-])(?=.*[0-9])(?=.*[!@#%^&*_\-])/"
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
            "regex" => "Password should be alphanumeric and special characters."
        ];
    }
}
