<?php

namespace App\Http\Requests;

use App\Rules\ValidateCPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            //
            'name' => [
                'sometimes', 
                'string'
            ],
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                Rule::unique('users', 'email')->ignore($this->user()->id),
                'max:150'
            ],
            // COMENTEI ISSO PQ VAI TER UM ENDPOINT SEPARADO PRA ISSO
            //'password' => [
                //'sometimes', 
                //'string', 
                //'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            //],
            'cpf' => [
                'sometimes', 
                'string', 
                Rule::unique('users')->ignore($this->user()->id), 
                new ValidateCPF()
            ],
            // MUITO TRAMPO ATUALIZAR ISSO NO FRONT
            //'birthday' => [
                //'sometimes', 
                //'date'
            //],
            'image' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ]

        ];
    }

    public function messages(): array
    {
        return [
            // Name Messages
            'name.string' => 'The name must be a valid text string.',

            // Email Messages
            'email.string' => 'The email must be a valid text string.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'email.max' => 'The email address must not be longer than 150 characters.',

            // CPF Messages
            'cpf.string' => 'The CPF must be a valid text string.',
            'cpf.unique' => 'This CPF is already registered.',
            
            // Image Messages
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image must not be larger than 2MB.',
        ];
    }
}
