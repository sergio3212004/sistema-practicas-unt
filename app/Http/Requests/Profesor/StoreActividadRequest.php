<?php

namespace App\Http\Requests\Profesor;

use App\Models\Aula;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActividadRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (! $this->filled('semana_mode') && $this->filled('semana_id')) {
            $this->merge(['semana_mode' => 'existing']);
        }
    }

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
            'semana_mode' => ['required', Rule::in(['existing', 'new'])],
            'semana_id' => [
                'nullable',
                'required_if:semana_mode,existing',
                Rule::exists('semanas', 'id')->where('aula_id', $aula->getKey()),
            ],
            'nueva_semana_nombre' => ['nullable', 'string', 'max:255'],
            'tipo_actividad_id' => ['required', 'exists:tipos_actividad,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'fecha_inicio' => ['required', 'date', 'before_or_equal:fecha_limite'],
            'fecha_limite' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'semana_mode.required' => 'Indica cómo deseas organizar la tarea.',
            'semana_id.required_if' => 'Selecciona la semana en la que se organizará la tarea.',
            'semana_id.exists' => 'La semana seleccionada no pertenece a esta aula.',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha límite.',
            'fecha_limite.after_or_equal' => 'La fecha límite debe ser posterior o igual a la fecha de inicio.',
        ];
    }
}
