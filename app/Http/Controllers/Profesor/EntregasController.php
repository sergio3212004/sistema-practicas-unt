<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesor\GradeEntregaRequest;
use App\Models\Entrega;
use Illuminate\Http\RedirectResponse;

class EntregasController extends Controller
{
    public function calificar(GradeEntregaRequest $request, Entrega $entrega): RedirectResponse
    {
        $entrega->update([
            ...$request->validated(),
            'estado' => 'observado',
        ]);

        return back()->with('success', 'Entrega calificada exitosamente.');
    }
}
