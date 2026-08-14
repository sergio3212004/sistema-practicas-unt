<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Semana;
use App\Models\User;

class SemanaPolicy
{
    public function manage(User $user, Semana $semana): bool
    {
        return $user->hasRole(UserRole::PROFESOR)
            && $user->profesor?->getKey() === $semana->aula?->profesor_id;
    }
}
