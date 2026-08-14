<?php

namespace App\View\Presenters;

final class CalificacionPresenter
{
    /**
     * @return array{message: string, textClass: string, backgroundClass: string}
     */
    public function resumen(float|int $calificacion): array
    {
        return match (true) {
            $calificacion >= 17 => [
                'message' => '¡Excelente desempeño!',
                'textClass' => 'text-green-700',
                'backgroundClass' => 'bg-green-100',
            ],
            $calificacion >= 14 => [
                'message' => 'Buen trabajo',
                'textClass' => 'text-blue-700',
                'backgroundClass' => 'bg-blue-100',
            ],
            $calificacion >= 11 => [
                'message' => 'Desempeño regular',
                'textClass' => 'text-yellow-700',
                'backgroundClass' => 'bg-yellow-100',
            ],
            default => [
                'message' => 'Necesitas mejorar',
                'textClass' => 'text-red-700',
                'backgroundClass' => 'bg-red-100',
            ],
        };
    }
}
