<?php

namespace App\View\Presenters;

use App\Models\FichaRegistroHorario;
use Illuminate\Support\Collection;

final class HorarioPresenter
{
    /**
     * @param  Collection<int, FichaRegistroHorario>  $horarios
     * @return array{days: array<int, string>, schedules: array<int, array{start: string, end: string}|null>}
     */
    public function semana(Collection $horarios): array
    {
        $schedules = collect(range(1, 6))
            ->map(function (int $day) use ($horarios): ?array {
                $schedule = $horarios->firstWhere('dia_semana', $day);

                if ($schedule === null) {
                    return null;
                }

                return [
                    'start' => $schedule->hora_inicio->format('H:i'),
                    'end' => $schedule->hora_fin->format('H:i'),
                ];
            })
            ->all();

        return [
            'days' => ['LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'],
            'schedules' => $schedules,
        ];
    }
}
