<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoggedInChangePasswordRequest extends FormRequest
{
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
            'old_password' => [
                'required', 
                'string', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'new_password' => [
                'required', 
                'string', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'new_password_confirmation' => [
                'required', 
                'string', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required!',
            'string' => 'The :attribute field value must be a string!',
            'new_password.regex' => 'The password must have 8 characters and include: a capital letter, a lowercase letter, a number and a special character',
            'new_password_confirmation.regex' => 'The password must have 8 characters and include: a capital letter, a lowercase letter, a number and a special character',
        ];
    } 
}
