<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;
use App\Models\Administrador;
use App\Models\Semestre;
use Illuminate\Support\Collection;

final readonly class AdminDashboardViewModel implements DashboardViewModel
{
    /**
     * @param  Collection<int, Semestre>  $semestres
     */
    public function __construct(
        public Administrador $administrador,
        public Collection $semestres,
        public ?Semestre $semestreActivo,
        public int $totalSemestres,
    ) {}

    public function role(): UserRole
    {
        return UserRole::ADMINISTRADOR;
    }
}
