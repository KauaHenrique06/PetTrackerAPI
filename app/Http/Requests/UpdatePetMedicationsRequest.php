<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePetMedicationsRequest extends FormRequest
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

            'type'           => ['sometimes', 'required', 'string'],
            'treatment_type' => ['sometimes', 'required', 'string', Rule::in(['continuous', 'periodic', 'unique'])],
            'dosage_form'    => ['sometimes', 'required', 'string'],
            'interval_unit'  => ['sometimes', 'required', 'string', Rule::in(['hours', 'days', 'weeks', 'months'])],

            'dosing_interval' => 'sometimes|required|integer|min:1',
            
            'start_date' => 'sometimes|required|date',
            
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',

            'description' => 'sometimes|nullable|string'
        ];
    }
}
