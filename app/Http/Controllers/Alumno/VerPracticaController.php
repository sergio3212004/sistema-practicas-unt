<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class VerPracticaController extends Controller
{
    //
    // Mostrar todas las prácticas
    public function index()
    {
        $practicas = Publicacion::with('empresa.user')->get();

        return view('alumno.practicas.index', compact('practicas'));
    }

    // Mostrar detalle de una práctica
    public function show($id)
    {
        $alumno = auth()->user()->alumno;

        $practica = Publicacion::with('empresa.user')->findOrFail($id);
        $postulacion = $practica->postulaciones()
            ->where('alumno_id', $alumno->id)
            ->first();
        return view('alumno.practicas.show', compact('practica', 'postulacion'));
    }
}
