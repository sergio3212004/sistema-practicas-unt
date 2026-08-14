<?php

namespace App\Http\Requests\Empresa;

use Illuminate\Foundation\Http\FormRequest;

class StorePublicacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->empresa !== null;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:70'],
            'cargo' => ['required', 'string', 'max:50'],
            'descripcion' => ['required', 'string'],
            'estado' => ['required', 'in:Disponible,Cubierta'],
            'imagen' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
