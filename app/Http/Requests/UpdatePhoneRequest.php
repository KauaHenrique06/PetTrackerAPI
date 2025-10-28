<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phones' => ['required', 'array'],
            'phones.*.id' => ['required', 'integer', 'exists:phones,id,user_id' . Auth::id()],
            'phones.*.number' => ['required', 'string', 'min:10', 'max:20']
        ];
    }
}
