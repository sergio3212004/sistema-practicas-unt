<?php

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Entrega;
use App\Models\Profesor;
use App\Models\Rol;
use App\Models\Semana;
use App\Models\Semestre;
use App\Models\TipoActividad;
use App\Models\User;

test('the professor week renders metrics prepared outside the view', function () {
    $professorRole = Rol::query()->create(['nombre' => 'profesor']);
    $studentRole = Rol::query()->create(['nombre' => 'alumno']);

    $professorUser = User::factory()->create(['rol_id' => $professorRole->id]);
    $professor = Profesor::query()->create([
        'user_id' => $professorUser->id,
        'codigo_profesor' => 'DOC0000001',
        'nombres' => 'María',
        'apellido_paterno' => 'Luna',
        'apellido_materno' => 'Paz',
        'telefono' => '987654321',
    ]);
    $semester = Semestre::query()->create(['nombre' => '2026-II', 'activo' => true]);
    $classroom = Aula::query()->create([
        'semestre_id' => $semester->id,
        'profesor_id' => $professor->id,
    ]);

    $studentUser = User::factory()->create(['rol_id' => $studentRole->id]);
    $student = Alumno::query()->create([
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
    $activeActivity = Actividad::query()->create([
        'aula_id' => $classroom->id,
        'semana_id' => $week->id,
        'tipo_actividad_id' => $type->id,
        'titulo' => 'Informe vigente',
        'fecha_inicio' => now()->subDay(),
        'fecha_limite' => now()->addDay(),
    ]);
    Actividad::query()->create([
        'aula_id' => $classroom->id,
        'semana_id' => $week->id,
        'tipo_actividad_id' => $type->id,
        'titulo' => 'Informe vencido',
        'fecha_inicio' => now()->subDays(3),
        'fecha_limite' => now()->subDays(2),
    ]);
    Entrega::query()->create([
        'actividad_id' => $activeActivity->id,
        'alumno_id' => $student->id,
        'estado' => 'entregado',
        'fecha_entrega' => now(),
    ]);

    $this->actingAs($professorUser)
        ->get(route('profesor.semanas.show', $week))
        ->assertOk()
        ->assertViewHas('metricas', [
            'actividades' => 2,
            'activas' => 1,
            'entregas' => 1,
        ])
        ->assertSee('Informe vigente')
        ->assertSee('Informe vencido');
});
