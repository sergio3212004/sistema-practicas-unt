<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Cronograma;
use App\Models\CronogramaActividad;
use App\Models\FichaRegistro;
use App\Models\FirmaTokenCronograma;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CronogramaController extends Controller
{
    /**
     * Mostrar formulario create
     */
    public function create(FichaRegistro $fichaRegistro)
    {
        return view('alumno.cronograma.create', compact('fichaRegistro'));
    }

    /**
     * Guardar cronograma
     */
    public function store(Request $request, FichaRegistro $fichaRegistro)
    {
        $request->validate([
            'firma_practicante' => 'required|string',
            'actividades' => 'required|array|min:1|max:5',
            'actividades.*.nombre' => 'required|string|max:1000',
            'actividades.*.semanas' => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            /** ==========================
             * 1. Crear cronograma
             * ========================== */
            $cronograma = Cronograma::create([
                'ficha_id' => $fichaRegistro->id,
                'firma_practicante' => null, // se actualiza luego
                'firma_jefe_directo' => null,
                'firma_profesor' => null,
            ]);

            /** ==========================
             * 2. Guardar firma del alumno
             * ========================== */
            $firmaPath = $this->guardarFirma(
                $request->firma_practicante,
                'practicante',
                $cronograma->id
            );

            $cronograma->update([
                'firma_practicante' => $firmaPath,
            ]);

            /** ==========================
             * 3. Guardar actividades
             * ========================== */
            foreach ($request->actividades as $actividad) {

                $dataActividad = [
                    'cronograma_id' => $cronograma->id,
                    'actividad' => $actividad['nombre'],
                ];

                // Inicializar todas las semanas en false
                for ($m = 1; $m <= 4; $m++) {
                    for ($s = 1; $s <= 4; $s++) {
                        $dataActividad["m{$m}_s{$s}"] = false;
                    }
                }

                // Marcar las semanas seleccionadas
                foreach ($actividad['semanas'] as $semana) {
                    // Ejemplo: m1_s2
                    $dataActividad[$semana] = true;
                }

                CronogramaActividad::create($dataActividad);

            }

            /** 4. Crear token para JEFE DIRECTO (UNA SOLA VEZ) */
            $token = Str::uuid();

            $firmaToken = FirmaTokenCronograma::create([
                'cronograma_id' => $cronograma->id,
                'email' => $fichaRegistro->correo_jefe_directo,
                'token' => $token,
                'rol' => 'jefe_directo',
                'expira_en' => now()->addDays(5),
            ]);

            /** 5. Enviar correo */
            Mail::to($firmaToken->email)
                ->send(new \App\Mail\FirmaCronogramaJefeMail($firmaToken));


            DB::commit();

            return redirect()
                ->route('alumno.cronograma.show', $cronograma)
                ->with('success', 'Cronograma creado y firmado correctamente');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar el cronograma');
        }
    }

    /**
     * Mostrar cronograma
     */
    public function show(Cronograma $cronograma)
    {
        $cronograma->load([
            'fichaRegistro.alumno.user',
            'actividades'
        ]);

        return view('alumno.cronograma.show', compact('cronograma'));
    }


    /**
     * Eliminar cronograma (solo si el profesor no ha firmado)
     */
    public function destroy(Cronograma $cronograma)
    {
        // Validar que el alumno sea el dueño
        if ($cronograma->fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Validar que el profesor supervisor no haya firmado
        if ($cronograma->firma_profesor) {
            return back()->with('error', 'No puedes eliminar un cronograma ya firmado por el profesor supervisor.');
        }

        // Eliminar archivos de firmas
        if ($cronograma->firma_practicante) {
            Storage::disk('public')->delete($cronograma->firma_practicante);
        }
        if ($cronograma->firma_jefe_directo) {
            Storage::disk('public')->delete($cronograma->firma_jefe_directo);
        }

        // Eliminar relaciones y el cronograma
        $cronograma->actividades()->delete();
        $cronograma->tokensFirma()->delete();
        $cronograma->delete();

        return redirect()
            ->route('alumno.ficha.index')
            ->with('success', 'Cronograma eliminado correctamente.');
    }

    /**
     * Guardar firma base64
     */
    private function guardarFirma(string $firmaBase64, string $tipo, int $cronogramaId): string
    {
        // Limpiar encabezado base64
        $firmaBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $firmaBase64);
        $firmaBase64 = str_replace(' ', '+', $firmaBase64);

        $imageData = base64_decode($firmaBase64);

        $nombreArchivo = "cronograma_{$cronogramaId}_{$tipo}.png";
        $ruta = "firmas/cronogramas/{$nombreArchivo}";

        Storage::disk('public')->put($ruta, $imageData);

        return $ruta; // se guarda como string en BD
    }

    /**
     * Descargar Cronograma en PDF
     */
    public function downloadPdf(Cronograma $cronograma)
    {
        // Verificar que el alumno sea el dueño del cronograma
        // (A través de la ficha de registro)
        if ($cronograma->fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Cargar relaciones necesarias
        $cronograma->load([
            'fichaRegistro.alumno.user',
            'actividades'
        ]);

        // Generar PDF
        $pdf = Pdf::loadView('alumno.cronograma.pdf', compact('cronograma'));

        // Configurar el PDF
        $pdf->setPaper('a4', 'portrait');

        // Nombre del archivo
        $nombreArchivo = 'PlanDePracticas_' . $cronograma->fichaRegistro->alumno->codigo_matricula . '.pdf';

        // Descargar el PDF
        return $pdf->download($nombreArchivo);
    }

}
