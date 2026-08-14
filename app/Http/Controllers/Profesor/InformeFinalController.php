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
        $query = InformeFinal::with(['alumno', 'semestre']);

        // Filtro por nombre de alumno
        if ($request->filled('nombre')) {
            $nombre = $request->nombre;
            $query->whereHas('alumno', function ($q) use ($nombre) {
                $q->where('nombres', 'like', "%{$nombre}%")
                    ->orWhere('apellido_paterno', 'like', "%{$nombre}%")
                    ->orWhere('apellido_materno', 'like', "%{$nombre}%")
                    ->orWhere('codigo', 'like', "%{$nombre}%");
            });
        }

        // Filtro por semestre/año
        if ($request->filled('semestre_id')) {
            $query->where('semestre_id', $request->semestre_id);
        }

        $informes = $query->orderBy('fecha_subida', 'desc')->paginate(20);

        // Obtener todos los semestres para el filtro
        $semestres = Semestre::orderBy('id', 'desc')->get();

        return view('profesor.informes-finales.index', compact('informes', 'semestres'));
    }

    /**
     * Descarga el PDF de un informe
     */
    public function download($id)
    {
        $informe = InformeFinal::findOrFail($id);

        if (!Storage::disk('public')->exists($informe->archivo_pdf)) {
            return redirect()->back()->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download($informe->archivo_pdf, $informe->nombre_original);
    }
}
