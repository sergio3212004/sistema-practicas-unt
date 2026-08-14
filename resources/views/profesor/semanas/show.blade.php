<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Semana {{ $semana->numero }}
                    @if($semana->nombre)
                        - {{ $semana->nombre }}
                    @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Aula {{ $semana->aula->numero }} • {{ $semana->aula->semestre->nombre }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('profesor.actividades.create', ['aula' => $semana->aula, 'semana' => $semana]) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Actividad
                </a>
                <a href="{{ route('profesor.aulas.show', $semana->aula) }}"
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver al Aula
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Actividades -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Actividades</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $semana->actividades->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actividades Activas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Activas</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $semana->actividades->filter(fn($a) => $a->estaActiva())->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Entregas -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Entregas Recibidas</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $semana->actividades->sum(fn($a) => $a->entregas->count()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la semana -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-white">Detalles de la Semana</h3>
                                <p class="text-blue-200 text-sm mt-1">Información general y gestión</p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('profesor.semanas.edit', $semana) }}"
                               class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('profesor.semanas.destroy', $semana) }}" method="POST" class="inline"
                                  onsubmit="return confirm('¿Está seguro de eliminar esta semana? Se eliminarán todas sus actividades.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Número de Semana</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">Semana {{ $semana->numero }}</p>
                            </div>
                        </div>

                        @if($semana->nombre)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nombre/Descripción</p>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $semana->nombre }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Aula</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">Aula {{ $semana->aula->numero }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Semestre</p>
                                <p class="text-lg font-semibold text-gray-900 mt-1">{{ $semana->aula->semestre->nombre }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Actividades -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Actividades de la Semana</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $semana->actividades->count() }} {{ $semana->actividades->count() === 1 ? 'actividad registrada' : 'actividades registradas' }}
                            </p>
                        </div>
                        <a href="{{ route('profesor.actividades.create', ['aula' => $semana->aula, 'semana' => $semana]) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Actividad
                        </a>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse($semana->actividades as $actividad)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="text-sm font-semibold text-gray-900">
                                            {{ $actividad->titulo }}
                                        </h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $actividad->tipoActividad->nombre }}
                                        </span>
                                        @if($actividad->estaActiva())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                                                Activa
                                            </span>
                                        @elseif($actividad->estaVencida())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Vencida
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Próxima
                                            </span>
                                        @endif
                                    </div>
                                    @if($actividad->descripcion)
                                        <p class="text-sm text-gray-600 mb-2">{{ $actividad->descripcion }}</p>
                                    @endif
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Inicio: {{ $actividad->fecha_inicio->format('d/m/Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Límite: {{ $actividad->fecha_limite->format('d/m/Y') }}
                                        </span>
                                        @php
                                            $progreso = $actividad->obtenerProgreso();
                                        @endphp
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Entregas: {{ $progreso['entregadas'] }}/{{ $progreso['total'] }} ({{ $progreso['porcentaje'] }}%)
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            Modo: {{ ucfirst($actividad->tipoActividad->modo_entrega) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('profesor.actividades.show', $actividad) }}"
                                       class="inline-flex items-center px-3 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        Ver Entregas
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('profesor.actividades.destroy', $actividad) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta actividad?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay actividades</h3>
                            <p class="text-gray-600 mb-4">Esta semana aún no tiene actividades asignadas</p>
                            <a href="{{ route('profesor.actividades.create', ['aula' => $semana->aula, 'semana' => $semana]) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Crear Primera Actividad
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
