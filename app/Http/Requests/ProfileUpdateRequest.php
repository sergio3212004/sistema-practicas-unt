<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'telefono' => ['nullable', 'string', 'max:15'], // Aumentado a 15 para empresas
            'cv_link' => ['nullable', 'url', 'max:500'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'departamento' => ['nullable', 'string', 'max:50'],
            'provincia' => ['nullable', 'string', 'max:50'],
            'distrito' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.max' => 'El teléfono no puede tener más de 9 caracteres.',
            'cv_link.url' => 'El enlace del CV debe ser una URL válida.',
        ];
    }
}
