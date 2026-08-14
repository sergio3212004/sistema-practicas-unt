<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesor\StoreSemanaRequest;
use App\Http\Requests\Profesor\UpdateSemanaRequest;
use App\Models\Aula;
use App\Models\Semana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SemanaController extends Controller
{
    public function index(Request $request): View
    {
        $profesor = $request->user()->profesor;
        $semanas = Semana::query()
            ->whereHas('aula', fn ($query) => $query->where('profesor_id', $profesor->id))
            ->with('aula.semestre', 'actividades')
            ->orderBy('aula_id')
            ->orderBy('numero')
            ->get();

        return view('profesor.semanas.index', compact('semanas'));
    }

    public function create(Aula $aula): View
    {
        Gate::authorize('manage', $aula);

        $aula->load('semestre', 'semanas');
        $siguienteNumero = ($aula->semanas()->max('numero') ?? 0) + 1;

        return view('profesor.semanas.create', compact('aula', 'siguienteNumero'));
    }

    public function store(StoreSemanaRequest $request, Aula $aula): RedirectResponse
    {
        $aula->semanas()->create($request->validated());

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Semana creada exitosamente.');
    }

    public function show(Semana $semana): View
    {
        Gate::authorize('manage', $semana);

        $semana->load('aula.semestre', 'actividades.tipoActividad', 'actividades.entregas');

        return view('profesor.semanas.show', compact('semana'));
    }

    public function edit(Semana $semana): View
    {
        Gate::authorize('manage', $semana);

        $semana->load('aula.semestre', 'actividades.tipoActividad');

        return view('profesor.semanas.edit', compact('semana'));
    }

    public function update(UpdateSemanaRequest $request, Semana $semana): RedirectResponse
    {
        $semana->update($request->validated());

        return redirect()
            ->route('profesor.aulas.show', $semana->aula)
            ->with('success', 'Semana actualizada exitosamente.');
    }

    public function destroy(Semana $semana): RedirectResponse
    {
        Gate::authorize('manage', $semana);

        $aula = $semana->aula;
        $semana->delete();

        return redirect()
            ->route('profesor.aulas.show', $aula)
            ->with('success', 'Semana eliminada exitosamente.');
    }
}
