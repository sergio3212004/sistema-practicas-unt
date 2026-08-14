<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Monitoreo de Prácticas Pre-Profesionales
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $alumno->user->nombre }} - {{ $alumno->codigo_matricula }}
                </p>
            </div>
            <a href="{{ route('profesor.aulas.show', $aula) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Aula
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Información del Estudiante y Empresa -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Datos del Practicante -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Practicante</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Nombre:</span>
                            <p class="text-gray-600">{{ $alumno->user->nombre }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Código:</span>
                            <p class="text-gray-600">{{ $alumno->codigo_matricula }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Email:</span>
                            <p class="text-gray-600">{{ $alumno->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Datos de la Empresa -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Empresa</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Razón Social:</span>
                            <p class="text-gray-600">{{ $alumno->fichaRegistro->razon_social }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">RUC:</span>
                            <p class="text-gray-600">{{ $alumno->fichaRegistro->ruc }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Área:</span>
                            <p class="text-gray-600">{{ $alumno->fichaRegistro->area_practicas }}</p>
                        </div>
                    </div>
                </div>

                <!-- Periodo de Prácticas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Periodo</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-700">Inicio:</span>
                            <p class="text-gray-600">{{ $alumno->fichaRegistro->fecha_inicio->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Término:</span>
                            <p class="text-gray-600">{{ $alumno->fichaRegistro->fecha_termino->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700">Duración:</span>
                            <p class="text-gray-600">
                                {{ $alumno->fichaRegistro->fecha_inicio->diffInDays($alumno->fichaRegistro->fecha_termino) }} días
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de Progreso -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-sm border border-blue-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Progreso del Monitoreo</h3>
                        <p class="text-sm text-gray-600">
                            Seguimiento semanal de las actividades del cronograma
                        </p>
                    </div>
                    <div class="text-center">
                        @php
                            $totalSemanas = $semanas->count();
                            $semanasConMonitoreo = $semanas->filter(function($semana) {
                                return $semana->monitoreosPracticas->isNotEmpty();
                            })->count();
                            $porcentaje = $totalSemanas > 0 ? round(($semanasConMonitoreo / $totalSemanas) * 100) : 0;
                        @endphp
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white shadow-md border-4 border-blue-500">
                            <span class="text-3xl font-bold text-blue-700">{{ $porcentaje }}%</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $semanasConMonitoreo }} de {{ $totalSemanas }} semanas
                        </p>
                    </div>
                </div>
            </div>

            <!-- Timeline de Semanas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Monitoreo por Semanas
                    </h3>
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                            <span class="text-gray-600">Registrado</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                            <span class="text-gray-600">Pendiente</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($semanas as $semana)
                        @php
                            $monitoreo = $semana->monitoreosPracticas->first();
                            $tieneMonitoreo = $monitoreo !== null;
                        @endphp

                        <div class="relative pl-8 pb-8 border-l-2 {{ $tieneMonitoreo ? 'border-green-500' : 'border-gray-300' }} last:border-l-0 last:pb-0">
                            <!-- Indicador de estado -->
                            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full {{ $tieneMonitoreo ? 'bg-green-500' : 'bg-yellow-500' }} border-4 border-white shadow"></div>

                            <!-- Contenido de la semana -->
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-5 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-semibold text-gray-900">
                                                Semana {{ $semana->numero }}
                                                @if($semana->nombre)
                                                    - {{ $semana->nombre }}
                                                @endif
                                            </h4>
                                            @if($tieneMonitoreo)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Registrado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Pendiente
                                                </span>
                                            @endif
                                        </div>

                                        @if($tieneMonitoreo)
                                            @php
                                                $totalActividades = $monitoreo->monitoreosPracticasActividades->count();
                                                $actividadesAlDia = $monitoreo->monitoreosPracticasActividades->where('al_dia', true)->count();
                                            @endphp
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                                <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                    <p class="text-xs font-medium text-gray-600 mb-1">Actividades Monitoreadas</p>
                                                    <p class="text-2xl font-bold text-blue-700">{{ $totalActividades }}</p>
                                                </div>
                                                <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                    <p class="text-xs font-medium text-gray-600 mb-1">Al Día</p>
                                                    <p class="text-2xl font-bold text-green-700">{{ $actividadesAlDia }}</p>
                                                </div>
                                                <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                    <p class="text-xs font-medium text-gray-600 mb-1">Con Retraso</p>
                                                    <p class="text-2xl font-bold text-red-700">{{ $totalActividades - $actividadesAlDia }}</p>
                                                </div>
                                            </div>

                                            <!-- Lista de actividades monitoreadas -->
                                            @if($monitoreo->monitoreosPracticasActividades->isNotEmpty())
                                                <div class="mt-4 space-y-2">
                                                    <p class="text-sm font-medium text-gray-700">Actividades del Cronograma:</p>
                                                    @foreach($monitoreo->monitoreosPracticasActividades as $actividadMonitoreada)
                                                        <div class="flex items-center justify-between bg-white p-3 rounded border border-gray-200">
                                                            <div class="flex items-center gap-2">
                                                                @if($actividadMonitoreada->al_dia)
                                                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                @endif
                                                                <span class="text-sm text-gray-700">
                                                                    {{ $actividadMonitoreada->cronogramaActividad->actividad ?? 'Actividad no especificada' }}
                                                                </span>
                                                            </div>
                                                            <span class="text-xs px-2 py-1 rounded {{ $actividadMonitoreada->al_dia ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $actividadMonitoreada->al_dia ? 'Al día' : 'Con retraso' }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <p class="text-sm text-yellow-800">
                                                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    No se ha registrado el monitoreo para esta semana
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($tieneMonitoreo)
                                        <div class="flex gap-2">
                                            <a href="{{ route('profesor.monitoreos-practicas.show', $monitoreo) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Ver Detalle
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay semanas registradas</h3>
                            <p class="text-gray-600">El aula no tiene semanas configuradas para el monitoreo</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
