<?php

namespace Database\Seeders\Concerns;

use App\Enums\UserRole;
use App\Models\User;

trait InteractsWithDemoUsers
{
    protected function demoUser(UserRole $role): User
    {
        return User::query()
            ->where('email', config("seeding.users.{$role->value}.email"))
            ->firstOrFail();
    }
}
