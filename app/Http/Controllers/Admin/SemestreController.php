<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SemestreController extends Controller
{
    //
    public function cerrar(Request $request)
    {
        $request->validate([
            'semestre_id' => 'required|exists:semestres,id',
        ]);

        $semestre = Semestre::find($request->semestre_id);

        // Solo cambia el estado si está activo, para evitar consultas innecesarias
        if ($semestre->activo) {
            $semestre->activo = false;
            $semestre->save();

            // Si el semestre cerraba el único activo, ahora no habrá activo.
            // Si quieres forzar a que uno esté activo, la lógica cambia.
            // Para este caso, simplemente lo desactivamos.
        }

        return Redirect::route('dashboard')->with('status', 'Semestre "' . $semestre->nombre . '" cerrado exitosamente.');
    }

    /**
     * Crea un nuevo semestre (lo pone como activo = true y desactiva los demás).
     */
    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|min:' . (date('Y') - 5), // Por ejemplo, un rango de años razonable
            'periodo' => 'required|in:I,II,EXT',
        ]);

        // Concatena para obtener el formato "2025-II"
        $nombreSemestre = $request->anio . '-' . $request->periodo;

        // Verifica si el semestre ya existe para evitar duplicados
        if (Semestre::where('nombre', $nombreSemestre)->exists()) {
            return Redirect::route('dashboard')->withErrors(['semestre' => 'El semestre "' . $nombreSemestre . '" ya existe.'])->withInput();
        }

        // Crea el nuevo semestre.
        // La lógica en el modelo Semestre se encargará de poner activo=true
        // y desactivar a los demás.
        Semestre::create([
            'nombre' => $nombreSemestre,
            'activo' => true,
        ]);

        return Redirect::route('dashboard')->with('status', 'Nuevo semestre "' . $nombreSemestre . '" creado y activado exitosamente.');
    }
}
