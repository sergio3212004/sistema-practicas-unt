<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Ruc implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(10|15|16|17|20)\d{9}$/', $value)) {
            $fail('El RUC ingresado no tiene una estructura válida.');
            return;
        }

    }
}
