<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Mail\CodigoVerificacionEmail;
use App\Models\SolicitudEmpresa;
use App\Models\RazonSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class EmpresaRegisterController extends Controller
{
    /**
     * Muestra el formulario de registro de empresa
     */
    public function create()
    {
        $razonesSociales = RazonSocial::all();
        return view('empresa.empresa-register', compact('razonesSociales'));
    }

    /**
     * Procesa el registro de la empresa y envía código de verificación
     */
    public function register(Request $request)
    {
        $request->validate([
            'ruc' => ['required', 'string', 'size:11', 'unique:empresas,ruc', 'unique:solicitudes_empresa,ruc'],
            'nombre' => ['required', 'string', 'max:255'],
            'razon_social_id' => ['required', 'exists:razones_sociales,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:solicitudes_empresa,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['nullable', 'string', 'size:9'],
            'departamento' => ['nullable', 'string', 'max:50'],
            'provincia' => ['nullable', 'string', 'max:50'],
            'distrito' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ]);

        // Generar código de verificación de 6 dígitos
        $codigoVerificacion = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Crear solicitud en la base de datos (sin email verificado aún)
        $solicitud = SolicitudEmpresa::create([
            'ruc' => $request->ruc,
            'nombre' => $request->nombre,
            'razon_social_id' => $request->razon_social_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'departamento' => $request->departamento,
            'provincia' => $request->provincia,
            'distrito' => $request->distrito,
            'direccion' => $request->direccion,
            'email_verificado' => false,
            'codigo_verificacion' => $codigoVerificacion,
            'estado' => 'pendiente',
        ]);

        // Guardar ID de solicitud en sesión para verificación
        Session::put('solicitud_empresa_id', $solicitud->id);

        // Enviar email con código de verificación
        try {
            Mail::to($request->email)->send(new CodigoVerificacionEmail($codigoVerificacion, $request->nombre));
        } catch (\Exception $e) {
            // Si falla el envío, eliminar la solicitud
            $solicitud->delete();
            Session::forget('solicitud_empresa_id');
            return back()->withErrors(['email' => 'Error al enviar el código de verificación. Verifica tu email.'])->withInput();
        }

        // Redirigir a la vista de verificación
        return redirect()->route('empresa.verify.form')->with('success', 'Código de verificación enviado a tu email');
    }

    /**
     * Muestra el formulario de verificación de código
     */
    public function showVerifyForm()
    {
        if (!Session::has('solicitud_empresa_id')) {
            return redirect()->route('login')->withErrors(['error' => 'No hay registro pendiente']);
        }

        $solicitud = SolicitudEmpresa::find(Session::get('solicitud_empresa_id'));

        if (!$solicitud || $solicitud->email_verificado) {
            Session::forget('solicitud_empresa_id');
            return redirect()->route('login')->withErrors(['error' => 'No hay registro pendiente']);
        }

        return view('empresa.verify-code', ['email' => $solicitud->email]);
    }

    /**
     * Verifica el código y marca la solicitud como verificada (NO crea el usuario aún)
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'string', 'size:6'],
        ]);

        $solicitudId = Session::get('solicitud_empresa_id');

        if (!$solicitudId) {
            return redirect()->route('login')->withErrors(['error' => 'Sesión expirada. Intenta registrarte nuevamente.']);
        }

        $solicitud = SolicitudEmpresa::find($solicitudId);

        if (!$solicitud) {
            Session::forget('solicitud_empresa_id');
            return redirect()->route('login')->withErrors(['error' => 'Solicitud no encontrada. Intenta registrarte nuevamente.']);
        }

        // Verificar código
        if ($request->codigo !== $solicitud->codigo_verificacion) {
            return back()->withErrors(['codigo' => 'Código de verificación incorrecto']);
        }

        // Marcar email como verificado (pero NO crear el usuario aún)
        $solicitud->update([
            'email_verificado' => true,
        ]);

        // Limpiar sesión
        Session::forget('solicitud_empresa_id');

        // Redirigir al login con mensaje de espera de aprobación
        return redirect()->route('login')->with('info', '¡Email verificado! Tu solicitud de registro está pendiente de aprobación por el administrador. Te notificaremos cuando sea aprobada.');
    }

    /**
     * Reenviar código de verificación
     */
    public function resendCode()
    {
        $solicitudId = Session::get('solicitud_empresa_id');

        if (!$solicitudId) {
            return redirect()->route('login')->withErrors(['error' => 'No hay registro pendiente']);
        }

        $solicitud = SolicitudEmpresa::find($solicitudId);

        if (!$solicitud) {
            Session::forget('solicitud_empresa_id');
            return redirect()->route('login')->withErrors(['error' => 'Solicitud no encontrada']);
        }

        // Generar nuevo código
        $codigoVerificacion = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $solicitud->update(['codigo_verificacion' => $codigoVerificacion]);

        // Reenviar email
        try {
            Mail::to($solicitud->email)->send(new CodigoVerificacionEmail($codigoVerificacion, $solicitud->nombre));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Error al reenviar el código de verificación.']);
        }

        return back()->with('success', 'Código de verificación reenviado a tu email');
    }
}
