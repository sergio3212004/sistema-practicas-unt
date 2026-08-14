<?php

namespace App\Http\Requests\Profesor;

use Illuminate\Foundation\Http\FormRequest;

class GradeEntregaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('grade', $this->route('entrega')) === true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'nota' => ['required', 'numeric', 'min:0', 'max:20'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ];
    }
}
