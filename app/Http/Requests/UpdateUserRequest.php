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
                'unique:users,email',
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
            'birthday' => [
                'sometimes', 
                'date'
            ],
            'image' => [
                'sometimes',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048'
            ]

        ];
    }
}
