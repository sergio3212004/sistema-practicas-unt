<?php

use App\Models\Alumno;
use App\Models\Aula;
use App\Models\InformeFinal;
use App\Models\Rol;
use App\Models\Semestre;
use App\Models\User;

function administratorUser(): User
{
    $role = Rol::query()->firstOrCreate(['nombre' => 'administrador']);

    return User::factory()->create(['rol_id' => $role->id]);
}

it('renders the primary administrator workflows with the shared interface', function () {
    $administrator = administratorUser();
    foreach (['alumno', 'empresa', 'profesor'] as $role) {
        Rol::query()->firstOrCreate(['nombre' => $role]);
    }

    $semester = Semestre::query()->create(['nombre' => '2026-II', 'activo' => true]);
    $classroom = Aula::query()->create(['semestre_id' => $semester->id]);

    $routes = [
        route('admin.usuarios.index'),
        route('admin.usuarios.create'),
        route('admin.usuarios.show', $administrator),
        route('admin.usuarios.edit', $administrator),
        route('admin.aulas.index'),
        route('admin.aulas.create'),
        route('admin.aulas.show', $classroom),
        route('admin.aulas.edit', $classroom),
        route('admin.aulas.agregar-alumnos', $classroom),
        route('admin.aprobaciones.index'),
        route('admin.informes-finales.index'),
    ];

    foreach ($routes as $route) {
        $this->actingAs($administrator)
            ->get($route)
            ->assertOk()
            ->assertSee('Saltar al contenido principal');
    }
});

it('allows an administrator to find users by student code and role', function () {
    $administrator = administratorUser();
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);

    $matchingUser = User::factory()->create([
        'email' => 'estudiante-encontrado@example.test',
        'rol_id' => $studentRole->id,
    ]);
    Alumno::query()->create([
        'user_id' => $matchingUser->id,
        'codigo_matricula' => 'UNT-UX-2048',
        'nombres' => 'María',
        'apellido_paterno' => 'Encontrada',
        'apellido_materno' => 'Prueba',
        'telefono' => '900000001',
    ]);

    $otherUser = User::factory()->create([
        'email' => 'estudiante-omitido@example.test',
        'rol_id' => $studentRole->id,
    ]);
    Alumno::query()->create([
        'user_id' => $otherUser->id,
        'codigo_matricula' => 'UNT-OTRO-0001',
        'nombres' => 'Persona',
        'apellido_paterno' => 'Omitida',
        'apellido_materno' => 'Prueba',
        'telefono' => '900000002',
    ]);

    $this->actingAs($administrator)
        ->get(route('admin.usuarios.index', [
            'q' => 'UNT-UX-2048',
            'rol' => $studentRole->id,
        ]))
        ->assertOk()
        ->assertSee('estudiante-encontrado@example.test')
        ->assertDontSee('estudiante-omitido@example.test')
        ->assertSee('value="UNT-UX-2048"', false);
});

it('filters final reports by student code and preserves the active criteria', function () {
    $administrator = administratorUser();
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);
    $semester = Semestre::query()->create(['nombre' => '2026-II', 'activo' => true]);

    $matchingUser = User::factory()->create(['rol_id' => $studentRole->id]);
    $matchingStudent = Alumno::query()->create([
        'user_id' => $matchingUser->id,
        'codigo_matricula' => 'UNT-INF-2048',
        'nombres' => 'Informe',
        'apellido_paterno' => 'Encontrado',
        'apellido_materno' => 'Prueba',
        'telefono' => '900000003',
    ]);
    InformeFinal::query()->create([
        'alumno_id' => $matchingStudent->id,
        'archivo_pdf' => 'informes/encontrado.pdf',
        'nombre_original' => 'informe-encontrado.pdf',
        'tamanio' => 2048,
        'semestre_id' => $semester->id,
        'fecha_subida' => now(),
    ]);

    $otherUser = User::factory()->create(['rol_id' => $studentRole->id]);
    $otherStudent = Alumno::query()->create([
        'user_id' => $otherUser->id,
        'codigo_matricula' => 'UNT-INF-0001',
        'nombres' => 'Informe',
        'apellido_paterno' => 'Omitido',
        'apellido_materno' => 'Prueba',
        'telefono' => '900000004',
    ]);
    InformeFinal::query()->create([
        'alumno_id' => $otherStudent->id,
        'archivo_pdf' => 'informes/omitido.pdf',
        'nombre_original' => 'informe-omitido.pdf',
        'tamanio' => 1024,
        'semestre_id' => $semester->id,
        'fecha_subida' => now()->subMinute(),
    ]);

    $this->actingAs($administrator)
        ->get(route('admin.informes-finales.index', [
            'nombre' => 'UNT-INF-2048',
            'semestre_id' => $semester->id,
        ]))
        ->assertOk()
        ->assertSee('informe-encontrado.pdf')
        ->assertDontSee('informe-omitido.pdf')
        ->assertSee('value="UNT-INF-2048"', false)
        ->assertSee('value="'.$semester->id.'" selected', false);
});
