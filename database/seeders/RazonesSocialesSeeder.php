<?php

namespace Database\Seeders;

use App\Models\RazonSocial;
use Illuminate\Database\Seeder;

class RazonesSocialesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['S.A.C.S.', 'S.A.', 'S.A.C.', 'S.R.L.', 'E.I.R.L.', 'S.A.A.'] as $acronym) {
            RazonSocial::query()->firstOrCreate(['acronimo' => $acronym]);
        }
    }
}
