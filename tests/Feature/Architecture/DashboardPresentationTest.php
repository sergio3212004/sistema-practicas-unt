<?php

use App\Models\Administrador;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Profesor;
use App\Models\RazonSocial;
use App\Models\Rol;
use App\Models\User;

test('the administrator dashboard renders its view model', function () {
    $role = Rol::query()->create(['nombre' => 'administrador']);
    $user = User::factory()->create(['rol_id' => $role->id]);
    Administrador::query()->create([
        'user_id' => $user->id,
        'nombres' => 'Ana',
        'apellido_paterno' => 'Torres',
        'apellido_materno' => 'Ruiz',
        'telefono' => '987654321',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('<title>Resumen | '.e(config('app.name')).'</title>', escape: false)
        ->assertSee('Administración académica');
});

test('the student dashboard renders its view model', function () {
    $role = Rol::query()->create(['nombre' => 'alumno']);
    $user = User::factory()->create(['rol_id' => $role->id]);
    Alumno::query()->create([
        'user_id' => $user->id,
        'codigo_matricula' => '2026000001',
        'nombres' => 'Luis',
        'apellido_paterno' => 'Vega',
        'apellido_materno' => 'Díaz',
        'telefono' => '987654321',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Espacio del estudiante');
});

test('the professor dashboard renders its view model', function () {
    $role = Rol::query()->create(['nombre' => 'profesor']);
    $user = User::factory()->create(['rol_id' => $role->id]);
    Profesor::query()->create([
        'user_id' => $user->id,
        'codigo_profesor' => 'DOC0000001',
        'nombres' => 'María',
        'apellido_paterno' => 'Luna',
        'apellido_materno' => 'Paz',
        'telefono' => '987654321',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Supervisión docente');
});

test('the company dashboard renders its view model', function () {
    $role = Rol::query()->create(['nombre' => 'empresa']);
    $businessType = RazonSocial::query()->create(['acronimo' => 'SAC']);
    $user = User::factory()->create(['rol_id' => $role->id]);
    Empresa::query()->create([
        'user_id' => $user->id,
        'razon_social_id' => $businessType->id,
        'ruc' => '20123456789',
        'nombre' => 'Empresa Demo',
        'aprobado' => true,
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Vinculación empresarial');
});
