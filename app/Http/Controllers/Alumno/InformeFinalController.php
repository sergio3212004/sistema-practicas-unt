<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\InformeFinal;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformeFinalController extends Controller
{
    /**
     * Muestra el formulario y el estado del informe
     */
    public function index()
    {
        $alumno = auth()->user()->alumno;

        // Obtener el semestre actual
        $semestreActual = Semestre::where('activo', true)->first();


        // Buscar si ya existe un informe para este semestre
        $informe = InformeFinal::where('alumno_id', $alumno->id)
            ->where('semestre_id', $semestreActual?->id)
            ->first();

        return view('alumno.informe-final.index', compact('informe', 'semestreActual'));
    }

    /**
     * Sube el PDF del informe final
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:20480', // 20MB máximo
        ]);

        $alumno = auth()->user()->alumno;
        $semestreActual = Semestre::where('activo', true)->first();

        if (!$semestreActual) {
            return redirect()->back()->with('error', 'No hay un semestre activo');
        }

        // Verificar si ya existe un informe para este semestre
        $informeExistente = InformeFinal::where('alumno_id', $alumno->id)
            ->where('semestre_id', $semestreActual->id)
            ->first();

        // Eliminar archivo antiguo si existe
        if ($informeExistente && Storage::disk('public')->exists($informeExistente->archivo_pdf)) {
            Storage::disk('public')->delete($informeExistente->archivo_pdf);
        }

        // Guardar el nuevo archivo
        $file = $request->file('archivo');
        $nombreOriginal = $file->getClientOriginalName();
        $filename = time() . '_' . $alumno->id . '_' . $nombreOriginal;
        $path = $file->storeAs('informes_finales', $filename, 'public');

        // Crear o actualizar el registro
        $data = [
            'alumno_id' => $alumno->id,
            'semestre_id' => $semestreActual->id,
            'archivo_pdf' => $path,
            'nombre_original' => $nombreOriginal,
            'tamanio' => $file->getSize(),
            'fecha_subida' => now(),
        ];

        if ($informeExistente) {
            $informeExistente->update($data);
        } else {
            InformeFinal::create($data);
        }

        return redirect()
            ->route('alumno.informe-final.index')
            ->with('success', 'Informe final subido exitosamente');
    }

    /**
     * Descarga el propio informe del alumno
     */
    public function download()
    {
        $alumno = auth()->user()->alumno;
        $semestreActual = Semestre::where('estado', 'activo')->first();

        $informe = InformeFinal::where('alumno_id', $alumno->id)
            ->where('semestre_id', $semestreActual?->id)
            ->firstOrFail();

        if (!Storage::disk('public')->exists($informe->archivo_pdf)) {
            return redirect()->back()->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download($informe->archivo_pdf, $informe->nombre_original);
    }
}
