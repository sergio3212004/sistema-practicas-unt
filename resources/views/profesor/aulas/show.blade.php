<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Aula {{ $aula->numero }} - {{ $aula->semestre->nombre }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Gestión de estudiantes, semanas y actividades
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('profesor.semanas.create', $aula) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nueva Semana
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tarjetas de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Estudiantes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $aula->alumnos->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Semanas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $aula->semanas->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Actividades Activas</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $aula->actividades()->where('fecha_inicio', '<=', now())->where('fecha_limite', '>=', now())->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <svg class="w-8 h-8 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Actividades</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $aula->actividades->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel principal -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200" x-data="{ tab: 'estudiantes' }">

                <!-- Pestañas de navegación -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="tab = 'estudiantes'"
                                :class="tab === 'estudiantes' ? 'border-blue-800 text-blue-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Estudiantes
                            </div>
                        </button>
                        <button @click="tab = 'semanas'"
                                :class="tab === 'semanas' ? 'border-blue-800 text-blue-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Semanas y Actividades
                            </div>
                        </button>
                        <button @click="tab = 'documentos'"
                                :class="tab === 'documentos' ? 'border-blue-800 text-blue-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="px-6 py-4 text-sm font-medium border-b-2 transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Documentos
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Contenido de pestañas -->
                <div class="p-6">

                    <!-- Pestaña de Estudiantes -->
                    <div x-show="tab === 'estudiantes'" x-transition>
                        <div class="mb-4">
                            <input type="text"
                                   id="searchEstudiantes"
                                   placeholder="Buscar estudiante por nombre, código o email..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Código
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Estudiante
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Teléfono
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="tablaEstudiantes">
                                @forelse($aula->alumnos as $alumno)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">
                                                {{ $alumno->codigo_matricula }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-semibold">
                                                        {{ strtoupper(substr($alumno->user->nombre, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $alumno->user->nombre }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">
                                                {{ $alumno->user->email }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $alumno->telefono ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                            </svg>
                                            No hay estudiantes registrados en esta aula
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña de Semanas y Actividades -->
                    <div x-show="tab === 'semanas'" x-transition>
                        <div class="space-y-4">
                            @forelse($aula->semanas()->orderBy('numero')->get() as $semana)
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <!-- Cabecera de la semana -->
                                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 bg-blue-800 rounded-lg p-2">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    Semana {{ $semana->numero }}
                                                    @if($semana->nombre)
                                                        - {{ $semana->nombre }}
                                                    @endif
                                                </h3>
                                                <p class="text-sm text-gray-600">
                                                    {{ $semana->actividades->count() }} {{ $semana->actividades->count() === 1 ? 'actividad' : 'actividades' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('profesor.actividades.create', ['aula' => $aula, 'semana' => $semana]) }}"
                                               class="inline-flex items-center px-3 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Actividad
                                            </a>
                                            <form action="{{ route('profesor.semanas.destroy', $semana) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta semana? Se eliminarán todas sus actividades.');">
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

                                    <!-- Lista de actividades -->
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
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2">
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
                                            <div class="px-6 py-8 text-center text-gray-500">
                                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                <p class="text-sm">No hay actividades en esta semana</p>
                                                <a href="{{ route('profesor.actividades.create', ['aula' => $aula, 'semana' => $semana]) }}"
                                                   class="inline-flex items-center mt-3 text-sm text-blue-800 hover:text-blue-900 font-medium">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    Crear primera actividad
                                                </a>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay semanas registradas</h3>
                                    <p class="text-gray-600 mb-4">Comienza creando la primera semana para esta aula</p>
                                    <a href="{{ route('profesor.semanas.create', $aula) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Crear Primera Semana
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pestaña de Documentos -->
                    <div x-show="tab === 'documentos'" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por estudiante</label>
                                <select id="filtroAlumno" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos los estudiantes</option>
                                    @foreach($aula->alumnos as $alumno)
                                        <option value="{{ $alumno->id }}">{{ $alumno->user->nombre }} - {{ $alumno->codigo_matricula }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de documento</label>
                                <select id="filtroDocumento" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Todos los documentos</option>
                                    <option value="ficha">Ficha de Registro</option>
                                    <option value="cronograma">Cronograma</option>
                                    <option value="monitoreo_practicas">Monitoreo de Prácticas</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4" id="listaDocumentos">
                            @foreach($aula->alumnos as $alumno)
                                {{-- Ficha de Registro --}}
                                @if($alumno->fichaRegistro)
                                    <div class="documento-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                                         data-alumno="{{ $alumno->id }}"
                                         data-tipo="ficha">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="flex-shrink-0 bg-cyan-100 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-sm font-semibold text-gray-900">Ficha de Registro</h4>
                                                    <p class="text-sm text-gray-600">{{ $alumno->user->nombre }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        Estado:
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                            @if($alumno->fichaRegistro->aceptado === true) bg-green-100 text-green-800
                                                            @elseif($alumno->fichaRegistro->aceptado === null) bg-yellow-100 text-yellow-800
                                                            @else bg-red-100 text-red-800
                                                            @endif">
                                                            @if($alumno->fichaRegistro->aceptado === true)
                                                                Aprobado
                                                            @elseif($alumno->fichaRegistro->aceptado === null)
                                                                Pendiente
                                                            @else
                                                                Rechazado
                                                            @endif
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('profesor.fichas.show', $alumno->fichaRegistro) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                Ver Documento
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                {{-- Cronograma --}}
                                @if($alumno->fichaRegistro && $alumno->fichaRegistro->cronograma)
                                    <div class="documento-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                                         data-alumno="{{ $alumno->id }}"
                                         data-tipo="cronograma">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-sm font-semibold text-gray-900">Cronograma de Actividades</h4>
                                                    <p class="text-sm text-gray-600">{{ $alumno->user->nombre }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        Firmado:
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                            @if($alumno->fichaRegistro->cronograma->firma_profesor) bg-green-100 text-green-800
                                                            @else bg-gray-100 text-gray-800
                                                            @endif">
                                                            {{ $alumno->fichaRegistro->cronograma->firma_profesor ? 'Sí' : 'Pendiente' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('profesor.cronogramas.show', $alumno->fichaRegistro->cronograma) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                Ver Documento
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Monitoreo de Prácticas --}}
                                    @php
                                        $totalMonitoreos = $alumno->fichaRegistro->cronograma->monitoreosPracticas()->count();
                                    @endphp
                                    <div class="documento-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                                         data-alumno="{{ $alumno->id }}"
                                         data-tipo="monitoreo_practicas">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                                                    <svg class="w-6 h-6 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-sm font-semibold text-gray-900">Monitoreo de Prácticas</h4>
                                                    <p class="text-sm text-gray-600">{{ $alumno->user->nombre }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $totalMonitoreos }} {{ $totalMonitoreos === 1 ? 'semana registrada' : 'semanas registradas' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('profesor.monitoreos-practicas.index', $alumno) }}"
                                               class="inline-flex items-center px-4 py-2 bg-blue-800 hover:bg-blue-900 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                Ver Monitoreos
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div id="noDocuments" class="hidden text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                No se encontraron documentos con los filtros seleccionados
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        // Búsqueda de estudiantes
        document.getElementById('searchEstudiantes')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#tablaEstudiantes tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Filtrado de documentos
        function filtrarDocumentos() {
            const alumnoId = document.getElementById('filtroAlumno')?.value;
            const tipoDoc = document.getElementById('filtroDocumento')?.value;
            const documentos = document.querySelectorAll('.documento-item');
            let visibleCount = 0;

            documentos.forEach(doc => {
                const docAlumno = doc.dataset.alumno;
                const docTipo = doc.dataset.tipo;

                const matchAlumno = !alumnoId || docAlumno === alumnoId;
                const matchTipo = !tipoDoc || docTipo === tipoDoc;

                if (matchAlumno && matchTipo) {
                    doc.style.display = '';
                    visibleCount++;
                } else {
                    doc.style.display = 'none';
                }
            });

            const noDocuments = document.getElementById('noDocuments');
            if (noDocuments) {
                noDocuments.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        document.getElementById('filtroAlumno')?.addEventListener('change', filtrarDocumentos);
        document.getElementById('filtroDocumento')?.addEventListener('change', filtrarDocumentos);
    </script>

</x-app-layout>
