<?php

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\InformeFinal;
use App\Models\Profesor;
use App\Models\Rol;
use App\Models\Semana;
use App\Models\Semestre;
use App\Models\TipoActividad;
use App\Models\User;

function professorExperienceContext(string $suffix = '1'): array
{
    $professorRole = Rol::query()->firstOrCreate(['nombre' => 'profesor']);
    $studentRole = Rol::query()->firstOrCreate(['nombre' => 'alumno']);
    $professorUser = User::factory()->create(['rol_id' => $professorRole->id]);
    $professor = Profesor::query()->create([
        'user_id' => $professorUser->id,
        'codigo_profesor' => 'DOC000000'.$suffix,
        'nombres' => 'Docente',
        'apellido_paterno' => 'Experiencia',
        'apellido_materno' => $suffix,
        'telefono' => '90000000'.$suffix,
    ]);
    $semester = Semestre::query()->firstOrCreate(['nombre' => '2026-II']);
    $classroom = Aula::query()->create([
        'semestre_id' => $semester->id,
        'profesor_id' => $professor->id,
    ]);
    $studentUser = User::factory()->create(['rol_id' => $studentRole->id]);
    $student = Alumno::query()->create([
        'user_id' => $studentUser->id,
        'aula_id' => $classroom->id,
        'codigo_matricula' => 'UNT-PROF-00'.$suffix,
        'nombres' => 'Estudiante',
        'apellido_paterno' => 'Asignado',
        'apellido_materno' => $suffix,
        'telefono' => '91000000'.$suffix,
    ]);

    return compact('professorUser', 'professor', 'semester', 'classroom', 'student');
}

it('renders the primary professor workflows with the shared interface', function () {
    $context = professorExperienceContext();
    $week = Semana::query()->create([
        'aula_id' => $context['classroom']->id,
        'numero' => 1,
        'nombre' => 'Inicio de prácticas',
    ]);
    $type = TipoActividad::query()->create(['nombre' => 'Informe', 'modo_entrega' => 'pdf']);
    $activity = Actividad::query()->create([
        'aula_id' => $context['classroom']->id,
        'semana_id' => $week->id,
        'tipo_actividad_id' => $type->id,
        'titulo' => 'Informe inicial',
        'fecha_inicio' => now()->subDay(),
        'fecha_limite' => now()->addDay(),
    ]);

    $routes = [
        route('profesor.aulas.show', $context['classroom']),
        route('profesor.semanas.index'),
        route('profesor.semanas.create', $context['classroom']),
        route('profesor.semanas.show', $week),
        route('profesor.semanas.edit', $week),
        route('profesor.actividades.create', $context['classroom']),
        route('profesor.actividades.show', $activity),
        route('profesor.informes-finales.index'),
        route('profesor.formato-once.index'),
        route('profesor.formato-once.list', $context['classroom']),
        route('profesor.formato-once.create', $context['classroom']),
        route('profesor.formato-doce.index'),
        route('profesor.formato-doce.create'),
    ];

    foreach ($routes as $route) {
        $this->actingAs($context['professorUser'])
            ->get($route)
            ->assertOk()
            ->assertSee('Saltar al contenido principal');
    }
});

it('shows a professor only final reports from their own classrooms', function () {
    $owner = professorExperienceContext('1');
    $other = professorExperienceContext('2');

    InformeFinal::query()->create([
        'alumno_id' => $owner['student']->id,
        'archivo_pdf' => 'informes/propio.pdf',
        'nombre_original' => 'informe-propio.pdf',
        'tamanio' => 2048,
        'semestre_id' => $owner['semester']->id,
        'fecha_subida' => now(),
    ]);
    InformeFinal::query()->create([
        'alumno_id' => $other['student']->id,
        'archivo_pdf' => 'informes/ajeno.pdf',
        'nombre_original' => 'informe-ajeno.pdf',
        'tamanio' => 1024,
        'semestre_id' => $other['semester']->id,
        'fecha_subida' => now(),
    ]);

    $this->actingAs($owner['professorUser'])
        ->get(route('profesor.informes-finales.index', ['nombre' => 'UNT-PROF-001']))
        ->assertOk()
        ->assertSee('informe-propio.pdf')
        ->assertDontSee('informe-ajeno.pdf')
        ->assertSee('value="UNT-PROF-001"', false);
});
