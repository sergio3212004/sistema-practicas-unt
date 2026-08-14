<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    //
    public function index(Request $request): View
    {
        $user = $request->user();
        $data = [];

        // Lógica específica para el administrador
        if ($user->hasRole(UserRole::ADMINISTRADOR)) {
            $data['semestres'] = Semestre::orderByDesc('id')->get();
            $data['administrador'] = $user->administrador; // Carga la relación
        }

        if ($user->hasRole(UserRole::ALUMNO)) {
            $alumno = $user->alumno->load([
                'aula.semestre',
                'aula.profesor.user',
                'entregas',
            ]);
            $entregas = $alumno->entregas;
            $completadas = $entregas->whereIn('estado', ['entregado', 'observado'])->count();
            $notas = $entregas->whereNotNull('nota');

            $data['alumno'] = $alumno;
            $data['metricasAlumno'] = [
                'total' => $entregas->count(),
                'pendientes' => $entregas->where('estado', 'pendiente')->count(),
                'entregadas' => $entregas->where('estado', 'entregado')->count(),
                'revisadas' => $entregas->where('estado', 'observado')->count(),
                'progreso' => $entregas->isEmpty() ? 0 : min(100, (int) round(($completadas / $entregas->count()) * 100)),
                'promedio' => $notas->isEmpty() ? null : round((float) $notas->avg('nota'), 1),
            ];
        }

        // Lógica para el profesor
        if ($user->hasRole(UserRole::PROFESOR)) {
            $profesor = $user->profesor;

            // Cargar aulas con sus relaciones necesarias
            $aulas = $profesor->aulas()
                ->with([
                    'semestre',
                    'alumnos',
                    'semanas',
                    'actividades.entregas',
                ])
                ->get();

            // Calcular total de entregas en todas las aulas
            $totalEntregas = $aulas->sum(function ($aula) {
                return $aula->actividades->sum(function ($actividad) {
                    return $actividad->entregas->count();
                });
            });

            // Calcular actividades activas (entre fecha_inicio y fecha_limite)
            $actividadesActivas = $aulas->sum(function ($aula) {
                return $aula->actividades->filter(function ($actividad) {
                    return $actividad->estaActiva();
                })->count();
            });

            $data['profesor'] = $profesor;
            $data['aulas'] = $aulas;
            $data['totalEntregas'] = $totalEntregas;
            $data['actividadesActivas'] = $actividadesActivas;
            $data['semestreActivo'] = Semestre::where('activo', true)->first();
        }

        if ($user->hasRole(UserRole::EMPRESA)) {
            $data['empresa'] = $user->empresa->load('user', 'razonSocial', 'publicaciones.postulaciones');
        }

        return view('dashboard', $data);
    }
}
