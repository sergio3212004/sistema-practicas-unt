<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Rol::query()->firstOrCreate(['nombre' => $role->value]);
        }
    }
}
