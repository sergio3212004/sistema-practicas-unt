<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AulaController extends Controller
{
    /**
     * Ver detalle de un aula
     */
    public function show(Request $request, Aula $aula): View
    {
        Gate::authorize('manage', $aula);

        $aula->load([
            'semestre',
            'alumnos.user',
            'alumnos.fichaRegistro.cronograma',
        ]);

        return view('profesor.aulas.show', [
            'aula' => $aula,
            'profesor' => $request->user()->profesor,
        ]);
    }
}
