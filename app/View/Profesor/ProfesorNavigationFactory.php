<?php

namespace App\View\Profesor;

use App\Models\Aula;
use App\Models\User;
use Illuminate\Http\Request;

final class ProfesorNavigationFactory
{
    public function __construct(private readonly Request $request) {}

    /** @return array<int, array<string, mixed>> */
    public function make(User $user, array $menuItems): array
    {
        $classrooms = Aula::query()
            ->where('profesor_id', $user->profesor?->id ?? 0)
            ->with('semestre')
            ->orderByDesc('semestre_id')->orderBy('numero')->get();
        $classroomNodes = $classrooms->map(function ($aula): array {
            $current = $this->request->route('aula');
            $selected = $current instanceof Aula && $current->is($aula);
            $children = [];
            foreach (['estudiantes' => 'Estudiantes y seguimiento', 'planificacion' => 'Planificación y entregas', 'documentos' => 'Fichas, cronogramas y monitoreos'] as $tab => $label) {
                $children[] = ['label' => $label, 'url' => route('profesor.aulas.show', ['aula' => $aula, 'tab' => $tab]),
                    'active' => $selected && $this->request->routeIs('profesor.aulas.show', 'profesor.aula.index') && $this->request->query('tab', 'estudiantes') === $tab];
            }
            foreach (['semanas.create' => 'Crear semana', 'actividades.create' => 'Asignar trabajo'] as $route => $label) {
                $children[] = ['label' => $label, 'url' => route('profesor.'.$route, $aula), 'active' => $selected && $this->request->routeIs('profesor.'.$route)];
            }

            return ['label' => 'Aula '.$aula->numero.' · '.($aula->semestre?->nombre ?? 'Sin semestre'), 'children' => $children, 'active' => collect($children)->contains('active', true)];
        })->all();

        return [
            ['label' => 'Mis aulas', 'children' => $classroomNodes, 'active' => collect($classroomNodes)->contains('active', true), 'empty' => 'Aún no tienes aulas asignadas.'],
            ['label' => 'Semanas de trabajo', 'active' => $this->request->routeIs('profesor.semanas.*', 'profesor.informes-finales.*'), 'children' => [
                ['label' => 'Semanas y actividades', 'url' => route('profesor.semanas.index'), 'active' => $this->request->routeIs('profesor.semanas.index', 'profesor.semanas.show', 'profesor.semanas.edit')],
                ['label' => 'Informes finales históricos', 'url' => route('profesor.informes-finales.index'), 'active' => $this->request->routeIs('profesor.informes-finales.*')],
            ]],
            ['label' => 'Formatos PPP', 'children' => array_map(fn ($item) => [...$item, 'url' => route($item['route'])], $menuItems), 'active' => collect($menuItems)->contains('active', true)],
        ];
    }
}
