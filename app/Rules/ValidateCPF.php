<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCPF implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $value );

        if (strlen($cpf) != 11) {
            $fail('O campo :attribute não é um CPF válido.');
            return;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O campo :attribute não é um CPF válido.');
            return;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail('O campo :attribute não é um CPF válido.');
                return;
            }
        }
    }
}
