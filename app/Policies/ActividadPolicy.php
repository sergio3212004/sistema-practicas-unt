<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Actividad;
use App\Models\User;

class ActividadPolicy
{
    public function manage(User $user, Actividad $actividad): bool
    {
        return $user->hasRole(UserRole::PROFESOR)
            && $user->profesor?->getKey() === $actividad->aula?->profesor_id;
    }

    public function submit(User $user, Actividad $actividad): bool
    {
        return $user->hasRole(UserRole::ALUMNO)
            && $user->alumno?->aula_id === $actividad->aula_id;
    }
}
