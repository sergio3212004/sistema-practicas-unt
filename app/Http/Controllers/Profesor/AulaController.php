<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\View\Presenters\ActividadPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AulaController extends Controller
{
    /**
     * Ver detalle de un aula
     */
    public function show(Request $request, Aula $aula, ActividadPresenter $presenter): View
    {
        Gate::authorize('manage', $aula);

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

        return view('profesor.aulas.show', [
            'aula' => $aula,
            'profesor' => $request->user()->profesor,
            'metricas' => [
                'estudiantes' => $totalAlumnos,
                'semanas' => $aula->semanas->count(),
                'actividadesActivas' => $actividades->filter->estaActiva()->count(),
                'actividades' => $actividades->count(),
            ],
            'progresoActividades' => $progresoActividades,
            'monitoreosPorAlumno' => $monitoreosPorAlumno,
        ]);
    }
}
