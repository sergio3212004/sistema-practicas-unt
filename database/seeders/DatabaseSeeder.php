<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            RazonesSocialesSeeder::class,
            TipoActividadSeeder::class,
        ]);

        if (! config('seeding.demo_enabled')) {
            $this->command?->info('Datos de demostración omitidos para este entorno.');

            return;
        }

        $this->call([
            SemestreSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            ProfesorSeeder::class,
            AulaSeeder::class,
            AlumnoSeeder::class,
            EmpresaSeeder::class,
        ]);
    }
}
