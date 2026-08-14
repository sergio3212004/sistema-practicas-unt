<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserManagementService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $role = $this->roleFrom($data);

            $user = User::query()->create(Arr::only($data, [
                'email',
                'password',
                'rol_id',
            ]));

            $this->syncProfile($user, $role, $data);

            return $user->load('rol', $role->value);
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $role = $this->roleFrom($data);

            $user->update(Arr::only($data, ['email', 'rol_id']));

            $this->deleteOtherProfiles($user, $role);
            $this->syncProfile($user, $role, $data);

            return $user->refresh()->load('rol', $role->value);
        });
    }

    public function delete(User $user): void
    {
        DB::transaction(static fn () => $user->delete());
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function roleFrom(array $data): UserRole
    {
        $roleName = Rol::query()->whereKey($data['rol_id'])->value('nombre');

        return UserRole::from($roleName);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function syncProfile(User $user, UserRole $role, array $data): void
    {
        $payload = match ($role) {
            UserRole::ADMINISTRADOR => [
                'nombres' => $data['nombres_admin'],
                'apellido_paterno' => $data['apellido_paterno_admin'],
                'apellido_materno' => $data['apellido_materno_admin'],
                'telefono' => $data['telefono_admin'] ?? null,
            ],
            UserRole::ALUMNO => [
                'codigo_matricula' => $data['codigo_matricula_alumno'],
                'nombres' => $data['nombres_alumno'],
                'apellido_paterno' => $data['apellido_paterno_alumno'],
                'apellido_materno' => $data['apellido_materno_alumno'],
                'telefono' => $data['telefono_alumno'] ?? null,
            ],
            UserRole::EMPRESA => [
                'ruc' => $data['ruc'],
                'nombre' => $data['nombre'],
                'telefono' => $data['telefono'] ?? null,
                'razon_social_id' => $data['razon_social_id'],
                'departamento' => $data['departamento'],
                'provincia' => $data['provincia'],
                'distrito' => $data['distrito'],
                'direccion' => $data['direccion'],
                'aprobado' => true,
            ],
            UserRole::PROFESOR => [
                'codigo_profesor' => $data['codigo_profesor'],
                'nombres' => $data['nombres_profesor'],
                'apellido_paterno' => $data['apellido_paterno_profesor'],
                'apellido_materno' => $data['apellido_materno_profesor'],
                'telefono' => $data['telefono_profesor'] ?? null,
            ],
        };

        $user->{$role->value}()->updateOrCreate([], $payload);
    }

    private function deleteOtherProfiles(User $user, UserRole $selectedRole): void
    {
        foreach (UserRole::cases() as $role) {
            if ($role !== $selectedRole) {
                $user->{$role->value}()->delete();
            }
        }
    }
}
