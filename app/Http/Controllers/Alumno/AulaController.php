<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AulaController extends Controller
{
    //
    public function index(Aula $aula)
    {
        // Verificar que el alumno pertenece a esta aula
        $alumno = Auth::user()->alumno;

        if ($alumno->aula_id !== $aula->id) {
            abort(403, 'No tienes acceso a esta aula.');
        }

        // Cargar relaciones necesarias
        $aula->load([
            'semestre',
            'profesor.user',
            'semanas.actividades.tipoActividad',
            'semanas.actividades.entregas' => function($query) use ($alumno) {
                $query->where('alumno_id', $alumno->id);
            }
        ]);

        return view('alumno.aula.index', compact('aula'));
    }
}
