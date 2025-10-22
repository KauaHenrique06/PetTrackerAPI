<?php

namespace App\Http\Requests;

use App\Rules\ValidateCPF;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            
            'name' => [
                'required', 
                'string'
            ],
            'email' => [
                'required', 
                'string', 
                'email', 
                'unique:users,email', 
                'max:150'
            ],
            'password' => [
                'required', 
                'string', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'cpf' => [
                'required', 
                'string', 
                'unique:users,cpf', 
                new ValidateCPF()
            ],
            'birthday' => [
                'required', 
                'date'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ]

        ];
    }

    /**
     * Messages in case of validation errors
     */
    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required!',
            'string' => 'The :attribute field value must be a string!',
            'email.email' => 'The email value must be an valid email format!',
            'unique' => 'The :attribute must be unique, this already in use!',
            'password.regex' => 'The password must have 8 characters and include: a capital letter, a lowercase letter, a number and a special character',
            'birthday.date' => 'Birthday must be a date',
            'image' => 'The :attribute must be an image file.'
        ];
    } 

}
