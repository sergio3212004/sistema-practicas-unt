<?php

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Profesor;
use App\Models\Rol;
use App\Models\Semana;
use App\Models\Semestre;
use App\Models\TipoActividad;
use App\Models\User;

test('the student classroom renders prepared weeks and activities', function () {
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);
    $teacherRole = Rol::query()->create(['nombre' => 'profesor']);

    $teacherUser = User::factory()->create(['rol_id' => $teacherRole->id]);
    $teacher = Profesor::query()->create([
        'user_id' => $teacherUser->id,
        'codigo_profesor' => 'DOC0000001',
        'nombres' => 'María',
        'apellido_paterno' => 'Luna',
        'apellido_materno' => 'Paz',
        'telefono' => '987654321',
    ]);
    $semester = Semestre::query()->create(['nombre' => '2026-II', 'activo' => true]);
    $classroom = Aula::query()->create([
        'semestre_id' => $semester->id,
        'profesor_id' => $teacher->id,
    ]);

    $studentUser = User::factory()->create(['rol_id' => $studentRole->id]);
    Alumno::query()->create([
        'user_id' => $studentUser->id,
        'aula_id' => $classroom->id,
        'codigo_matricula' => '2026000001',
        'nombres' => 'Luis',
        'apellido_paterno' => 'Vega',
        'apellido_materno' => 'Díaz',
        'telefono' => '987654321',
    ]);

    $week = Semana::query()->create([
        'aula_id' => $classroom->id,
        'numero' => 1,
        'nombre' => 'Semana inicial',
    ]);
    $type = TipoActividad::query()->create([
        'nombre' => 'Informe',
        'modo_entrega' => 'pdf',
    ]);
    Actividad::query()->create([
        'aula_id' => $classroom->id,
        'semana_id' => $week->id,
        'tipo_actividad_id' => $type->id,
        'titulo' => 'Informe semanal',
        'descripcion' => 'Resumen de avances',
        'fecha_inicio' => now()->subDay(),
        'fecha_limite' => now()->addDay(),
    ]);

    $this->actingAs($studentUser)
        ->get(route('alumno.aula.index', $classroom))
        ->assertOk()
        ->assertSee('<title>Aula '.$classroom->numero.' | '.e(config('app.name')).'</title>', escape: false)
        ->assertSee('Semana inicial')
        ->assertSee('Informe semanal');
});
