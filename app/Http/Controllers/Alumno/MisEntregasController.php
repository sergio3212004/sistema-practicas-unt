<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use App\Models\EntregaAlumno;
use Illuminate\Http\Request;

class MisEntregasController extends Controller
{
    //
    public function index()
    {
        $alumno = auth()->user()->alumno;

        // Obtener el aula del alumno
        $aula = $alumno->aula()->with('semestre')->first();

        if (!$aula) {
            return view('alumno.entregas.index', [
                'entregas' => collect([]),
                'mensaje' => 'No estás asignado a ningún aula'
            ]);
        }

        // Obtener todas las entregas del aula
        $entregas = Entrega::where('aula_id', $aula->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($entrega) use ($alumno) {
                $entregaAlumno = EntregaAlumno::where('entrega_id', $entrega->id)
                    ->where('alumno_id', $alumno->id)
                    ->first();

                return [
                    'id' => $entrega->id,
                    'titulo' => $entrega->titulo,
                    'descripcion' => $entrega->descripcion,
                    'fecha_inicio' => $entrega->fecha_inicio,
                    'fecha_fin' => $entrega->fecha_fin,
                    'entrega_alumno_id' => $entregaAlumno?->id,
                    'link_entrega' => $entregaAlumno?->link_entrega,
                    'fecha_subida' => $entregaAlumno?->fecha_subida,
                    'nota' => $entregaAlumno?->nota,
                    'comentario_profesor' => $entregaAlumno?->comentario_profesor,
                    'fecha_revision' => $entregaAlumno?->fecha_revision,
                    'estado' => $this->determinarEstado($entrega, $entregaAlumno),
                ];
            });

        return view('alumno.entregas.index', compact('entregas', 'aula'));
    }

    /**
     * Muestra el detalle de una entrega específica
     */
    public function show($entregaId)
    {
        $alumno = auth()->user()->alumno;

        $entrega = Entrega::findOrFail($entregaId);

        $entregaAlumno = EntregaAlumno::where('entrega_id', $entrega->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        return view('alumno.entregas.show', compact('entrega', 'entregaAlumno'));
    }

    /**
     * Guarda o actualiza el link de entrega del alumno
     */
    public function guardarLink(Request $request, $entregaId)
    {
        $validated = $request->validate([
            'link_entrega' => 'required|url|max:500',
        ]);

        $alumno = auth()->user()->alumno;
        $entrega = Entrega::findOrFail($entregaId);

        // Verificar que la entrega no haya vencido
        if (now()->greaterThan($entrega->fecha_fin)) {
            return redirect()->back()->with('error', 'La fecha de entrega ha vencido');
        }

        EntregaAlumno::updateOrCreate(
            [
                'entrega_id' => $entregaId,
                'alumno_id' => $alumno->id,
            ],
            [
                'link_entrega' => $validated['link_entrega'],
                'fecha_subida' => now(),
            ]
        );

        return redirect()
            ->route('alumno.entregas.mis-entregas')
            ->with('success', 'Link de entrega guardado exitosamente');
    }

    /**
     * Determina el estado de una entrega
     */
    private function determinarEstado($entrega, $entregaAlumno)
    {
        if ($entregaAlumno && $entregaAlumno->nota !== null) {
            return 'Calificado';
        }

        if ($entregaAlumno && $entregaAlumno->link_entrega) {
            return 'Entregado';
        }

        if (now()->greaterThan($entrega->fecha_fin)) {
            return 'Vencido';
        }

        return 'Pendiente';
    }
}
