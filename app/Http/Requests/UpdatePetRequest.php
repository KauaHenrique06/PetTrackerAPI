<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            
            'name' => ['sometimes', 'string', 'max:255'],
            'sex' => ['sometimes', Rule::in(['male', 'female'])],
            'specie' => ['sometimes', Rule::in(['dog', 'cat', 'other'])],
            'size' => ['sometimes', Rule::in(['small', 'medium', 'large'])],
            'status' => ['sometimes', Rule::in(['safe', 'deceased', 'lost'])],
            'breed' => ['sometimes', 'string', 'max:100'],
            'weight' => ['sometimes', 'numeric', 'min:0'], 
            'is_neutred' => ['sometimes', 'boolean'], 
            'birthday' => ['sometimes', 'date', 'before_or_equal:today'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'color' => ['sometimes', 'string', 'max:50'],

        ];
    }
}
