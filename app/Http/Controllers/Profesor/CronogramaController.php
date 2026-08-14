<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Cronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CronogramaController extends Controller
{
    //
    public function show(Cronograma $cronograma)
    {
        // Seguridad: el cronograma debe pertenecer a un alumno del aula del profesor
        $profesor = Auth::user()->profesor;

        abort_if(
            $cronograma->fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        return view('profesor.cronogramas.show', compact('cronograma'));
    }

    /**
     * Guardar firma del profesor
     */
    public function firmar(Request $request, Cronograma $cronograma)
    {
        $request->validate([
            'firma' => 'required|string'
        ]);

        // Ya firmado → no permitir doble firma
        if ($cronograma->firma_profesor) {
            return back()->with('error', 'Este cronograma ya fue firmado.');
        }

        // Decodificar imagen base64
        $firmaBase64 = $request->firma;
        $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
        $firmaBase64 = str_replace(' ', '+', $firmaBase64);

        $nombreArchivo = 'firma_profesor_' . Str::uuid() . '.png';
        $ruta = 'firmas/cronogramas/' . $nombreArchivo;

        Storage::disk('public')->put($ruta, base64_decode($firmaBase64));

        // Guardar firma
        $cronograma->update([
            'firma_profesor' => $ruta
        ]);

        return redirect()
            ->route('profesor.cronogramas.show', $cronograma)
            ->with('success', 'Cronograma firmado correctamente.');
    }

    public function calificar(Request $request, Cronograma $cronograma)
    {
        // Seguridad: verificar que pertenece al aula del profesor
        $profesor = Auth::user()->profesor;

        abort_if(
            $cronograma->fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        // Validar calificación
        $request->validate([
            'calificacion' => 'required|numeric|min:0|max:20'
        ], [
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.numeric' => 'La calificación debe ser un número.',
            'calificacion.min' => 'La calificación mínima es 0.',
            'calificacion.max' => 'La calificación máxima es 20.'
        ]);

        // Verificar que el cronograma esté completamente firmado
        if (!$cronograma->estaFirmadoCompleto()) {
            return back()->with('error', 'El cronograma debe estar completamente firmado antes de calificarlo.');
        }

        // Guardar calificación
        $cronograma->update([
            'calificacion' => $request->calificacion
        ]);

        return redirect()
            ->route('profesor.cronogramas.show', $cronograma)
            ->with('success', 'Calificación registrada correctamente.');
    }

}
