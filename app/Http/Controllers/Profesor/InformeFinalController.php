<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\InformeFinal;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformeFinalController extends Controller
{
    //
    public function index(Request $request)
    {
        $filters = $request->validate([
            'nombre' => ['nullable', 'string', 'max:100'],
            'semestre_id' => ['nullable', 'integer', 'exists:semestres,id'],
        ]);
        $profesor = $request->user()->profesor;
        $query = InformeFinal::query()
            ->with(['alumno', 'semestre'])
            ->whereHas('alumno.aula', fn ($query) => $query->where('profesor_id', $profesor->id));

        // Filtro por nombre de alumno
        if ($filters['nombre'] ?? null) {
            $nombre = $filters['nombre'];
            $query->whereHas('alumno', function ($q) use ($nombre) {
                $q->where('nombres', 'like', "%{$nombre}%")
                    ->orWhere('apellido_paterno', 'like', "%{$nombre}%")
                    ->orWhere('apellido_materno', 'like', "%{$nombre}%")
                    ->orWhere('codigo_matricula', 'like', "%{$nombre}%");
            });
        }

        // Filtro por semestre/año
        if ($filters['semestre_id'] ?? null) {
            $query->where('semestre_id', $filters['semestre_id']);
        }

        $informes = $query->orderBy('fecha_subida', 'desc')->paginate(20)->withQueryString();

        // Obtener todos los semestres para el filtro
        $semestres = Semestre::orderBy('id', 'desc')->get();

        return view('profesor.informes-finales.index', compact('informes', 'semestres'));
    }

    /**
     * Descarga el PDF de un informe
     */
    public function download(Request $request, InformeFinal $informe)
    {
        abort_unless(
            $informe->alumno?->aula?->profesor_id === $request->user()->profesor?->id,
            403,
        );

        if (! Storage::disk('public')->exists($informe->archivo_pdf)) {
            return redirect()->back()->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download($informe->archivo_pdf, $informe->nombre_original);
    }
}
