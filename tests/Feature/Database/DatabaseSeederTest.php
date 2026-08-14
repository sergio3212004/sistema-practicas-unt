<?php

use App\Enums\UserRole;
use App\Models\Administrador;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Empresa;
use App\Models\Profesor;
use App\Models\RazonSocial;
use App\Models\Rol;
use App\Models\Semestre;
use App\Models\TipoActividad;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RolSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

test('database seeding creates complete demo accounts and can run repeatedly', function () {
    config()->set('seeding.demo_enabled', true);

    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(Rol::query()->count())->toBe(4)
        ->and(RazonSocial::query()->count())->toBe(6)
        ->and(TipoActividad::query()->count())->toBe(3)
        ->and(User::query()->count())->toBe(4)
        ->and(Administrador::query()->count())->toBe(1)
        ->and(Alumno::query()->count())->toBe(1)
        ->and(Profesor::query()->count())->toBe(1)
        ->and(Empresa::query()->count())->toBe(1)
        ->and(Semestre::query()->count())->toBe(1)
        ->and(Aula::query()->count())->toBe(1);

    foreach (UserRole::cases() as $role) {
        $credentials = config("seeding.users.{$role->value}");
        $user = User::query()->where('email', $credentials['email'])->firstOrFail();

        expect($user->hasRole($role))->toBeTrue()
            ->and(Hash::check($credentials['password'], $user->password))->toBeTrue()
            ->and($user->{$role->value})->not->toBeNull();
    }

    expect(Empresa::query()->firstOrFail()->aprobado)->toBeTrue()
        ->and(Alumno::query()->firstOrFail()->aula_id)->not->toBeNull();
});

test('demo passwords are distinct and meet a professional minimum', function () {
    $passwords = collect(UserRole::cases())
        ->map(fn (UserRole $role) => config("seeding.users.{$role->value}.password"));

    expect($passwords->unique()->count())->toBe(count(UserRole::cases()));

    $passwords->each(function (string $password): void {
        expect(mb_strlen($password))->toBeGreaterThanOrEqual(12)
            ->and($password)->toMatch('/[A-Z]/')
            ->and($password)->toMatch('/[a-z]/')
            ->and($password)->toMatch('/\d/')
            ->and($password)->toMatch('/[^A-Za-z0-9]/');
    });
});

test('reference catalogs remain available when demo data is disabled', function () {
    config()->set('seeding.demo_enabled', false);

    $this->seed(DatabaseSeeder::class);

    expect(Rol::query()->count())->toBe(4)
        ->and(RazonSocial::query()->count())->toBe(6)
        ->and(TipoActividad::query()->count())->toBe(3)
        ->and(User::query()->count())->toBe(0);
});

test('user seeding rejects weak configured passwords', function () {
    $this->seed(RolSeeder::class);
    config()->set('seeding.users.administrador.password', 'credencialsimple');

    expect(fn () => $this->seed(UserSeeder::class))
        ->toThrow(RuntimeException::class);
});

test('user seeding upgrades accounts created by the previous seeders', function () {
    $this->seed(RolSeeder::class);
    $adminRole = Rol::query()->where('nombre', UserRole::ADMINISTRADOR->value)->firstOrFail();
    $legacyEmail = config('seeding.users.administrador.legacy_email');
    $newEmail = config('seeding.users.administrador.email');

    User::factory()->create([
        'email' => $legacyEmail,
        'rol_id' => $adminRole->id,
    ]);

    $this->seed(UserSeeder::class);

    expect(User::query()->where('email', $legacyEmail)->exists())->toBeFalse()
        ->and(User::query()->where('email', $newEmail)->exists())->toBeTrue()
        ->and(User::query()->count())->toBe(4);
});
