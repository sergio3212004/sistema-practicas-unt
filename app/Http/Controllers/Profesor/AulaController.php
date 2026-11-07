<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\View\Presenters\ActividadPresenter;
use App\View\Profesor\Aula\ProfesorAulaViewModelFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AulaController extends Controller
{
    /**
     * Ver detalle de un aula
     */
    public function show(Request $request, Aula $aula, ActividadPresenter $presenter, ProfesorAulaViewModelFactory $factory): View
    {
        Gate::authorize('manage', $aula);

        return view('profesor.aulas.show', $factory->make($aula, $request->user()->profesor, $presenter));
    }
}
