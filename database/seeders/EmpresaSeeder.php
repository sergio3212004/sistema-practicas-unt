<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\RazonSocial;
use Database\Seeders\Concerns\InteractsWithDemoUsers;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    use InteractsWithDemoUsers;

    public function run(): void
    {
        $user = $this->demoUser(UserRole::EMPRESA);
        $businessType = RazonSocial::query()->where('acronimo', 'S.A.C.')->firstOrFail();

        $user->empresa()->updateOrCreate([], [
            'nombre' => 'Soluciones Digitales Norte',
            'departamento' => 'La Libertad',
            'provincia' => 'Trujillo',
            'distrito' => 'Trujillo',
            'direccion' => 'Av. Juan Pablo II N.° 1350',
            'razon_social_id' => $businessType->id,
            'telefono' => '944777888',
            'ruc' => '20601234567',
            'aprobado' => true,
        ]);
    }
}
