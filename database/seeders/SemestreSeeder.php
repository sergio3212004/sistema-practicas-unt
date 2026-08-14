<?php

namespace Database\Seeders;

use App\Models\Semestre;
use Illuminate\Database\Seeder;

class SemestreSeeder extends Seeder
{
    public function run(): void
    {
        Semestre::query()->updateOrCreate(
            ['nombre' => config('seeding.semester')],
            ['activo' => true],
        );
    }
}
