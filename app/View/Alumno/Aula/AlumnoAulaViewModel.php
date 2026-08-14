<?php

namespace App\View\Alumno\Aula;

use App\Models\Aula;
use Illuminate\Support\Collection;

final readonly class AlumnoAulaViewModel
{
    /**
     * @param  array{actividades: int, activas: int, entregadas: int, pendientes: int}  $metricas
     * @param  Collection<int, array<string, mixed>>  $semanas
     */
    public function __construct(
        public Aula $aula,
        public array $metricas,
        public Collection $semanas,
    ) {}
}
