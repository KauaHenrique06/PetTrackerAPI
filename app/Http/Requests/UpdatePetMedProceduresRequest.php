<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePetMedProceduresRequest extends FormRequest
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
            
            'type' => ['sometimes', 'string', Rule::in(['veterinary consultation', 'exams', 'sterilization', 'surgery'])],
            'description' => ['sometimes', 'nullable', 'string'],
            'start_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'end_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date']

        ];
    }
}
