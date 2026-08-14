<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Database\Seeders\Concerns\InteractsWithDemoUsers;
use Illuminate\Database\Seeder;

class ProfesorSeeder extends Seeder
{
    use InteractsWithDemoUsers;

    public function run(): void
    {
        $user = $this->demoUser(UserRole::PROFESOR);

        $user->profesor()->updateOrCreate([], [
            'codigo_profesor' => 'DOC0000001',
            'nombres' => 'Carlos Eduardo',
            'apellido_paterno' => 'Ramírez',
            'apellido_materno' => 'Vega',
            'telefono' => '944333444',
        ]);
    }
}
