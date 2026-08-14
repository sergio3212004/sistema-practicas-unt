<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;
use App\Models\Aula;
use App\Models\Profesor;
use App\Models\Semestre;
use Illuminate\Support\Collection;

final readonly class ProfesorDashboardViewModel implements DashboardViewModel
{
    /**
     * @param  Collection<int, array{aula: Aula, estudiantes: int, semanas: int, actividades: int, entregas: int}>  $aulas
     */
    public function __construct(
        public Profesor $profesor,
        public Collection $aulas,
        public ?Semestre $semestreActivo,
        public int $totalEstudiantes,
        public int $totalEntregas,
        public int $actividadesActivas,
    ) {}

    public function role(): UserRole
    {
        return UserRole::PROFESOR;
    }
}
