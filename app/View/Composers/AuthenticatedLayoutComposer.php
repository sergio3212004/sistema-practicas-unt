<?php

namespace App\View\Composers;

use App\Enums\UserRole;
use App\View\Layout\AuthenticatedLayoutViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class AuthenticatedLayoutComposer
{
    public function __construct(private readonly Request $request) {}

    public function compose(View $view): void
    {
        $user = $this->request->user();

        if ($user === null) {
            return;
        }

        $user->loadMissing([
            'rol',
            'administrador',
            'alumno',
            'profesor',
            'empresa.razonSocial',
        ]);

        $role = UserRole::tryFrom($user->rol->nombre);
        $userName = $user->nombre ?? $user->email ?? 'Usuario';
        $menuItems = collect(config("navigation.{$user->rol->nombre}", []))
            ->map(fn (array $item): array => [
                ...$item,
                'active' => $this->request->routeIs($item['pattern']),
            ])
            ->all();

        $view->with('layout', new AuthenticatedLayoutViewModel(
            userName: $userName,
            roleLabel: $role?->label() ?? 'Usuario',
            initial: Str::of($userName)->substr(0, 1)->upper()->toString(),
            dashboardActive: $this->request->routeIs('dashboard'),
            menuItems: $menuItems,
        ));
    }
}
