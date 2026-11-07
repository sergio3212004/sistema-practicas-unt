<?php

namespace App\View\Profesor\Aula;

use App\Models\Aula;
use App\Models\Profesor;
use App\View\Presenters\ActividadPresenter;

final class ProfesorAulaViewModelFactory
{
    public function make(Aula $aula, ?Profesor $profesor, ActividadPresenter $presenter): array
    {
        $aula->load([
            'semestre',
            'alumnos.user',
            'alumnos.fichaRegistro.cronograma.monitoreosPracticas',
            'semanas' => fn ($query) => $query->orderBy('numero'),
            'semanas.actividades.tipoActividad',
            'semanas.actividades.entregas',
        ]);

        $actividades = $aula->semanas->flatMap->actividades;
        $totalAlumnos = $aula->alumnos->count();
        $progresoActividades = $actividades->mapWithKeys(fn ($actividad): array => [
            $actividad->id => $presenter->progreso($actividad, $totalAlumnos),
        ]);
        $monitoreosPorAlumno = $aula->alumnos->mapWithKeys(fn ($alumno): array => [
            $alumno->id => $alumno->fichaRegistro?->cronograma?->monitoreosPracticas->count() ?? 0,
        ]);

        return [
            'aula' => $aula,
            'profesor' => $profesor,
            'metricas' => [
                'estudiantes' => $totalAlumnos,
                'semanas' => $aula->semanas->count(),
                'actividadesActivas' => $actividades->filter->estaActiva()->count(),
                'actividades' => $actividades->count(),
            ],
            'progresoActividades' => $progresoActividades,
            'monitoreosPorAlumno' => $monitoreosPorAlumno,
        ];
    }
}
