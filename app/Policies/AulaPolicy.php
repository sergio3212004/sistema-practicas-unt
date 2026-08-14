<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Aula;
use App\Models\User;

class AulaPolicy
{
    public function manage(User $user, Aula $aula): bool
    {
        return $user->hasRole(UserRole::PROFESOR)
            && $user->profesor?->getKey() === $aula->profesor_id;
    }
}
