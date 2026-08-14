<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\FormatoOnce;
use App\Models\FormatoOnceAlumno;
use App\Models\Aula;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class FormatoOnceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        // Obtener aulas del profesor con sus formatos (hasMany)
        $aulas = Aula::where('profesor_id', $profesor->id)
            ->with(['semestre', 'alumnos', 'formatosOnce'])
            ->get();

        return view('profesor.formato-once.index', compact('aulas'));
    }

    /**
     * Mostrar lista de formatos de un aula
     */
    public function list($aulaId)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        $aula = Aula::with(['semestre', 'formatosOnce' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])
            ->where('id', $aulaId)
            ->where('profesor_id', $profesor->id)
            ->firstOrFail();

        return view('profesor.formato-once.list', compact('aula'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($aulaId)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No tiene permisos para acceder a esta sección');
        }

        $aula = Aula::with(['semestre', 'alumnos'])
            ->where('id', $aulaId)
            ->where('profesor_id', $profesor->id)
            ->firstOrFail();

        // Verificar que el aula tenga alumnos
        if ($aula->alumnos->count() === 0) {
            return redirect()->route('profesor.formato-once.index')
                ->with('error', 'El aula no tiene alumnos asignados');
        }

        return view('profesor.formato-once.create', compact('aula'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $aulaId)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return redirect()->back()->with('error', 'No tiene permisos para realizar esta acción');
        }

        $aula = Aula::where('id', $aulaId)
            ->where('profesor_id', $profesor->id)
            ->firstOrFail();

        // Validación personalizada para ciclo_nivel
        $request->validate([
            'firma_coordinador' => 'required|string',
            'alumnos' => 'required|array',
            'alumnos.*.alumno_id' => 'required|exists:alumnos,id',
            'alumnos.*.sede_practicas' => 'required|string',
            'alumnos.*.ciclo_nivel' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Expresión regular: número seguido de / y luego inicial|intermedio|final
                    if (!preg_match('/^\d+\/(inicial|intermedio|final)$/i', $value)) {
                        $fail('El formato de ' . $attribute . ' debe ser "número/nivel", donde nivel es "inicial", "intermedio" o "final". Ej: "8/inicial".');
                    }
                }
            ],
            'alumnos.*.competencias' => 'nullable|string',
            'alumnos.*.capacidades' => 'nullable|string',
            'alumnos.*.actividades' => 'nullable|string',
            'alumnos.*.producto' => 'nullable|string',
            'alumnos.*.conformidad' => 'required|boolean',
            'alumnos.*.comentarios' => 'nullable|string',
        ]);

        $firmaPath = $this->guardarFirma($request->firma_coordinador);

        $formatoOnce = FormatoOnce::create([
            'aula_id' => $aula->id,
            'firma_coordinador' => $firmaPath,
        ]);

        foreach ($request->alumnos as $alumnoData) {
            FormatoOnceAlumno::create([
                'formato_once_id' => $formatoOnce->id,
                'alumno_id' => $alumnoData['alumno_id'],
                'sede_practicas' => $alumnoData['sede_practicas'],
                'ciclo_nivel' => $alumnoData['ciclo_nivel'],
                'competencias' => $alumnoData['competencias'] ?? null,
                'capacidades' => $alumnoData['capacidades'] ?? null,
                'actividades' => $alumnoData['actividades'] ?? null,
                'producto' => $alumnoData['producto'] ?? null,
                'conformidad' => $alumnoData['conformidad'],
                'comentarios' => $alumnoData['comentarios'] ?? null,
            ]);
        }

        return redirect()->route('profesor.formato-once.list', $aula->id)
            ->with('success', 'Formato Once creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(FormatoOnce $formatoOnce)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $formatoOnce->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para ver este formato');
        }

        $formatoOnce->load(['aula.semestre', 'formatoOnceAlumnos.alumno']);

        return view('profesor.formato-once.show', compact('formatoOnce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormatoOnce $formatoOnce)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $formatoOnce->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para editar este formato');
        }

        $aula = $formatoOnce->aula()->with(['semestre', 'alumnos'])->first();
        $formatoOnce->load('formatoOnceAlumnos.alumno');

        return view('profesor.formato-once.edit', compact('formatoOnce', 'aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormatoOnce $formatoOnce)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $formatoOnce->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para actualizar este formato');
        }

        $request->validate([
            'firma_coordinador' => 'nullable|string',
            'alumnos' => 'required|array',
            'alumnos.*.alumno_id' => 'required|exists:alumnos,id',
            'alumnos.*.sede_practicas' => 'required|string',
            'alumnos.*.ciclo_nivel' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+\/(inicial|intermedio|final)$/i', $value)) {
                        $fail('El formato de ' . $attribute . ' debe ser "número/nivel", donde nivel es "inicial", "intermedio" o "final". Ej: "8/inicial".');
                    }
                }
            ],
            'alumnos.*.competencias' => 'nullable|string',
            'alumnos.*.capacidades' => 'nullable|string',
            'alumnos.*.actividades' => 'nullable|string',
            'alumnos.*.producto' => 'nullable|string',
            'alumnos.*.conformidad' => 'required|boolean',
            'alumnos.*.comentarios' => 'nullable|string',
        ]);

        if ($request->filled('firma_coordinador')) {
            if ($formatoOnce->firma_coordinador && Storage::disk('public')->exists($formatoOnce->firma_coordinador)) {
                Storage::disk('public')->delete($formatoOnce->firma_coordinador);
            }
            $firmaPath = $this->guardarFirma($request->firma_coordinador);
            $formatoOnce->update(['firma_coordinador' => $firmaPath]);
        }

        $formatoOnce->formatoOnceAlumnos()->delete();

        foreach ($request->alumnos as $alumnoData) {
            FormatoOnceAlumno::create([
                'formato_once_id' => $formatoOnce->id,
                'alumno_id' => $alumnoData['alumno_id'],
                'sede_practicas' => $alumnoData['sede_practicas'],
                'ciclo_nivel' => $alumnoData['ciclo_nivel'],
                'competencias' => $alumnoData['competencias'] ?? null,
                'capacidades' => $alumnoData['capacidades'] ?? null,
                'actividades' => $alumnoData['actividades'] ?? null,
                'producto' => $alumnoData['producto'] ?? null,
                'conformidad' => $alumnoData['conformidad'],
                'comentarios' => $alumnoData['comentarios'] ?? null,
            ]);
        }

        return redirect()->route('profesor.formato-once.list', $formatoOnce->aula_id)
            ->with('success', 'Formato Once actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormatoOnce $formatoOnce)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $formatoOnce->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para eliminar este formato');
        }

        $aulaId = $formatoOnce->aula_id;

        // Eliminar la firma del storage
        if ($formatoOnce->firma_coordinador && Storage::disk('public')->exists($formatoOnce->firma_coordinador)) {
            Storage::disk('public')->delete($formatoOnce->firma_coordinador);
        }

        // Eliminar el formato (los alumnos se eliminan en cascada si está configurado)
        $formatoOnce->delete();

        return redirect()->route('profesor.formato-once.list', $aulaId)
            ->with('success', 'Formato Once eliminado exitosamente');
    }

    /**
     * Guardar la firma digital como imagen
     */
    private function guardarFirma($firmaBase64)
    {
        // Extraer el tipo de imagen y los datos
        $image = str_replace('data:image/png;base64,', '', $firmaBase64);
        $image = str_replace(' ', '+', $image);
        $imageData = base64_decode($image);

        // Generar nombre único para la imagen
        $fileName = 'firma_' . Str::random(20) . '_' . time() . '.png';
        $filePath = 'firmas/formato-once/' . $fileName;

        // Guardar en storage público
        Storage::disk('public')->put($filePath, $imageData);

        return $filePath;
    }

    /**
     * Generar PDF del formato once
     */
    public function generatePdf(FormatoOnce $formatoOnce)
    {
        $profesor = Auth::user()->profesor;

        if (!$profesor || $formatoOnce->aula->profesor_id !== $profesor->id) {
            return redirect()->back()->with('error', 'No tiene permisos para descargar este formato');
        }

        $formatoOnce->load(['aula.semestre', 'aula.profesor', 'formatoOnceAlumnos.alumno.fichaActual']);

        // Generar el PDF
        $pdf = Pdf::loadView('profesor.formato-once.pdf', compact('formatoOnce'));

        // Configurar orientación horizontal (landscape)
        $pdf->setPaper('A4', 'landscape');

        // Nombre del archivo
        $fileName = 'Formato_11_Aula_' . $formatoOnce->aula->numero . '_' . date('Y-m-d') . '.pdf';

        // Descargar el PDF
        return $pdf->download($fileName);
    }

}
