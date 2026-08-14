<?php

namespace App\Http\Requests\Profesor;

use App\Models\Aula;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActividadRequest extends FormRequest
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
            'semana_id' => [
                'required',
                Rule::exists('semanas', 'id')->where('aula_id', $aula->getKey()),
            ],
            'tipo_actividad_id' => ['required', 'exists:tipos_actividad,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'fecha_inicio' => ['required', 'date', 'before_or_equal:fecha_limite'],
            'fecha_limite' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }
}
