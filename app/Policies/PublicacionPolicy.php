<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Publicacion;
use App\Models\User;

class PublicacionPolicy
{
    public function manage(User $user, Publicacion $publicacion): bool
    {
        return $user->hasRole(UserRole::EMPRESA)
            && $user->empresa?->getKey() === $publicacion->empresa_id;
    }
}
