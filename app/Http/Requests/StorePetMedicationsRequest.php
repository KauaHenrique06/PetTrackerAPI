<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePetMedicationsRequest extends FormRequest
{
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
            'start_date' => 'required|date',
            'type' => 'required|string',
            'treatment_type' => ['required', 'string', Rule::in(['continuous', 'periodic', 'unique'])],

            'dosage_form' => 'required|string|max:255',
            'description' => 'nullable|string',

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
                Rule::requiredIf($this->treatment_type === 'periodic' || $this->treatment_type === 'unique'),
                Rule::prohibitedIf($this->treatment_type === 'continuous'),
            ],

            'dosing_interval' => [
                'nullable',
                'integer',
                'min:1',
                Rule::requiredIf($this->treatment_type === 'continuous' || $this->treatment_type === 'periodic'),
                Rule::prohibitedIf($this->type === 'unique'),
            ],

            'interval_unit' => [
                'nullable',
                'string',
                Rule::in(['hours', 'days', 'weeks', 'months']),
                'required_with:dosing_interval',
                Rule::prohibitedIf($this->treatment_type === 'unique'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->treatment_type === 'unique') {
            $this->merge([
                'dosing_interval' => null,
                'interval_unit' => null,
            ]);
        }

        if ($this->treatment_type === 'continuous' || $this->treatment_type === 'periodic') {
            if (empty($this->interval_unit) && !empty($this->dosing_interval)) {
                $this->merge([
                    'interval_unit' => 'hours',
                ]);
            }
        }
    }
}
