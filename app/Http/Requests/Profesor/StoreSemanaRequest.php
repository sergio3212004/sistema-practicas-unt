<?php

namespace App\Http\Requests\Profesor;

use App\Models\Aula;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSemanaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage', $this->route('aula')) === true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        /** @var Aula $aula */
        $aula = $this->route('aula');

        return [
            'numero' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('semanas', 'numero')->where('aula_id', $aula->getKey()),
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
            'numero.unique' => 'Ya existe una semana con este número en esta aula.',
        ];
    }
}
