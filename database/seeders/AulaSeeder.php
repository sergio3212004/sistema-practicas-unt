<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Aula;
use App\Models\Semestre;
use Database\Seeders\Concerns\InteractsWithDemoUsers;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    use InteractsWithDemoUsers;

    public function run(): void
    {
        $semester = Semestre::query()
            ->where('nombre', config('seeding.semester'))
            ->firstOrFail();
        $teacher = $this->demoUser(UserRole::PROFESOR)->profesor;

        Aula::query()->updateOrCreate(
            [
                'semestre_id' => $semester->id,
                'profesor_id' => $teacher->id,
            ],
            ['numero' => 1],
        );
    }
}
