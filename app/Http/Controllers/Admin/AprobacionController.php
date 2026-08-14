<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Companies\ApproveCompanyApplication;
use App\Http\Controllers\Controller;
use App\Models\SolicitudEmpresa;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class AprobacionController extends Controller
{
    public function index(): View
    {
        $solicitudesPendientes = SolicitudEmpresa::query()
            ->with('razonSocial')
            ->pendientes()
            ->latest()
            ->paginate(10);

        return view('admin.aprobaciones.index', compact('solicitudesPendientes'));
    }

    public function aprobar(
        SolicitudEmpresa $solicitud,
        ApproveCompanyApplication $approveCompany,
    ): RedirectResponse {
        try {
            $approveCompany->handle($solicitud);
        } catch (DomainException $exception) {
            return redirect()
                ->route('admin.aprobaciones.index')
                ->with('error', $exception->getMessage());
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.aprobaciones.index')
                ->with('error', 'No se pudo aprobar la empresa. Inténtalo nuevamente.');
        }

        return redirect()
            ->route('admin.aprobaciones.index')
            ->with('success', "Empresa '{$solicitud->nombre}' aprobada exitosamente. El usuario ya puede iniciar sesión.");
    }

    public function rechazar(Request $request, SolicitudEmpresa $solicitud): RedirectResponse
    {
        if ($solicitud->estado !== 'pendiente') {
            return redirect()
                ->route('admin.aprobaciones.index')
                ->with('error', 'Esta solicitud ya fue procesada.');
        }

        $solicitud->update([
            'estado' => 'rechazado',
            'motivo_rechazo' => $request->string('motivo')->trim()->value()
                ?: 'Solicitud rechazada por el administrador',
        ]);

        return redirect()
            ->route('admin.aprobaciones.index')
            ->with('success', "Solicitud de '{$solicitud->nombre}' rechazada.");
    }
}
