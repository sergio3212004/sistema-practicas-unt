<?php

namespace App\View\Presenters;

use App\Models\Actividad;
use App\Models\Entrega;

final class ActividadPresenter
{
    /**
     * @return array{total: int, entregadas: int, porcentaje: float|int}
     */
    public function progreso(Actividad $actividad, int $totalAlumnos): array
    {
        $entregadas = $actividad->entregas->count();

        return [
            'total' => $totalAlumnos,
            'entregadas' => $entregadas,
            'porcentaje' => $totalAlumnos === 0
                ? 0
                : round(($entregadas / $totalAlumnos) * 100, 1),
        ];
    }

    /**
     * @return array{key: string, containerClass: string, badgeClass: string, badgeText: string, iconClass: string, dotClass: string}
     */
    public function estado(Actividad $actividad, ?Entrega $entrega = null): array
    {
        if ($actividad->estaVencida() && $entrega === null) {
            return [
                'key' => 'vencida',
                'containerClass' => 'border-red-200 bg-red-50',
                'badgeClass' => 'bg-red-100 text-red-800 border-red-200',
                'badgeText' => 'Vencida',
                'iconClass' => 'text-red-600',
                'dotClass' => 'bg-red-500',
            ];
        }

        if ($actividad->estaActiva()) {
            return [
                'key' => 'activa',
                'containerClass' => 'border-emerald-200 bg-emerald-50/30',
                'badgeClass' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'badgeText' => 'Activa',
                'iconClass' => 'text-emerald-600',
                'dotClass' => 'bg-emerald-500 animate-pulse',
            ];
        }

        if ($actividad->esFutura()) {
            return [
                'key' => 'futura',
                'containerClass' => 'border-gray-200 bg-gray-50',
                'badgeClass' => 'bg-gray-100 text-gray-800 border-gray-200',
                'badgeText' => 'Próxima',
                'iconClass' => 'text-gray-600',
                'dotClass' => 'bg-gray-400',
            ];
        }

        return [
            'key' => 'cerrada',
            'containerClass' => 'border-gray-200',
            'badgeClass' => 'bg-gray-100 text-gray-800 border-gray-200',
            'badgeText' => 'Cerrada',
            'iconClass' => 'text-gray-600',
            'dotClass' => 'bg-gray-400',
        ];
    }
}
