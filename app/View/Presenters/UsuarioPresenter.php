<?php

namespace App\View\Presenters;

use App\Enums\UserRole;
use App\Models\User;

final class UsuarioPresenter
{
    /**
     * @return array{roleLabel: string, isCompany: bool}
     */
    public function resumen(User $user): array
    {
        $role = UserRole::tryFrom($user->rol->nombre);

        return [
            'roleLabel' => $role?->label() ?? ucfirst($user->rol->nombre),
            'isCompany' => $role === UserRole::EMPRESA,
        ];
    }
}
