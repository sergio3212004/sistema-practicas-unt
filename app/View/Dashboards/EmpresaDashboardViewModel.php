<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;
use App\Models\Empresa;
use App\Models\Publicacion;
use Illuminate\Support\Collection;

final readonly class EmpresaDashboardViewModel implements DashboardViewModel
{
    /**
     * @param  Collection<int, Publicacion>  $publicaciones
     * @param  array{publicaciones: int, activas: int, postulaciones: int, pendientes: int}  $metricas
     * @param  array<int, array{label: string, value: string}>  $detalles
     */
    public function __construct(
        public Empresa $empresa,
        public Collection $publicaciones,
        public array $metricas,
        public array $detalles,
    ) {}

    public function role(): UserRole
    {
        return UserRole::EMPRESA;
    }
}
