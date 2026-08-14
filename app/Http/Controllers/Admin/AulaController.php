<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profesor;
use App\Models\Semestre;
use Illuminate\Http\Request;
use App\Models\Aula;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $aulas = Aula::with(['semestre', 'profesor'])->paginate(10);

        return view('admin.aulas.index', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $semestres = Semestre::all();
        $profesores = Profesor::all();

        return view('admin.aulas.create', compact('semestres', 'profesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'nullable|integer|min:1',
            'semestre_id' => 'required|exists:semestres,id',
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        Aula::create([
            'numero' => $request->numero,
            'semestre_id' => $request->semestre_id,
            'profesor_id' => $request->profesor_id,
        ]);

        return redirect()->route('admin.aulas.index')
            ->with('success', 'El aula se creó correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        //
        // Cargar el semestre, profesor y los alumnos relacionados
        $aula->load(['semestre', 'profesor', 'alumnos']);

        return view('admin.aulas.show', compact('aula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {
        $semestres = Semestre::all();
        $profesores = Profesor::all();
        return view('admin.aulas.edit', compact('aula', 'semestres', 'profesores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'numero' => 'required|integer|min:1',
            'semestre_id' => 'required|exists:semestres,id',
            'profesor_id' => 'nullable|exists:profesores,id',
        ]);

        $aula->update([
            'numero' => $request->numero,
            'semestre_id' => $request->semestre_id,
            'profesor_id' => $request->profesor_id,
        ]);

        return redirect()->route('admin.aulas.index')->with('success', 'El aula se actualizó correctamente.');
    }

    public function agregarAlumnos(Aula $aula)
    {
        // Alumnos que NO están en ninguna aula
        $alumnos = \App\Models\Alumno::whereNull('aula_id')->get();

        return view('admin.aulas.agregar-alumnos', compact('aula', 'alumnos'));
    }

    public function asignarAlumnos(Request $request, Aula $aula)
    {
        $request->validate([
            'alumnos' => 'required|array',
            'alumnos.*' => 'exists:alumnos,id',
        ]);

        // Asignar cada alumno al aula
        foreach ($request->alumnos as $alumnoId) {
            $alumno = \App\Models\Alumno::find($alumnoId);
            $alumno->update(['aula_id' => $aula->id]);
        }

        return redirect()
            ->route('admin.aulas.show', $aula->id)
            ->with('success', 'Alumnos asignados correctamente.');
    }

    public function quitarAlumno(Aula $aula, \App\Models\Alumno $alumno)
    {
        // Verificar que el alumno pertenece a este aula
        if ($alumno->aula_id !== $aula->id) {
            return redirect()
                ->back()
                ->with('error', 'El alumno no pertenece a este aula.');
        }

        // Quitar alumno del aula (poner aula_id en null)
        $alumno->update(['aula_id' => null]);

        return redirect()
            ->route('admin.aulas.show', $aula->id)
            ->with('success', 'Alumno removido del aula correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();
        return redirect()->route('admin.aulas.index')->with('success', 'Aula eliminada.');
    }
}
