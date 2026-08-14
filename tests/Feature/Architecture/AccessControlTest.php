<?php

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Empresa;
use App\Models\Entrega;
use App\Models\Profesor;
use App\Models\Publicacion;
use App\Models\RazonSocial;
use App\Models\Rol;
use App\Models\Semana;
use App\Models\Semestre;
use App\Models\TipoActividad;
use App\Models\User;

test('role middleware rejects users from a different module', function () {
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);
    $student = User::factory()->create(['rol_id' => $studentRole->id]);

    $this->actingAs($student)
        ->get(route('admin.usuarios.index'))
        ->assertForbidden();
});

test('role middleware allows the expected role', function () {
    $adminRole = Rol::query()->create(['nombre' => 'administrador']);
    $admin = User::factory()->create(['rol_id' => $adminRole->id]);

    $this->actingAs($admin)
        ->get(route('admin.usuarios.index'))
        ->assertOk();
});

test('an unapproved company cannot enter the company module', function () {
    $companyRole = Rol::query()->create(['nombre' => 'empresa']);
    $user = User::factory()->create(['rol_id' => $companyRole->id]);
    $businessType = RazonSocial::query()->create(['acronimo' => 'SAC']);

    Empresa::query()->create([
        'user_id' => $user->id,
        'razon_social_id' => $businessType->id,
        'ruc' => '20123456789',
        'nombre' => 'Empresa pendiente',
        'aprobado' => false,
    ]);

    $this->actingAs($user)
        ->get(route('empresa.publicaciones.index'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('an approved company can enter its module', function () {
    $companyRole = Rol::query()->create(['nombre' => 'empresa']);
    $user = User::factory()->create(['rol_id' => $companyRole->id]);
    $businessType = RazonSocial::query()->create(['acronimo' => 'SAC']);

    Empresa::query()->create([
        'user_id' => $user->id,
        'razon_social_id' => $businessType->id,
        'ruc' => '20123456789',
        'nombre' => 'Empresa aprobada',
        'aprobado' => true,
    ]);

    $this->actingAs($user)
        ->get(route('empresa.publicaciones.index'))
        ->assertOk();
});

test('a company cannot edit another company publication', function () {
    $companyRole = Rol::query()->create(['nombre' => 'empresa']);
    $businessType = RazonSocial::query()->create(['acronimo' => 'SAC']);

    $owner = User::factory()->create(['rol_id' => $companyRole->id]);
    $ownerCompany = Empresa::query()->create([
        'user_id' => $owner->id,
        'razon_social_id' => $businessType->id,
        'ruc' => '20123456789',
        'nombre' => 'Propietaria',
        'aprobado' => true,
    ]);

    $intruder = User::factory()->create(['rol_id' => $companyRole->id]);
    Empresa::query()->create([
        'user_id' => $intruder->id,
        'razon_social_id' => $businessType->id,
        'ruc' => '20987654321',
        'nombre' => 'Otra empresa',
        'aprobado' => true,
    ]);

    $publication = Publicacion::query()->create([
        'empresa_id' => $ownerCompany->id,
        'nombre' => 'Prácticas',
        'cargo' => 'Practicante',
        'descripcion' => 'Convocatoria',
        'estado' => 'Disponible',
        'imagen' => 'images/img.png',
    ]);

    $this->actingAs($intruder)
        ->get(route('empresa.publicaciones.edit', $publication))
        ->assertForbidden();
});

test('a professor cannot view a week from another professor classroom', function () {
    $teacherRole = Rol::query()->create(['nombre' => 'profesor']);

    $owner = User::factory()->create(['rol_id' => $teacherRole->id]);
    $ownerTeacher = Profesor::query()->create([
        'user_id' => $owner->id,
        'codigo_profesor' => 'DOC0000001',
        'nombres' => 'Docente',
        'apellido_paterno' => 'Propietario',
        'apellido_materno' => 'Uno',
        'telefono' => '987654321',
    ]);

    $intruder = User::factory()->create(['rol_id' => $teacherRole->id]);
    Profesor::query()->create([
        'user_id' => $intruder->id,
        'codigo_profesor' => 'DOC0000002',
        'nombres' => 'Docente',
        'apellido_paterno' => 'Ajeno',
        'apellido_materno' => 'Dos',
        'telefono' => '987654322',
    ]);

    $semester = Semestre::query()->create(['nombre' => '2026-II']);
    $classroom = Aula::query()->create([
        'numero' => 1,
        'semestre_id' => $semester->id,
        'profesor_id' => $ownerTeacher->id,
    ]);
    $week = Semana::query()->create([
        'aula_id' => $classroom->id,
        'numero' => 1,
        'nombre' => 'Semana 1',
    ]);

    $this->actingAs($intruder)
        ->get(route('profesor.semanas.show', $week))
        ->assertForbidden();
});

test('a student cannot view another student delivery', function () {
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);
    $semester = Semestre::query()->create(['nombre' => '2026-II']);
    $classroom = Aula::query()->create([
        'numero' => 1,
        'semestre_id' => $semester->id,
    ]);

    $owner = User::factory()->create(['rol_id' => $studentRole->id]);
    $ownerStudent = Alumno::query()->create([
        'user_id' => $owner->id,
        'aula_id' => $classroom->id,
        'codigo_matricula' => '2026000001',
        'nombres' => 'Alumno',
        'apellido_paterno' => 'Propietario',
        'apellido_materno' => 'Uno',
        'telefono' => '987654321',
    ]);

    $intruder = User::factory()->create(['rol_id' => $studentRole->id]);
    Alumno::query()->create([
        'user_id' => $intruder->id,
        'aula_id' => $classroom->id,
        'codigo_matricula' => '2026000002',
        'nombres' => 'Alumno',
        'apellido_paterno' => 'Ajeno',
        'apellido_materno' => 'Dos',
        'telefono' => '987654322',
    ]);

    $week = Semana::query()->create([
        'aula_id' => $classroom->id,
        'numero' => 1,
    ]);
    $type = TipoActividad::query()->create([
        'nombre' => 'Informe',
        'modo_entrega' => 'pdf',
    ]);
    $activity = Actividad::query()->create([
        'aula_id' => $classroom->id,
        'semana_id' => $week->id,
        'tipo_actividad_id' => $type->id,
        'titulo' => 'Informe semanal',
        'fecha_inicio' => now()->subDay(),
        'fecha_limite' => now()->addDay(),
    ]);
    $delivery = Entrega::query()->create([
        'actividad_id' => $activity->id,
        'alumno_id' => $ownerStudent->id,
        'estado' => 'entregado',
    ]);

    $this->actingAs($intruder)
        ->get(route('alumno.entregas.show', $delivery))
        ->assertForbidden();
});
