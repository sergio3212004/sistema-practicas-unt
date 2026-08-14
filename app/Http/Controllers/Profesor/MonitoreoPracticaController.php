<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\MonitoreoPractica;
use Illuminate\Http\Request;

class MonitoreoPracticaController extends Controller
{
    //
    public function index(Alumno $alumno)
    {
        // Verificar que el alumno tenga ficha de registro aprobada
        if (!$alumno->fichaRegistro || $alumno->fichaRegistro->aceptado !== true) {
            return redirect()->back()->with('error', 'El alumno no tiene una ficha de registro aprobada.');
        }

        // Verificar que tenga cronograma
        if (!$alumno->fichaRegistro->cronograma) {
            return redirect()->back()->with('error', 'El alumno no tiene un cronograma asignado.');
        }

        // Obtener el aula del alumno
        $aula = $alumno->aula;

        if (!$aula) {
            return redirect()->back()->with('error', 'El alumno no está asignado a ninguna aula.');
        }

        // Obtener todas las semanas del aula con sus monitoreos
        $semanas = $aula->semanas()
            ->orderBy('numero')
            ->with(['monitoreosPracticas' => function ($query) use ($alumno) {
                $query->where('alumno_id', $alumno->id)
                    ->with(['monitoreosPracticasActividades.cronogramaActividad']);
            }])
            ->get();

        $cronograma = $alumno->fichaRegistro->cronograma;

        return view('profesor.monitoreos-practicas.index', compact('alumno', 'semanas', 'aula', 'cronograma'));
    }

    /**
     * Muestra el detalle de un monitoreo específico
     */
    public function show(MonitoreoPractica $monitoreoPractica)
    {
        $monitoreoPractica->load([
            'alumno.user',
            'semana',
            'cronograma.fichaRegistro',
            'monitoreosPracticasActividades.cronogramaActividad'
        ]);

        return view('profesor.monitoreos-practicas.show', compact('monitoreoPractica'));
    }
}
