<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetVaccineRequest extends FormRequest
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
            'application_date' => 'required|date_format:Y-m-d',
            'next_dose_date' => 'nullable|date_format:Y-m-d|after_or_equal:application_date',
            'pet_id' => 'required|exists:pets,id',
            'vaccine_id' => 'required|exists:vaccines,id',
        ];
    }
}
