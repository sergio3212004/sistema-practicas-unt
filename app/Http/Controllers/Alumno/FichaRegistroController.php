<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\FichaRegistroRequest;
use App\Mail\SolicitudFirmaEmpresaMail;
use App\Mail\SolicitudFirmaProgramaMail;
use App\Models\FichaRegistro;
use App\Models\FichaRegistroHorario;
use App\Models\RazonSocial;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\FirmaToken;
use App\Rules\Ruc;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class FichaRegistroController extends Controller
{
    /**
     * Listar fichas del alumno
     */
    public function index()
    {
        $alumno = Auth::user()->alumno;

        $ficha = FichaRegistro::with('cronograma')
            ->where('alumno_id', $alumno->id)
            ->first();

        return view('alumno.ficha-registro.index', compact('ficha'));
    }

    /**
     * Crear ficha (requiere código validado en sesión)
     */
    public function create(Request $request)
    {
        $alumno = Auth::user()->alumno;
        $semestreActual = Semestre::where('activo', true)->firstOrFail();
        $razonesSociales = RazonSocial::orderBy('acronimo')->get();

        return view('alumno.ficha-registro.create', compact(
            'alumno',
            'semestreActual',
            'razonesSociales'
        ));
    }

    public function store(FichaRegistroRequest $request)
    {
        $alumno = Auth::user()->alumno;

        DB::transaction(function () use ($request, $alumno) {

            /** --------------------------------
             * OBTENER RAZÓN SOCIAL
             * -------------------------------- */
            $razonSocial = \App\Models\RazonSocial::findOrFail($request->razon_social_id);

            $razonSocialCompleta = trim(
                $request->nombre_empresa . ' ' . $razonSocial->acronimo
            );

            /** -------------------------
             * GUARDAR FIRMA DEL ALUMNO
             * ------------------------- */
            $firmaBase64 = $request->firma_practicante;
            $firmaBase64 = str_replace('data:image/png;base64,', '', $firmaBase64);
            $firmaBase64 = str_replace(' ', '+', $firmaBase64);

            $nombreFirma = 'firma_alumno_' . $alumno->id . '_' . time() . '.png';
            Storage::disk('public')->put('firmas/ficha-registro/' . $nombreFirma, base64_decode($firmaBase64));

            /** -------------------------
             * CREAR FICHA
             * ------------------------- */
            $ficha = FichaRegistro::create([
                'alumno_id' => $alumno->id,
                'ciclo' => $request->ciclo,
                'semestre_id' => $request->semestre_id,
                'razon_social' => $razonSocialCompleta,
                'ruc' => $request->ruc,
                'correo_empresa' => $request->correo_empresa,
                'nombre_gerente' => $request->nombre_gerente,
                'nombre_jefe_rrhh' => $request->nombre_jefe_rrhh,
                'direccion' => $request->direccion,
                'telefono_fijo' => $request->telefono_fijo,
                'telefono_movil' => $request->telefono_movil,
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_termino' => $request->fecha_termino,
                'descripcion' => $request->descripcion,
                'area_practicas' => $request->area_practicas,
                'cargo' => $request->cargo,
                'nombre_jefe_directo' => $request->nombre_jefe_directo,
                'telefono_jefe_directo' => $request->telefono_jefe_directo,
                'correo_jefe_directo' => $request->correo_jefe_directo,
                'firma_practicante' => $nombreFirma,
                'aceptado' => null
            ]);

            /** -------------------------
             * GUARDAR HORARIOS
             * ------------------------- */
            foreach ($request->horarios as $horario) {
                FichaRegistroHorario::create([
                    'ficha_registro_id' => $ficha->id,
                    'dia_semana' => $horario['dia_semana'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fin' => $horario['hora_fin'],
                ]);
            }


            // ==========================
            // GENERAR TOKENS DE FIRMA
            // ==========================

            // Empresa
            $tokenEmpresa = FirmaToken::create([
                'ficha_registro_id' => $ficha->id,
                'email' => $request->correo_empresa,
                'tipo' => 'empresa',
                'token' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);

            // Jefe directo
            $tokenJefe = FirmaToken::create([
                'ficha_registro_id' => $ficha->id,
                'email' => $request->correo_jefe_directo,
                'tipo' => 'jefe_directo',
                'token' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);

            Mail::to($tokenEmpresa->email)
                ->send(new SolicitudFirmaEmpresaMail($tokenEmpresa));
            Mail::to($tokenJefe->email)
                ->send(new SolicitudFirmaProgramaMail($tokenJefe));
        });


        // Limpiar sesión de código
        session()->forget('codigo_ficha_validado');

        return redirect()
            ->route('alumno.ficha.index')
            ->with('success', 'Ficha registrada correctamente. Las firmas han sido solicitadas.');
    }

    public function show(FichaRegistro $fichaRegistro)
    {
        if ($fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Cargar relaciones necesarias
        $fichaRegistro->load([
            'horarios',
            'firmaTokens', // si los tienes
        ]);

        return view('alumno.ficha-registro.show', compact('fichaRegistro'));
    }

    public function destroy(FichaRegistro $fichaRegistro)
    {
        // Verificar que el alumno sea el dueño de la ficha
        if ($fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Verificar que la ficha no esté aceptada
        if ($fichaRegistro->aceptado) {
            return redirect()
                ->route('alumno.ficha.show', $fichaRegistro)
                ->with('error', 'No puedes eliminar una ficha que ya ha sido aceptada.');
        }

        DB::transaction(function () use ($fichaRegistro) {
            // Eliminar firmas del storage si existen
            if ($fichaRegistro->firma_practicante) {
                Storage::disk('public')->delete('firmas/ficha-registro/' . $fichaRegistro->firma_practicante);
            }
            if ($fichaRegistro->firma_empresa) {
                Storage::disk('public')->delete('firmas/ficha-registro/' . $fichaRegistro->firma_empresa);
            }
            if ($fichaRegistro->firma_programa) {
                Storage::disk('public')->delete('firmas/ficha-registro/' . $fichaRegistro->firma_programa);
            }

            // Eliminar tokens de firma asociados
            $fichaRegistro->firmaTokens()->delete();

            // Eliminar horarios asociados
            $fichaRegistro->horarios()->delete();

            // Eliminar la ficha
            $fichaRegistro->delete();
        });

        return redirect()
            ->route('alumno.ficha.index')
            ->with('success', 'Ficha de registro eliminada correctamente.');
    }


    public function downloadPdf(FichaRegistro $fichaRegistro)
    {
        // Verificar que el alumno sea el dueño de la ficha
        if ($fichaRegistro->alumno_id !== auth()->user()->alumno->id) {
            abort(403);
        }

        // Cargar relaciones necesarias
        $fichaRegistro->load([
            'alumno.user',
            'alumno.aula',
            'semestre',
            'horarios',
        ]);

        // Generar PDF
        $pdf = Pdf::loadView('alumno.ficha-registro.pdf', compact('fichaRegistro'));

        // Configurar el PDF
        $pdf->setPaper('a4', 'portrait');

        // Nombre del archivo
        $nombreArchivo = 'FichaDeRegistro_' . $fichaRegistro->alumno->codigo_matricula . '.pdf';

        // Descargar el PDF
        return $pdf->download($nombreArchivo);
    }

}
