<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumno\StoreEntregaRequest;
use App\Http\Requests\Alumno\UpdateEntregaRequest;
use App\Models\Actividad;
use App\Models\Entrega;
use App\Services\GoogleDriveService;
use App\View\Presenters\EntregaPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EntregaController extends Controller
{
    public function __construct(
        private readonly GoogleDriveService $drive,
    ) {}

    /**
     * Mostrar el formulario para crear una nueva entrega
     */
    public function create(Request $request, Actividad $actividad)
    {
        Gate::authorize('submit', $actividad);
        $alumno = $request->user()->alumno;

        // Verificar que la actividad no esté vencida
        if ($actividad->estaVencida()) {
            return redirect()->back()->with('error', 'Esta actividad ya venció. No puedes realizar entregas.');
        }

        // Verificar si ya existe una entrega
        $entregaExistente = Entrega::where('actividad_id', $actividad->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if ($entregaExistente) {
            return redirect()->route('alumno.entregas.show', $entregaExistente)
                ->with('info', 'Ya realizaste una entrega para esta actividad.');
        }

        // Cargar relaciones necesarias
        $actividad->load(['tipoActividad', 'semana', 'aula']);

        // Si es modo drive, verificar conexión
        $driveConectado = false;
        if ($actividad->tipoActividad->modo_entrega === 'drive') {
            $driveConectado = $this->drive->isConnected();
        }

        return view('alumno.entregas.create', compact('actividad', 'driveConectado'));
    }

    /**
     * Almacenar una nueva entrega
     */
    public function store(StoreEntregaRequest $request, Actividad $actividad)
    {
        $alumno = $request->user()->alumno;

        if ($actividad->estaVencida()) {
            return redirect()->back()->with('error', 'Esta actividad ya venció. No puedes realizar entregas.');
        }

        // Verificar si ya existe una entrega
        $entregaExistente = Entrega::where('actividad_id', $actividad->id)
            ->where('alumno_id', $alumno->id)
            ->first();

        if ($entregaExistente) {
            return redirect()->route('alumno.entregas.show', $entregaExistente)
                ->with('error', 'Ya realizaste una entrega para esta actividad.');
        }

        $modoEntrega = $actividad->tipoActividad->modo_entrega;
        $ruta = null;

        // Validar según el modo de entrega
        if ($modoEntrega === 'pdf') {
            // Guardar el archivo
            $archivo = $request->file('archivo');
            $nombreArchivo = time().'_'.$alumno->id.'_'.$actividad->id.'.'.$archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('entregas', $nombreArchivo, 'public');

        } elseif ($modoEntrega === 'drive') {
            // Verificar que el archivo existe y es accesible
            try {
                $driveInfo = $this->drive->fileMetadata(
                    $request->string('drive_file_id')->value(),
                    $request->string('drive_file_name')->value(),
                );

                if (! $driveInfo['web_view_link']) {
                    return redirect()->back()
                        ->with('error', 'El archivo de Google Drive no tiene un enlace público accesible.')
                        ->withInput();
                }

                $ruta = json_encode($driveInfo, JSON_THROW_ON_ERROR);

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'No se pudo verificar el archivo de Google Drive. Verifica que el archivo existe y tienes permisos.')
                    ->withInput();
            }
        }

        // Crear la entrega
        $entrega = Entrega::create([
            'actividad_id' => $actividad->id,
            'alumno_id' => $alumno->id,
            'ruta' => $ruta,
            'estado' => 'entregado',
            'observaciones' => null,
            'fecha_entrega' => now(),
        ]);

        return redirect()->route('alumno.aula.index', $actividad->aula_id)
            ->with('success', '¡Entrega realizada exitosamente!');
    }

    /**
     * Mostrar los detalles de una entrega específica
     */
    public function show(Entrega $entrega, EntregaPresenter $presenter)
    {
        Gate::authorize('manage', $entrega);

        // Cargar relaciones
        $entrega->load([
            'actividad.tipoActividad',
            'actividad.semana',
            'actividad.aula',
            'alumno.user',
        ]);

        // Si es una entrega de Drive, decodificar la información
        $driveInfo = null;
        if ($entrega->actividad->tipoActividad->modo_entrega === 'drive') {
            $driveInfo = json_decode($entrega->ruta, true);
        }

        return view('alumno.entregas.show', [
            'entrega' => $entrega,
            'driveInfo' => $driveInfo,
            'estadoEntrega' => $presenter->estado($entrega),
        ]);
    }

    /**
     * Mostrar el formulario para editar/reenviar una entrega
     */
    public function edit(Entrega $entrega)
    {
        Gate::authorize('manage', $entrega);

        // Verificar que la actividad no esté vencida
        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'La actividad ya venció. No puedes modificar la entrega.');
        }

        // Solo permitir edición si está en estado 'rechazado' o 'observado'
        if (! in_array($entrega->estado, ['rechazado', 'observado'])) {
            return redirect()->back()->with('error', 'No puedes modificar esta entrega en su estado actual.');
        }

        // Cargar relaciones
        $entrega->load([
            'actividad.tipoActividad',
            'actividad.semana',
        ]);

        // Si es modo drive, verificar conexión
        $driveConectado = false;
        $driveInfo = null;
        if ($entrega->actividad->tipoActividad->modo_entrega === 'drive') {
            $driveConectado = $this->drive->isConnected();
            $driveInfo = json_decode($entrega->ruta, true);
        }

        return view('alumno.entregas.edit', compact('entrega', 'driveConectado', 'driveInfo'));
    }

    /**
     * Actualizar una entrega existente
     */
    public function update(UpdateEntregaRequest $request, Entrega $entrega)
    {
        $alumno = $request->user()->alumno;

        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'La actividad ya venció. No puedes modificar la entrega.');
        }

        if (! in_array($entrega->estado, ['rechazado', 'observado'])) {
            return redirect()->back()->with('error', 'No puedes modificar esta entrega en su estado actual.');
        }

        $modoEntrega = $entrega->actividad->tipoActividad->modo_entrega;
        $ruta = null;

        // Validar según el modo de entrega
        if ($modoEntrega === 'pdf') {
            // Eliminar archivo anterior si existe
            $oldInfo = json_decode($entrega->ruta, true);
            if (! isset($oldInfo['type']) || $oldInfo['type'] !== 'drive') {
                if ($entrega->ruta && Storage::disk('public')->exists($entrega->ruta)) {
                    Storage::disk('public')->delete($entrega->ruta);
                }
            }

            // Guardar nuevo archivo
            $archivo = $request->file('archivo');
            $nombreArchivo = time().'_'.$alumno->id.'_'.$entrega->actividad_id.'.'.$archivo->getClientOriginalExtension();
            $ruta = $archivo->storeAs('entregas', $nombreArchivo, 'public');

        } elseif ($modoEntrega === 'drive') {
            try {
                $ruta = json_encode(
                    $this->drive->fileMetadata(
                        $request->string('drive_file_id')->value(),
                        $request->string('drive_file_name')->value(),
                    ),
                    JSON_THROW_ON_ERROR,
                );

            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'No se pudo verificar el archivo de Google Drive.')
                    ->withInput();
            }
        }

        // Actualizar la entrega
        $entrega->update([
            'ruta' => $ruta,
            'estado' => 'entregado',
            'observaciones' => $request->observaciones,
            'fecha_entrega' => now(),
            'nota' => null,
        ]);

        return redirect()->route('alumno.entregas.show', $entrega)
            ->with('success', '¡Entrega actualizada exitosamente!');
    }

    /**
     * Descargar el archivo de una entrega o redirigir a Google Drive
     */
    public function download(Request $request, Entrega $entrega)
    {
        Gate::authorize('manage', $entrega);
        $alumno = $request->user()->alumno;

        // Verificar si es una entrega de Drive
        $driveInfo = json_decode($entrega->ruta, true);
        if (isset($driveInfo['type']) && $driveInfo['type'] === 'drive') {
            // Redirigir a Google Drive
            if (isset($driveInfo['web_view_link'])) {
                return redirect($driveInfo['web_view_link']);
            }

            return redirect()->back()->with('error', 'No se encontró el enlace de Google Drive.');
        }

        // Es un archivo normal, descargarlo
        if (! $entrega->ruta || ! Storage::disk('public')->exists($entrega->ruta)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }

        $extension = pathinfo($entrega->ruta, PATHINFO_EXTENSION);
        $nombreDescarga = 'Entrega_'.$entrega->actividad->titulo.'_'.$alumno->codigo_matricula.'.'.$extension;

        return Storage::disk('public')->download($entrega->ruta, $nombreDescarga);
    }

    /**
     * Eliminar una entrega (solo si no ha sido calificada)
     */
    public function destroy(Entrega $entrega)
    {
        Gate::authorize('manage', $entrega);

        // No permitir eliminar si ya fue calificada
        if ($entrega->estaCalificada()) {
            return redirect()->back()->with('error', 'No puedes eliminar una entrega que ya fue calificada.');
        }

        // Verificar que la actividad no esté vencida
        if ($entrega->actividad->estaVencida()) {
            return redirect()->back()->with('error', 'No puedes eliminar la entrega de una actividad vencida.');
        }

        $aulaId = $entrega->actividad->aula_id;

        // Eliminar archivo solo si no es de Drive
        $driveInfo = json_decode($entrega->ruta, true);
        if (! isset($driveInfo['type']) || $driveInfo['type'] !== 'drive') {
            if ($entrega->ruta && Storage::disk('public')->exists($entrega->ruta)) {
                Storage::disk('public')->delete($entrega->ruta);
            }
        }

        // Eliminar registro
        $entrega->delete();

        return redirect()->route('alumno.aula.index', $aulaId)
            ->with('success', 'Entrega eliminada exitosamente.');
    }
}
