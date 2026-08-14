<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Empresa\StorePublicacionRequest;
use App\Http\Requests\Empresa\UpdatePublicacionRequest;
use App\Models\Publicacion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicacionController extends Controller
{
    public function index(Request $request): View
    {
        $empresa = $request->user()->empresa;
        $publicaciones = $empresa->publicaciones()->latest()->get();

        return view('empresa.publicaciones.index', compact('publicaciones', 'empresa'));
    }

    public function create(): View
    {
        return view('empresa.publicaciones.create');
    }

    public function store(StorePublicacionRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('imagen');
        $data['imagen'] = $request->file('imagen')?->store('publicaciones', 'public')
            ?? 'images/img.png';

        $request->user()->empresa->publicaciones()->create($data);

        return redirect()
            ->route('empresa.publicaciones.index')
            ->with('success', 'Publicación creada correctamente.');
    }

    public function edit(Publicacion $publicacion): View
    {
        Gate::authorize('manage', $publicacion);

        return view('empresa.publicaciones.edit', compact('publicacion'));
    }

    public function update(
        UpdatePublicacionRequest $request,
        Publicacion $publicacion,
    ): RedirectResponse {
        $data = $request->safe()->except('imagen');

        if ($request->hasFile('imagen')) {
            $this->deleteStoredImage($publicacion);
            $data['imagen'] = $request->file('imagen')->store('publicaciones', 'public');
        }

        $publicacion->update($data);

        return redirect()
            ->route('empresa.publicaciones.index')
            ->with('success', 'Publicación actualizada correctamente.');
    }

    public function destroy(Publicacion $publicacion): RedirectResponse
    {
        Gate::authorize('manage', $publicacion);

        $this->deleteStoredImage($publicacion);
        $publicacion->delete();

        return redirect()
            ->route('empresa.publicaciones.index')
            ->with('success', 'Publicación eliminada correctamente.');
    }

    private function deleteStoredImage(Publicacion $publicacion): void
    {
        if ($publicacion->imagen !== 'images/img.png') {
            Storage::disk('public')->delete($publicacion->imagen);
        }
    }
}
