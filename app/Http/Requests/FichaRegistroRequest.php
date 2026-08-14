<?php

namespace App\Http\Requests;

use App\Rules\Ruc;
use Illuminate\Foundation\Http\FormRequest;

class FichaRegistroRequest extends FormRequest
{
    /**
     * Autorizar la petición
     */
    public function authorize(): bool
    {
        return true;
        // O si quieres ser más estricto:
        // return auth()->check();
    }

    /**
     * Reglas de validación
     */
    public function rules(): array
    {
        return [
            'ciclo' => 'required|integer|min:1|max:10',
            'semestre_id' => 'required|exists:semestres,id',
            'razon_social_id' => 'required|exists:razones_sociales,id',
            'ruc' => ['required', new Ruc],
            'correo_empresa' => 'required|email',
            'nombre_empresa' => 'required|string|max:255',
            'nombre_gerente' => 'required|string|max:255',
            'nombre_jefe_rrhh' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',

            'telefono_fijo' => [
                'required',
                'string',
                'max:10',
                'regex:/^044-\d{6}$/'
            ],

            'telefono_movil' => [
                'required',
                'string',
                'max:9',
                'regex:/^9\d{8}$/'
            ],

            'departamento' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'distrito' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_termino' => 'required|date|after:fecha_inicio',
            'descripcion' => 'required|string',
            'area_practicas' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'nombre_jefe_directo' => 'required|string|max:255',
            'telefono_jefe_directo' => [
                'required',
                'string',
                'max:9',
                'regex:/^9\d{8}$/'
            ],
            'correo_jefe_directo' => 'required|email',
            'firma_practicante' => 'required|string',
            'horarios' => 'required|array|min:1'
        ];
    }

    /**
     * Mensajes personalizados
     */
    public function messages(): array
    {
        return [
            'ruc.required' => 'Debe ingresar el RUC de la empresa.',

            'telefono_fijo.required' =>
                'Debe ingresar el teléfono fijo.',
            'telefono_fijo.regex' =>
                'El teléfono fijo debe tener el formato 044-123456.',
            'telefono_fijo.max' =>
                'El teléfono fijo no debe exceder los 10 caracteres.',

            'telefono_movil.required' =>
                'Debe ingresar el teléfono móvil.',
            'telefono_movil.regex' =>
                'El teléfono móvil debe iniciar con 9 y tener 9 dígitos.',
            'telefono_movil.max' =>
                'El teléfono móvil debe tener exactamente 9 dígitos.',
            'telefono_jefe_directo.regex' =>
                'El teléfono móvil debe iniciar con 9 ytener exactamente 9 dígitos',
            'telefono_jefe_directo.max' =>
                'El teléfono móvil debe tener exactamente 9 dígitos'
        ];
    }
}
