<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\FirmaTokenCronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FirmaCronogramaController extends Controller
{
    //
    public function formJefe(string $token)
    {
        $firmaToken = FirmaTokenCronograma::with([
            'cronograma.fichaRegistro.alumno.user',
            'cronograma.actividades'
        ])
            ->where('token', $token)
            ->where('rol', 'jefe_directo')
            ->vigente()
            ->firstOrFail();

        $cronograma = $firmaToken->cronograma;

        return view('firmas.cronograma.jefe', compact(
            'firmaToken',
            'cronograma'
        ));
    }

    public function guardarFirmaJefe(Request $request, string $token)
    {
        $request->validate([
            'firma' => 'required|string',
        ]);

        $firmaToken = FirmaTokenCronograma::where('token', $token)
            ->vigente()
            ->rol('jefe_directo')
            ->firstOrFail();

        $cronograma = $firmaToken->cronograma;

        $rutaFirma = $this->guardarFirma(
            $request->firma,
            'jefe',
            $cronograma->id
        );

        $cronograma->update([
            'firma_jefe_directo' => $rutaFirma,
        ]);

        $firmaToken->marcarComoUsado();

        return view('firmas.firma-exitosa');
    }

    private function guardarFirma(string $base64, string $tipo, int $cronogramaId): string
    {
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        $base64 = str_replace(' ', '+', $base64);

        $ruta = "firmas/cronogramas/cronograma_{$cronogramaId}_{$tipo}.png";

        Storage::disk('public')->put($ruta, base64_decode($base64));

        return $ruta;
    }
}
