<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesor\GradeEntregaRequest;
use App\Models\Entrega;
use Illuminate\Http\RedirectResponse;

class EntregasController extends Controller
{
    public function download(Entrega $entrega)
    {
        \Illuminate\Support\Facades\Gate::authorize('grade', $entrega);
        abort_if(! $entrega->ruta || str_starts_with($entrega->ruta, '{'), 404);
        return \Illuminate\Support\Facades\Storage::disk($entrega->disco ?? 'public')->download($entrega->ruta);
    }

    public function calificar(GradeEntregaRequest $request, Entrega $entrega): RedirectResponse
    {
        $entrega->update([
            ...$request->validated(),
            'estado' => 'observado',
        ]);

        return back()->with('success', 'Entrega calificada exitosamente.');
    }
}
