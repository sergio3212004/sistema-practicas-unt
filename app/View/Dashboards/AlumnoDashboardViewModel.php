<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;
use App\Models\Alumno;

final readonly class AlumnoDashboardViewModel implements DashboardViewModel
{
    /**
     * @param  array{total: int, pendientes: int, entregadas: int, revisadas: int, progreso: int, promedio: float|null}  $metricas
     */
    public function __construct(
        public Alumno $alumno,
        public string $nombre,
        public array $metricas,
    ) {}

    public function role(): UserRole
    {
        return UserRole::ALUMNO;
    }
}
