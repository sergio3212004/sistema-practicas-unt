<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesor\StoreActividadRequest;
use App\Models\Actividad;
use App\Models\Aula;
use App\Models\TipoActividad;
use App\View\Presenters\EntregaPresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ActividadesController extends Controller
{
    public function create(Aula $aula): View
    {
        Gate::authorize('manage', $aula);

        $aula->load('semestre');
        $semanas = $aula->semanas()->orderBy('numero')->get();
        $tiposActividad = TipoActividad::query()->orderBy('nombre')->get();
        $siguienteNumero = ((int) $semanas->max('numero')) + 1;
        $fechaInicioSugerida = now()->startOfHour()->format('Y-m-d\TH:i');
        $fechaLimiteSugerida = now()->addWeek()->endOfDay()->format('Y-m-d\TH:i');

        return view('profesor.actividades.create', compact(
            'aula',
            'semanas',
            'tiposActividad',
            'siguienteNumero',
            'fechaInicioSugerida',
            'fechaLimiteSugerida',
        ));
    }

    public function store(StoreActividadRequest $request, Aula $aula): RedirectResponse
    {
        $data = $request->validated();

        $semana = DB::transaction(function () use ($aula, $data) {
            if ($data['semana_mode'] === 'new') {
                $siguienteNumero = ((int) $aula->semanas()->max('numero')) + 1;
                $semana = $aula->semanas()->create([
                    'numero' => $siguienteNumero,
                    'nombre' => $data['nueva_semana_nombre'] ?? null,
                ]);
            } else {
                $semana = $aula->semanas()->findOrFail($data['semana_id']);
            }

            $aula->actividades()->create([
                'semana_id' => $semana->getKey(),
                'tipo_actividad_id' => $data['tipo_actividad_id'],
                'titulo' => $data['titulo'],
                'descripcion' => $data['descripcion'] ?? null,
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_limite' => $data['fecha_limite'],
            ]);

            return $semana;
        });

        return redirect()
            ->route('profesor.aulas.show', ['aula' => $aula, 'tab' => 'planificacion'])
            ->with('success', "Tarea creada y organizada en la semana {$semana->numero}.");
    }

    public function show(Actividad $actividad, EntregaPresenter $presenter): View
    {
        Gate::authorize('manage', $actividad);

        $actividad->load(
            'aula.semestre',
            'semana',
            'tipoActividad',
            'entregas.alumno.user',
        );

        $estadosEntregas = $actividad->entregas->mapWithKeys(fn ($entrega): array => [
            $entrega->id => $presenter->estado($entrega),
        ]);

        return view('profesor.actividades.show', compact('actividad', 'estadosEntregas'));
    }

    public function destroy(Actividad $actividad): RedirectResponse
    {
        Gate::authorize('manage', $actividad);

        $aula = $actividad->aula;
        $actividad->delete();

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Tarea eliminada exitosamente.');
    }
}
