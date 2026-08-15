<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\MonitoreoPractica;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MonitoreoPracticaController extends Controller
{
    //
    public function index(Alumno $alumno): View|RedirectResponse
    {
        // Verificar que el alumno tenga ficha de registro aprobada
        if (! $alumno->fichaRegistro || $alumno->fichaRegistro->aceptado !== true) {
            return redirect()->back()->with('error', 'El alumno no tiene una ficha de registro aprobada.');
        }

        // Verificar que tenga cronograma
        if (! $alumno->fichaRegistro->cronograma) {
            return redirect()->back()->with('error', 'El alumno no tiene un cronograma asignado.');
        }

        // Obtener el aula del alumno
        $aula = $alumno->aula;

        if (! $aula) {
            return redirect()->back()->with('error', 'El alumno no está asignado a ninguna aula.');
        }
        Gate::authorize('manage', $aula);

        // Obtener todas las semanas del aula con sus monitoreos
        $semanas = $aula->semanas()
            ->orderBy('numero')
            ->with(['monitoreosPracticas' => function ($query) use ($alumno) {
                $query->where('alumno_id', $alumno->id)
                    ->with(['monitoreosPracticasActividades.cronogramaActividad']);
            }])
            ->get();

        $cronograma = $alumno->fichaRegistro->cronograma;
        $semanasConMonitoreo = $semanas->filter(
            fn ($semana): bool => $semana->monitoreosPracticas->isNotEmpty()
        )->count();
        $resumenSemanas = $semanas->mapWithKeys(function ($semana): array {
            $monitoreo = $semana->monitoreosPracticas->first();
            $totalActividades = $monitoreo?->monitoreosPracticasActividades->count() ?? 0;
            $actividadesAlDia = $monitoreo?->monitoreosPracticasActividades
                ->where('al_dia', true)
                ->count() ?? 0;

            return [$semana->id => [
                'monitoreo' => $monitoreo,
                'registrado' => $monitoreo !== null,
                'totalActividades' => $totalActividades,
                'actividadesAlDia' => $actividadesAlDia,
                'actividadesConRetraso' => $totalActividades - $actividadesAlDia,
            ]];
        });

        return view('profesor.monitoreos-practicas.index', [
            'alumno' => $alumno,
            'semanas' => $semanas,
            'aula' => $aula,
            'cronograma' => $cronograma,
            'progresoMonitoreo' => [
                'totalSemanas' => $semanas->count(),
                'semanasRegistradas' => $semanasConMonitoreo,
                'porcentaje' => $semanas->isEmpty()
                    ? 0
                    : (int) round(($semanasConMonitoreo / $semanas->count()) * 100),
            ],
            'resumenSemanas' => $resumenSemanas,
        ]);
    }

    /**
     * Muestra el detalle de un monitoreo específico
     */
    public function show(MonitoreoPractica $monitoreoPractica): View
    {
        $monitoreoPractica->load([
            'alumno.user',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad',
        ]);
        Gate::authorize('manage', $monitoreoPractica->alumno->aula);

        $actividades = $monitoreoPractica->monitoreosPracticasActividades;
        $actividadesAlDia = $actividades->where('al_dia', true)->count();

        return view('profesor.monitoreos-practicas.show', [
            'monitoreo' => $monitoreoPractica,
            'metricas' => [
                'actividades' => $actividades->count(),
                'alDia' => $actividadesAlDia,
                'conRetraso' => $actividades->count() - $actividadesAlDia,
            ],
        ]);
    }
}
