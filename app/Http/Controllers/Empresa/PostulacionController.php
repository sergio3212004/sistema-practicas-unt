<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Postulacion;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostulacionController extends Controller
{
    //
    use AuthorizesRequests;
    public function index() {
        $empresa = auth()->user()->empresa;

        $publicaciones = Publicacion::query()
            ->where('empresa_id', $empresa->id)
            ->withCount('postulaciones')
            ->latest()
            ->get();

        return view('empresa.postulaciones.index', compact('publicaciones', 'empresa'));
    }

    public function show(Publicacion $publicacion)
    {

        $postulaciones = $publicacion->postulaciones()
            ->with(['alumno.user']) // Eager loading para optimizar
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('empresa.postulaciones.show', compact('publicacion', 'postulaciones'));
    }

    public function aprobar(Postulacion $postulacion)
    {
        $postulacion->update([
            'aprobado' => true,
        ]);

        return back()->with('success', 'Postulación aprobada correctamente.');
    }

    public function rechazar(Postulacion $postulacion)
    {
        // Verificar que la postulación esté pendiente
        if ($postulacion->aprobado !== null) {
            return back()->with('warning', 'Esta postulación ya fue procesada anteriormente.');
        }

        // Actualizar el estado de la postulación
        $postulacion->update([
            'aprobado' => false,
        ]);

        // Opcional: Enviar notificación al alumno
        // $postulacion->alumno->user->notify(new PostulacionRechazada($postulacion));

        return back()->with('info', 'Postulación rechazada. El alumno ha sido notificado.');
    }

}
