<?php

namespace App\View\Dashboards;

use App\Enums\UserRole;
use App\Models\Semestre;
use App\Models\User;
use LogicException;

final class DashboardViewModelFactory
{
    public function make(User $user): DashboardViewModel
    {
        return match (true) {
            $user->hasRole(UserRole::ADMINISTRADOR) => $this->forAdministrador($user),
            $user->hasRole(UserRole::ALUMNO) => $this->forAlumno($user),
            $user->hasRole(UserRole::PROFESOR) => $this->forProfesor($user),
            $user->hasRole(UserRole::EMPRESA) => $this->forEmpresa($user),
            default => throw new LogicException('El usuario no tiene un rol compatible con el panel.'),
        };
    }

    private function forAdministrador(User $user): AdminDashboardViewModel
    {
        $semestres = Semestre::query()->latest('id')->get();

        return new AdminDashboardViewModel(
            administrador: $user->administrador,
            semestres: $semestres,
            semestreActivo: $semestres->firstWhere('activo', true),
            totalSemestres: $semestres->count(),
        );
    }

    private function forAlumno(User $user): AlumnoDashboardViewModel
    {
        $alumno = $user->alumno->load([
            'aula.semestre',
            'aula.profesor.user',
            'entregas',
        ]);
        $entregas = $alumno->entregas;
        $completadas = $entregas->whereIn('estado', ['entregado', 'observado'])->count();
        $notas = $entregas->whereNotNull('nota');

        return new AlumnoDashboardViewModel(
            alumno: $alumno,
            nombre: $user->nombre ?? 'Estudiante',
            metricas: [
                'total' => $entregas->count(),
                'pendientes' => $entregas->where('estado', 'pendiente')->count(),
                'entregadas' => $entregas->where('estado', 'entregado')->count(),
                'revisadas' => $entregas->where('estado', 'observado')->count(),
                'progreso' => $entregas->isEmpty()
                    ? 0
                    : min(100, (int) round(($completadas / $entregas->count()) * 100)),
                'promedio' => $notas->isEmpty() ? null : round((float) $notas->avg('nota'), 1),
            ],
        );
    }

    private function forProfesor(User $user): ProfesorDashboardViewModel
    {
        $profesor = $user->profesor;
        $aulas = $profesor->aulas()
            ->with([
                'semestre',
                'alumnos',
                'semanas',
                'actividades.entregas',
            ])
            ->get();

        $resumenAulas = $aulas->map(function ($aula): array {
            return [
                'aula' => $aula,
                'estudiantes' => $aula->alumnos->count(),
                'semanas' => $aula->semanas->count(),
                'actividades' => $aula->actividades->count(),
                'entregas' => $aula->actividades->sum(
                    fn ($actividad): int => $actividad->entregas->count()
                ),
            ];
        });

        return new ProfesorDashboardViewModel(
            profesor: $profesor,
            aulas: $resumenAulas,
            semestreActivo: Semestre::query()->where('activo', true)->first(),
            totalEstudiantes: $resumenAulas->sum('estudiantes'),
            totalEntregas: $resumenAulas->sum('entregas'),
            actividadesActivas: $aulas->sum(
                fn ($aula): int => $aula->actividades->filter->estaActiva()->count()
            ),
        );
    }

    private function forEmpresa(User $user): EmpresaDashboardViewModel
    {
        $empresa = $user->empresa->load('user', 'razonSocial', 'publicaciones.postulaciones');
        $publicaciones = $empresa->publicaciones;

        return new EmpresaDashboardViewModel(
            empresa: $empresa,
            publicaciones: $publicaciones,
            metricas: [
                'publicaciones' => $publicaciones->count(),
                'activas' => $publicaciones->where('estado', 'Disponible')->count(),
                'postulaciones' => $publicaciones->sum(
                    fn ($publicacion): int => $publicacion->postulaciones->count()
                ),
                'pendientes' => $publicaciones->sum(
                    fn ($publicacion): int => $publicacion->postulaciones->where('estado', 'pendiente')->count()
                ),
            ],
            detalles: [
                ['label' => 'Razón social', 'value' => $empresa->razonSocial->acronimo ?? 'No especificada'],
                ['label' => 'Correo', 'value' => $empresa->user->email ?? 'No registrado'],
                ['label' => 'Teléfono', 'value' => $empresa->telefono ?? 'No registrado'],
                ['label' => 'Ubicación', 'value' => $this->ubicacionEmpresa($empresa)],
                ['label' => 'Dirección', 'value' => $empresa->direccion ?? 'No especificada'],
            ],
        );
    }

    private function ubicacionEmpresa(object $empresa): string
    {
        return collect([
            $empresa->distrito,
            $empresa->provincia,
            $empresa->departamento,
        ])->filter()->implode(', ') ?: 'No especificada';
    }
}
