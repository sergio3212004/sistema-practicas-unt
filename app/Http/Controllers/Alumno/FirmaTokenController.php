<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\FirmaToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FirmaTokenController extends Controller
{
    //
    public function show($token)
    {
        $firmaToken = FirmaToken::where('token', $token)
            ->whereNull('signed_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('firmas.firmar', compact('firmaToken'));
    }

    public function store(Request $request, $token)
    {
        $firmaToken = FirmaToken::where('token', $token)
            ->whereNull('signed_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $request->validate([
            'firma' => 'required|string'
        ]);

        // Guardar firma
        $firmaBase64 = str_replace('data:image/png;base64,', '', $request->firma);
        $firmaBase64 = str_replace(' ', '+', $firmaBase64);

        $nombre = 'firma_' . $firmaToken->tipo . '_' . time() . '.png';
        Storage::disk('public')->put("firmas/ficha-registro/$nombre", base64_decode($firmaBase64));

        // Guardar en ficha según tipo
        $ficha = $firmaToken->ficha;

        if ($firmaToken->tipo === 'empresa') {
            $ficha->firma_empresa = $nombre;
        }

        if ($firmaToken->tipo === 'jefe_directo') {
            $ficha->firma_programa = $nombre;
        }

        $ficha->save();

        // Marcar token como firmado
        $firmaToken->update([
            'signed_at' => now()
        ]);

        return view('firmas.gracias');
    }
}
