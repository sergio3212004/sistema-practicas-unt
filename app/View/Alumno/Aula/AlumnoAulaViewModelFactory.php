<?php

namespace App\View\Alumno\Aula;

use App\Models\Actividad;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\Entrega;
use App\View\Presenters\ActividadPresenter;
use App\View\Presenters\EntregaPresenter;

final class AlumnoAulaViewModelFactory
{
    public function __construct(
        private readonly ActividadPresenter $actividadPresenter,
        private readonly EntregaPresenter $entregaPresenter,
    ) {}

    public function make(Aula $aula, Alumno $alumno): AlumnoAulaViewModel
    {
        $actividades = $aula->semanas->flatMap->actividades;
        $entregas = $actividades
            ->flatMap->entregas
            ->where('alumno_id', $alumno->id)
            ->keyBy('actividad_id');

        $semanas = $aula->semanas
            ->sortBy('numero')
            ->values()
            ->map(function ($semana) use ($entregas): array {
                $actividades = $semana->actividades
                    ->sortBy('fecha_inicio')
                    ->values()
                    ->map(function (Actividad $actividad) use ($entregas): array {
                        /** @var Entrega|null $entrega */
                        $entrega = $entregas->get($actividad->id);

                        return [
                            'actividad' => $actividad,
                            'entrega' => $entrega,
                            'estado' => $this->actividadPresenter->estado($actividad, $entrega),
                            'estadoEntrega' => $entrega ? $this->entregaPresenter->estado($entrega) : null,
                            'puedeEntregar' => ! $actividad->estaVencida(),
                        ];
                    });
                $entregadas = $actividades->whereNotNull('entrega')->count();

                return [
                    'semana' => $semana,
                    'actividades' => $actividades,
                    'totalActividades' => $actividades->count(),
                    'progreso' => $actividades->isEmpty()
                        ? 0
                        : (int) round(($entregadas / $actividades->count()) * 100),
                ];
            });

        return new AlumnoAulaViewModel(
            aula: $aula,
            metricas: [
                'actividades' => $actividades->count(),
                'activas' => $actividades->filter->estaActiva()->count(),
                'entregadas' => $entregas->count(),
                'pendientes' => max(0, $actividades->count() - $entregas->count()),
            ],
            semanas: $semanas,
        );
    }
}
