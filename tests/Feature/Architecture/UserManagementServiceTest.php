<?php

use App\Models\Rol;
use App\Models\User;
use App\Services\UserManagementService;

test('user creation persists its role profile atomically', function () {
    $role = Rol::query()->create(['nombre' => 'alumno']);

    $user = app(UserManagementService::class)->create([
        'email' => 'alumno@unit.test',
        'password' => 'password',
        'rol_id' => $role->id,
        'codigo_matricula_alumno' => '2026000001',
        'nombres_alumno' => 'Ana',
        'apellido_paterno_alumno' => 'Torres',
        'apellido_materno_alumno' => 'Vega',
        'telefono_alumno' => '987654321',
    ]);

    expect($user->alumno)
        ->not->toBeNull()
        ->codigo_matricula->toBe('2026000001');
});

test('changing a user role removes the stale profile', function () {
    $adminRole = Rol::query()->create(['nombre' => 'administrador']);
    $teacherRole = Rol::query()->create(['nombre' => 'profesor']);
    $user = User::factory()->create(['rol_id' => $adminRole->id]);

    $user->administrador()->create([
        'nombres' => 'Ada',
        'apellido_paterno' => 'Lovelace',
        'apellido_materno' => 'Byron',
        'telefono' => '987654321',
    ]);

    app(UserManagementService::class)->update($user, [
        'email' => $user->email,
        'rol_id' => $teacherRole->id,
        'codigo_profesor' => 'DOC0000001',
        'nombres_profesor' => 'Ada',
        'apellido_paterno_profesor' => 'Lovelace',
        'apellido_materno_profesor' => 'Byron',
        'telefono_profesor' => '987654321',
    ]);

    expect($user->fresh()->administrador)->toBeNull()
        ->and($user->fresh()->profesor)->not->toBeNull()
        ->and($user->fresh()->rol->nombre)->toBe('profesor');
});

test('the admin user endpoint delegates validated profile creation', function () {
    $adminRole = Rol::query()->create(['nombre' => 'administrador']);
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);
    $admin = User::factory()->create(['rol_id' => $adminRole->id]);

    $this->actingAs($admin)
        ->post(route('admin.usuarios.store'), [
            'email' => 'nuevo.alumno@unit.test',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rol_id' => $studentRole->id,
            'codigo_matricula_alumno' => '2026000003',
            'nombres_alumno' => 'Mario',
            'apellido_paterno_alumno' => 'Ramos',
            'apellido_materno_alumno' => 'Díaz',
            'telefono_alumno' => '987654323',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.usuarios.index'));

    $user = User::query()->where('email', 'nuevo.alumno@unit.test')->firstOrFail();

    expect($user->alumno->codigo_matricula)->toBe('2026000003');
});
