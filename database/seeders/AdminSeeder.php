<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Database\Seeders\Concerns\InteractsWithDemoUsers;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use InteractsWithDemoUsers;

    public function run(): void
    {
        $user = $this->demoUser(UserRole::ADMINISTRADOR);

        $user->administrador()->updateOrCreate([], [
            'nombres' => 'María Elena',
            'apellido_paterno' => 'Torres',
            'apellido_materno' => 'Salazar',
            'telefono' => '944111222',
        ]);
    }
}
