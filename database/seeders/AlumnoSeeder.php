<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Aula;
use Database\Seeders\Concerns\InteractsWithDemoUsers;
use Illuminate\Database\Seeder;

class AlumnoSeeder extends Seeder
{
    use InteractsWithDemoUsers;

    public function run(): void
    {
        $user = $this->demoUser(UserRole::ALUMNO);
        $teacher = $this->demoUser(UserRole::PROFESOR)->profesor()->firstOrFail();
        $classroom = Aula::query()
            ->whereHas('semestre', fn ($query) => $query->where('nombre', config('seeding.semester')))
            ->where('profesor_id', $teacher->id)
            ->firstOrFail();

        $user->alumno()->updateOrCreate([], [
            'codigo_matricula' => '1052701001',
            'nombres' => 'Lucía Fernanda',
            'apellido_paterno' => 'Mendoza',
            'apellido_materno' => 'Ríos',
            'telefono' => '944555666',
            'cv' => null,
            'aula_id' => $classroom->id,
        ]);
    }
}
