<?php

namespace App\View\Presenters;

use App\Models\Entrega;

final class EntregaPresenter
{
    /**
     * @return array{class: string, text: string}
     */
    public function estado(Entrega $entrega): array
    {
        return match ($entrega->estado) {
            'pendiente' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pendiente'],
            'entregado' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Entregado'],
            'observado' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Revisado'],
            'rechazado' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Rechazado'],
            default => ['class' => 'bg-gray-100 text-gray-800', 'text' => ucfirst($entrega->estado)],
        };
    }
}
