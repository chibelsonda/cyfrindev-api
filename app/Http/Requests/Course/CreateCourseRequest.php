<?php

namespace App\Http\Requests\Course;

use App\Traits\ValidationResponse;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
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
            'title' => 'required|string|unique:courses,title',
            'description' => 'required|string',
        ];
    }
}
