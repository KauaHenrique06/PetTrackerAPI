<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
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
                'sometimes', 
                'string', 
                'max:50'
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
            ],
            'specie' => [
                'sometimes', 
                'string'
            ],
            'color' => [
                'sometimes', 
                'string'
            ]

        ];
    }
}
