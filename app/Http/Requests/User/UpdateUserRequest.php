<?php

namespace App\Http\Requests\User;

use App\Trait\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'preferred_name' => 'required|string|max:50',
            // 'birth_date' => 'required|date',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
            'street_1' => 'required|string',
            'street_2' => 'string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postal_code' => 'required|integer',
            'country' => 'required|string',
            'work_phone_number' => 'string|max:15',
            'mobile_phone_number' => 'string|max:15',
            'home_phone_number' => 'string|max:15',
            'work_email' => 'string|max:30',
            'personal_email' => 'string|max:30',
            'linkedin_link' => 'string',
            'facebook_link' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' 
        ];
    }
}
