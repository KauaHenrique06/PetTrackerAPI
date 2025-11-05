<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePetDiseaseRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',

            'diagnosis_date' => 'sometimes|required|date',

            'is_chronic' => 'sometimes|required|boolean',

            'clinical_notes' => 'nullable|string',

            'diagnosis_status' => [
                'sometimes',
                'required',
                'string',
                Rule::in(['suspected', 'confirmed', 'resolved', 'monitoring']),
            ],

            'resolved_date' => [
                'nullable',
                'date',
                'after_or_equal:diagnosis_date',

                Rule::prohibitedIf($this->is_chronic == true),

                Rule::requiredIf($this->diagnosis_status === 'resolved'),
            ],
        ];
    }
}
