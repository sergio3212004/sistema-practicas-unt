<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Models\EntregaAlumno;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    /**
     * Muestra la lista de entregas con estadísticas
     */
    public function index()
    {
        $profesor = auth()->user()->profesor;

        // Obtener todas las entregas del profesor con estadísticas
        $entregas = Entrega::where('profesor_id', $profesor->id)
            ->with(['aula.alumnos', 'entregas_alumnos'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($entrega) {
                $totalAlumnos = $entrega->aula->alumnos->count();
                $entregados = $entrega->entregas_alumnos->whereNotNull('link_entrega')->count();
                $calificados = $entrega->entregas_alumnos->whereNotNull('nota')->count();

                return [
                    'id' => $entrega->id,
                    'titulo' => $entrega->titulo,
                    'descripcion' => $entrega->descripcion,
                    'fecha_inicio' => $entrega->fecha_inicio,
                    'fecha_fin' => $entrega->fecha_fin,
                    'total_alumnos' => $totalAlumnos,
                    'entregados' => $entregados,
                    'pendientes' => $totalAlumnos - $entregados,
                    'calificados' => $calificados,
                ];
            });

        return view('profesor.informes.index', compact('entregas'));
    }

    /**
     * Muestra los trabajos de alumnos para una entrega específica
     */
    public function show($entregaId)
    {
        $profesor = auth()->user()->profesor;

        $entrega = Entrega::where('id', $entregaId)
            ->where('profesor_id', $profesor->id)
            ->with(['aula.alumnos.user'])
            ->firstOrFail();

        // Obtener todos los alumnos del aula con sus entregas
        $alumnos = $entrega->aula->alumnos->map(function ($alumno) use ($entregaId) {
            $entregaAlumno = EntregaAlumno::where('entrega_id', $entregaId)
                ->where('alumno_id', $alumno->id)
                ->first();

            return [
                'id' => $alumno->id,
                'nombres' => $alumno->nombres,
                'apellido_paterno' => $alumno->apellido_paterno,
                'apellido_materno' => $alumno->apellido_materno,
                'codigo' => $alumno->codigo,
                'entrega_alumno_id' => $entregaAlumno?->id,
                'link_entrega' => $entregaAlumno?->link_entrega,
                'fecha_subida' => $entregaAlumno?->fecha_subida,
                'comentario_profesor' => $entregaAlumno?->comentario_profesor,
                'nota' => $entregaAlumno?->nota,
                'fecha_revision' => $entregaAlumno?->fecha_revision,
            ];
        });

        return view('profesor.informes.show', compact('entrega', 'alumnos'));
    }

    /**
     * Califica una entrega de alumno
     */
    public function calificar(Request $request, $entregaAlumnoId)
    {
        $validated = $request->validate([
            'comentario_profesor' => 'nullable|string|max:1000',
            'nota' => 'required|numeric|min:0|max:20',
        ]);

        $entregaAlumno = EntregaAlumno::findOrFail($entregaAlumnoId);

        // Verificar que el profesor sea dueño de esta entrega
        $profesor = auth()->user()->profesor;
        if ($entregaAlumno->entrega->profesor_id !== $profesor->id) {
            abort(403, 'No autorizado');
        }

        $entregaAlumno->update([
            'comentario_profesor' => $validated['comentario_profesor'],
            'nota' => $validated['nota'],
            'fecha_revision' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Calificación guardada exitosamente');
    }
}
