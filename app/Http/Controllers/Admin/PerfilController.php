<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\Profesor;
use App\Models\SolicitudEmpresa;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    //
    /**
     * Ver perfil de una empresa
     */
    public function empresa($id)
    {
        $empresa = Empresa::with(['user', 'razonSocial', 'publicaciones'])
            ->findOrFail($id);

        return view('admin.perfiles.empresa', compact('empresa'));
    }

    /**
     * Ver detalle de una solicitud de empresa
     */
    public function solicitudEmpresa($id)
    {
        $solicitud = SolicitudEmpresa::with('razonSocial')
            ->findOrFail($id);

        return view('admin.perfiles.solicitud-empresa', compact('solicitud'));
    }
}
