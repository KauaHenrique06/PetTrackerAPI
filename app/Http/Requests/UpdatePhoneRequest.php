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
        // Garante que o usuário está logado
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $userId = $this->user()->getKey(); 

        return [
            'phones' => ['required', 'array'],
            'phones.*.id' => [
                'required',
                'integer', // Mantenha 'string' se o Zod/useEffect estiver enviando string
                'exists:phones,id,user_id,' . $userId 
            ],
            'phones.*.number' => ['required', 'string', 'min:10', 'max:20'],
        ];
    }
}