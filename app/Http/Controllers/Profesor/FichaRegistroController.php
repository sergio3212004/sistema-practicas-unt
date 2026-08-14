<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\FichaRegistro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FichaRegistroController extends Controller
{
    //
    public function show(FichaRegistro $fichaRegistro)
    {
        // Seguridad por aula del profesor
        $profesor = Auth::user()->profesor;
        abort_if(
            $fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        return view('profesor.fichas.show', compact('fichaRegistro'));
    }

    public function aceptar(FichaRegistro $fichaRegistro)
    {
        $profesor = Auth::user()->profesor;

        abort_if(
            $fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        $fichaRegistro->update([
            'aceptado' => true,
        ]);

        return back()->with('success', 'Ficha aceptada correctamente');
    }
    public function rechazar(FichaRegistro $fichaRegistro)
    {
        $profesor = Auth::user()->profesor;

        abort_if(
            $fichaRegistro->alumno->aula->profesor_id !== $profesor->id,
            403
        );

        $fichaRegistro->update([
            'aceptado' => false,
        ]);

        return back()->with('success', 'Ficha aceptada correctamente');
    }
}
