<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Aula;
use App\Models\FormatoDoce;
use App\Models\FormatoDoceAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FormatoDoceController extends Controller
{
    public function index()
    {
        $profesor = request()->user()->profesor;
        $formatos = FormatoDoce::query()
            ->whereHas('aula', fn ($query) => $query->where('profesor_id', $profesor->id))
            ->with(['aula.semestre'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profesor.formato-doce.index', compact('formatos'));
    }

    public function create()
    {
        $profesor = request()->user()->profesor;
        $aulas = Aula::with(['semestre', 'alumnos'])
            ->where('profesor_id', $profesor->id)
            ->whereHas('semestre', function ($query) {
                $query->where('activo', true);
            })
            ->get();

        return view('profesor.formato-doce.create', compact('aulas'));
    }

    public function getAlumnos(Aula $aula)
    {
        Gate::authorize('manage', $aula);

        $alumnos = Alumno::where('aula_id', $aula->id)
            ->select('id', 'codigo_matricula', 'nombres', 'apellido_paterno', 'apellido_materno')
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombres')
            ->get()
            ->map(function ($alumno) {
                return [
                    'id' => $alumno->id,
                    'codigo_matricula' => $alumno->codigo_matricula,
                    'nombre_completo' => $alumno->nombre_completo,
                ];
            });

        return response()->json($alumnos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'aula_id' => 'required|exists:aulas,id',
            'firma_coordinador' => 'required|string',
            'alumnos' => 'required|array|min:1',
            'alumnos.*.alumno_id' => 'required|exists:alumnos,id',
            'alumnos.*.nivel' => 'required|in:inicial,intermedio,avanzado',
            'alumnos.*.sede_practica' => 'required|string|max:255',
            'alumnos.*.responsable' => 'required|string|max:255',
            'alumnos.*.contacto_responsable' => 'required|string|max:255',
            'alumnos.*.al_dia' => 'required|boolean',
            'alumnos.*.observaciones' => 'nullable|string',
        ]);

        $aula = Aula::query()->findOrFail($request->integer('aula_id'));
        Gate::authorize('manage', $aula);

        DB::beginTransaction();
        try {
            // Guardar la firma
            $firmaData = $request->firma_coordinador;
            $firmaData = str_replace('data:image/png;base64,', '', $firmaData);
            $firmaData = str_replace(' ', '+', $firmaData);
            $firmaName = 'firma_'.time().'_'.uniqid().'.png';

            Storage::disk('public')->put(
                'firmas/formato-12/'.$firmaName,
                base64_decode($firmaData)
            );

            // Crear el formato
            $formato = FormatoDoce::create([
                'aula_id' => $request->aula_id,
                'firma_coordinador' => $firmaName,
            ]);

            // Crear los registros de alumnos
            foreach ($request->alumnos as $alumnoData) {
                FormatoDoceAlumno::create([
                    'formato_doce_id' => $formato->id,
                    'alumno_id' => $alumnoData['alumno_id'],
                    'nivel' => $alumnoData['nivel'],
                    'sede_practica' => $alumnoData['sede_practica'],
                    'responsable' => $alumnoData['responsable'],
                    'contacto_responsable' => $alumnoData['contacto_responsable'],
                    'al_dia' => $alumnoData['al_dia'],
                    'observaciones' => $alumnoData['observaciones'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('profesor.formato-doce.index')
                ->with('success', 'Formato 12 creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Error al crear el formato: '.$e->getMessage());
        }
    }

    public function show(FormatoDoce $formatoDoce)
    {
        Gate::authorize('manage', $formatoDoce->aula);

        $formato = $formatoDoce->load([
            'aula.semestre',
            'formatosDoceAlumnos.alumno',
        ]);

        return view('profesor.formato-doce.show', compact('formato'));
    }

    public function destroy(FormatoDoce $formatoDoce)
    {
        Gate::authorize('manage', $formatoDoce->aula);

        try {
            // Eliminar la firma
            if ($formatoDoce->firma_coordinador) {
                Storage::disk('public')->delete('firmas/formato-12/'.$formatoDoce->firma_coordinador);
            }

            $formatoDoce->delete();

            return redirect()->route('profesor.formato-doce.index')
                ->with('success', 'Formato 12 eliminado exitosamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el formato: '.$e->getMessage());
        }
    }
}
