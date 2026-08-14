<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesor\StoreActividadRequest;
use App\Models\Actividad;
use App\Models\Aula;
use App\Models\TipoActividad;
use Illuminate\Http\RedirectResponse;
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

        return view('profesor.actividades.create', compact('aula', 'semanas', 'tiposActividad'));
    }

    public function store(StoreActividadRequest $request, Aula $aula): RedirectResponse
    {
        $aula->actividades()->create($request->validated());

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Actividad creada exitosamente.');
    }

    public function show(Actividad $actividad): View
    {
        Gate::authorize('manage', $actividad);

        $actividad->load(
            'aula.semestre',
            'semana',
            'tipoActividad',
            'entregas.alumno.user',
        );

        return view('profesor.actividades.show', compact('actividad'));
    }

    public function destroy(Actividad $actividad): RedirectResponse
    {
        Gate::authorize('manage', $actividad);

        $aula = $actividad->aula;
        $actividad->delete();

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Actividad eliminada exitosamente.');
    }
}
