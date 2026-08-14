<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class PostulacionController extends Controller
{
    //
    public function store(Publicacion $practica)
    {
        $alumno = auth()->user()->alumno;

        // 1. Verificar que el alumno tenga CV
        if (!$alumno || !$alumno->cv) {
            return back()->with('error', 'Debes subir tu CV antes de postular.');
        }

        // 2. Evitar doble postulación
        $yaPostulado = Postulacion::where('alumno_id', $alumno->id)
            ->where('publicacion_id', $practica->id)
            ->exists();

        if ($yaPostulado) {
            return back()->with('warning', 'Ya te has postulado a esta práctica.');
        }

        // 3. Crear postulación
        Postulacion::create([
            'alumno_id' => $alumno->id,
            'aprobado' => null,
            'publicacion_id' => $practica->id,
        ]);

        return back()->with('success', 'Postulación enviada correctamente.');
    }

}
