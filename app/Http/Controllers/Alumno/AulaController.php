<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\View\Alumno\Aula\AlumnoAulaViewModelFactory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AulaController extends Controller
{
    public function index(Request $request, Aula $aula, AlumnoAulaViewModelFactory $factory): View
    {
        $alumno = $request->user()->alumno;

        if ($alumno->aula_id !== $aula->id) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        $aula->load([
            'semestre',
            'profesor.user',
            'semanas.actividades.tipoActividad',
            'semanas.actividades.entregas' => function ($query) use ($alumno) {
                $query->where('alumno_id', $alumno->id);
            },
        ]);

        return view('alumno.aula.index', [
            'pagina' => $factory->make($aula, $alumno),
        ]);
    }
}
