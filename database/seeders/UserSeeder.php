<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRole::cases() as $roleName) {
            $credentials = config("seeding.users.{$roleName->value}");
            $this->ensureCredentialsAreValid($credentials, $roleName);

            $role = Rol::query()
                ->where('nombre', $roleName->value)
                ->firstOrFail();

            $user = User::query()->where('email', $credentials['email'])->first();

            if ($user === null && isset($credentials['legacy_email'])) {
                $user = User::query()
                    ->where('email', $credentials['legacy_email'])
                    ->where('rol_id', $role->id)
                    ->first();
            }

            $user ??= new User;
            $user->forceFill([
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'rol_id' => $role->id,
                'email_verified_at' => now(),
            ])->save();
        }
    }

    private function ensureCredentialsAreValid(mixed $credentials, UserRole $role): void
    {
        if (! is_array($credentials)) {
            throw new RuntimeException("No se configuraron credenciales demo para el rol {$role->value}.");
        }

        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException("El correo demo para el rol {$role->value} no es válido.");
        }

        $hasRequiredComplexity = is_string($password)
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/\d/', $password)
            && preg_match('/[^A-Za-z0-9]/', $password);

        if (! $hasRequiredComplexity || mb_strlen($password) < 12) {
            throw new RuntimeException(
                "La contraseña demo para el rol {$role->value} debe tener al menos 12 caracteres, mayúscula, minúscula, número y símbolo.",
            );
        }
    }
}
