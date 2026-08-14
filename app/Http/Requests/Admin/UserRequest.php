<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    protected function baseRules(?User $user = null): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'rol_id' => [
                'required',
                Rule::exists('roles', 'id')->where(
                    fn ($query) => $query->whereIn('nombre', UserRole::values()),
                ),
            ],
        ];
    }

    /**
     * @return array<string, array<mixed>>
     */
    protected function profileRules(?User $user = null): array
    {
        return match ($this->selectedRole()) {
            UserRole::ADMINISTRADOR => [
                'nombres_admin' => ['required', 'string', 'max:255'],
                'apellido_paterno_admin' => ['required', 'string', 'max:255'],
                'apellido_materno_admin' => ['required', 'string', 'max:255'],
                'telefono_admin' => ['nullable', 'string', 'max:20'],
            ],
            UserRole::ALUMNO => [
                'codigo_matricula_alumno' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('alumnos', 'codigo_matricula')->ignore($user?->alumno),
                ],
                'nombres_alumno' => ['required', 'string', 'max:255'],
                'apellido_paterno_alumno' => ['required', 'string', 'max:255'],
                'apellido_materno_alumno' => ['required', 'string', 'max:255'],
                'telefono_alumno' => ['nullable', 'string', 'max:20'],
            ],
            UserRole::EMPRESA => [
                'ruc' => [
                    'required',
                    'string',
                    'size:11',
                    Rule::unique('empresas', 'ruc')->ignore($user?->empresa),
                ],
                'nombre' => ['required', 'string', 'max:255'],
                'razon_social_id' => ['required', 'exists:razones_sociales,id'],
                'telefono' => ['nullable', 'string', 'max:9'],
                'departamento' => ['required', 'string', 'max:50'],
                'provincia' => ['required', 'string', 'max:50'],
                'distrito' => ['required', 'string', 'max:50'],
                'direccion' => ['required', 'string', 'max:255'],
            ],
            UserRole::PROFESOR => [
                'codigo_profesor' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('profesores', 'codigo_profesor')->ignore($user?->profesor),
                ],
                'nombres_profesor' => ['required', 'string', 'max:255'],
                'apellido_paterno_profesor' => ['required', 'string', 'max:255'],
                'apellido_materno_profesor' => ['required', 'string', 'max:255'],
                'telefono_profesor' => ['nullable', 'string', 'max:20'],
            ],
            null => [],
        };
    }

    protected function routeUser(): ?User
    {
        $user = $this->route('usuario');

        if ($user instanceof User) {
            return $user->loadMissing('administrador', 'alumno', 'empresa', 'profesor');
        }

        return User::query()
            ->with('administrador', 'alumno', 'empresa', 'profesor')
            ->find($user);
    }

    private function selectedRole(): ?UserRole
    {
        $roleName = Rol::query()->whereKey($this->input('rol_id'))->value('nombre');

        return is_string($roleName) ? UserRole::tryFrom($roleName) : null;
    }
}
