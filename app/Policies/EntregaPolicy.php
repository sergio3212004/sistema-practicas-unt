<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Entrega;
use App\Models\User;

class EntregaPolicy
{
    public function manage(User $user, Entrega $entrega): bool
    {
        return $user->hasRole(UserRole::ALUMNO)
            && $user->alumno?->getKey() === $entrega->alumno_id;
    }

    public function grade(User $user, Entrega $entrega): bool
    {
        return $user->hasRole(UserRole::PROFESOR)
            && $user->profesor?->getKey() === $entrega->actividad?->aula?->profesor_id;
    }
}
