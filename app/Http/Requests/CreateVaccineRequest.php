<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVaccineRequest extends FormRequest
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
            'disease_name' => 'required|string|max:255',
            'target_species' => 'required|string|max:255',
            'doses' => 'required|integer|min:1',
            'duration' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'disease_name.required' => 'The disease name field is required.',
            'disease_name.string' => 'The disease name must be a string.',
            'disease_name.max' => 'The disease name may not be greater than 255 characters.',

            'target_species.required' => 'The target species field is required.',
            'target_species.string' => 'The target species must be a string.',
            'target_species.max' => 'The target species may not be greater than 255 characters.',

            'doses.required' => 'The doses field is required.',
            'doses.integer' => 'The doses must be an integer.',
            'doses.min' => 'The doses must be at least 1.',

            'duration.required' => 'The duration field is required.',
            'duration.integer' => 'The duration must be an integer.',
            'duration.min' => 'The duration must be at least 0.',
        ];
    }
}
