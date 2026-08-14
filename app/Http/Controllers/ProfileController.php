<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // ===== ALUMNO =====
        if ($user->alumno) {
            $updateData = [];

            if ($request->filled('telefono')) {
                $updateData['telefono'] = $request->telefono;
            }

            if ($request->filled('cv_link')) {
                $updateData['cv'] = $request->cv_link;
            }

            if (!empty($updateData)) {
                $user->alumno->update($updateData);
            }

            return Redirect::route('profile.edit')->with('status', 'alumno-updated');
        }

        // ===== PROFESOR =====
        if ($user->profesor) {
            if ($request->filled('telefono')) {
                $user->profesor->update(['telefono' => $request->telefono]);
                return Redirect::route('profile.edit')->with('status', 'profesor-updated');
            }
        }

        // ===== EMPRESA =====
        if ($user->empresa) {
            $empresaData = $request->only(['telefono', 'direccion', 'departamento', 'provincia', 'distrito']);
            // Filtrar nulos si se desea, o permitir borrar datos. Aquí usaremos array_filter para quitar nulos si es que el request no los trae, pero filled() es mejor check.
            // Simplified: Update whatever comes in request that is not null presumably? Or just update all matching fields.
            // Since we validated them as nullable, we can update.
            $user->empresa->update($empresaData);
            return Redirect::route('profile.edit')->with('status', 'empresa-updated');
        }

        // ===== USUARIO =====
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


}
