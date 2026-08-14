<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\RazonSocial;
use App\Models\Rol;
use App\Models\User;
use App\Services\UserManagementService;
use App\View\Presenters\UsuarioPresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserManagementService $users,
    ) {}

    public function index(UsuarioPresenter $presenter): View
    {
        $users = User::query()
            ->with('rol', 'alumno', 'administrador', 'empresa.razonSocial', 'profesor')
            ->paginate(10);
        $roleCounts = Rol::query()
            ->withCount('user')
            ->pluck('user_count', 'nombre');
        $resumenUsuarios = $users->getCollection()->mapWithKeys(fn (User $user): array => [
            $user->id => $presenter->resumen($user),
        ]);

        return view('admin.usuarios.index', compact('users', 'roleCounts', 'resumenUsuarios'));
    }

    public function create(): View
    {
        $roles = Rol::query()->orderBy('nombre')->get();
        $razonesSociales = RazonSocial::query()->orderBy('acronimo')->get();

        return view('admin.usuarios.create', compact('roles', 'razonesSociales'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->users->create($request->validated());

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario y perfil asociados creados exitosamente.');
    }

    public function show(User $usuario): View
    {
        $usuario->load('rol', 'alumno', 'administrador', 'empresa', 'profesor');
        $razonesSociales = RazonSocial::query()->orderBy('acronimo')->get();

        return view('admin.usuarios.show', compact('usuario', 'razonesSociales'));
    }

    public function edit(User $usuario): View
    {
        $usuario->load('rol', 'alumno', 'administrador', 'empresa', 'profesor');
        $roles = Rol::query()->orderBy('nombre')->get();
        $razonesSociales = RazonSocial::query()->orderBy('acronimo')->get();

        return view('admin.usuarios.edit', compact('usuario', 'roles', 'razonesSociales'));
    }

    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $this->users->update($usuario, $request->validated());

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        $this->users->delete($usuario);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
