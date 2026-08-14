<?php

namespace Database\Seeders;

use App\Models\TipoActividad;
use Illuminate\Database\Seeder;

class TipoActividadSeeder extends Seeder
{
    public function run(): void
    {
        $activityTypes = [
            'Reporte' => 'drive',
            'Informe de Unidad' => 'drive',
            'Informe Final' => 'pdf',
        ];

        foreach ($activityTypes as $name => $deliveryMode) {
            TipoActividad::query()->updateOrCreate(
                ['nombre' => $name],
                ['modo_entrega' => $deliveryMode],
            );
        }
    }
}
