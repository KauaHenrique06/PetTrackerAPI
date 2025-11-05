<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePetDiseaseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'pet_id' => 'required|exists:pets,id',
            'name' => 'required|string|max:255',
            'diagnosis_date' => 'required|date',
            'is_chronic' => 'required|boolean',

            'clinical_notes' => 'nullable|string',

            'diagnosis_status' => [
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


    protected function prepareForValidation(): void
    {
        if ($this->is_chronic == true || $this->is_chronic == 'true' || $this->is_chronic == 1) {
            $this->merge([
                'resolved_date' => null,
            ]);
        }
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'resolved_date.prohibited' => 'Doenças crônicas (is_chronic) não podem ter uma data de resolução.',
            'resolved_date.required' => 'A data de resolução é obrigatória pois o status é "resolvido".',
        ];
    }
}
