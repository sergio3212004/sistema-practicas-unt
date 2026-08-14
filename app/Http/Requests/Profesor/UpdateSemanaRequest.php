<?php

namespace App\Http\Requests\Profesor;

use App\Models\Semana;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSemanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage', $this->route('semana')) === true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        /** @var Semana $semana */
        $semana = $this->route('semana');

        return [
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('semanas', 'numero')
                    ->where('aula_id', $semana->aula_id)
                    ->ignore($semana),
            ],
            'nombre' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'numero.unique' => 'Ya existe otra semana con este número en esta aula.',
        ];
    }
}
