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
            
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'cpf' => ['required', 'string', 'unique:users,cpf', new ValidateCPF()],
            'birthday' => ['required', 'date']

        ];
    }

}
