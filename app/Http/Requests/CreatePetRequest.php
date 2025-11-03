<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use PetSex;

class CreatePetRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'specie_id' => ['required', 'integer', Rule::exists('species', 'id')],
            'size' => ['required', Rule::in(['small', 'medium', 'large'])],
            'status' => ['required', Rule::in(['safe', 'deceased', 'lost'])],
            'breed' => ['required', 'string', 'max:100'],
            'weight' => ['required', 'numeric', 'min:0'], 
            'is_neutred' => ['required', 'boolean'], 
            'birthday' => ['required', 'date', 'before_or_equal:today'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'color' => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'sex.required' => 'The sex field is required.',
            'size.required' => 'The size field is required.',
            'status.required' => 'The status field is required.',
            'breed.required' => 'The breed field is required.',
            'weight.required' => 'The weight field is required.',
            'is_neutred.required' => 'Please specify if the pet is neutered.',
            'birthday.required' => 'The birthday field is required.',
            'color.required' => 'The color field is required.',

            'name.string' => 'The name field must be a string.',
            'breed.string' => 'The breed field must be a string.',
            'color.string' => 'The color field must be a string.',

            'name.max' => 'The name may not be greater than 255 characters.',
            'breed.max' => 'The breed may not be greater than 100 characters.',
            'color.max' => 'The color may not be greater than 50 characters.',

            'sex.in' => 'The selected sex is invalid. (Values: male, female)',
            'size.in' => 'The selected size is invalid. (Values: small, medium, large)',
            'status.in' => 'The selected status is invalid. (Values: safe, deceased, lost)',

            'weight.numeric' => 'The weight must be a numeric value.',
            'weight.min' => 'The weight cannot be a negative value.',

            'is_neutred.boolean' => 'The "neutered" field must be true or false (0 or 1).',

            'birthday.date' => 'The birthday must be a valid date.',
            'birthday.before_or_equal' => 'The birthday cannot be a future date.',

            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max' => 'The image may not be greater than 2048 kilobytes (2 MB).',

            'specie_id.required' => 'The species field is required.',
            'specie_id.integer' => 'The species ID must be a number.',
            'specie_id.exists' => 'The selected species is invalid.',
        ];
    }
}
