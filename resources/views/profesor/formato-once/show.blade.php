<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-full">
        <div class="mb-6">
            <a href="{{ route('profesor.formato-once.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </a>
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Formato 11 - Conformidad de PPP</h1>
                    <p class="text-gray-600 mt-2">Aula {{ $formatoOnce->aula->numero }} - {{ $formatoOnce->aula->semestre->nombre ?? 'Sin semestre' }}</p>
                    <p class="text-sm text-gray-500 mt-1">Creado: {{ $formatoOnce->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('profesor.formato-once.pdf', $formatoOnce->id) }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar PDF
                    </a>
                    <a href="{{ route('profesor.formato-once.edit', $formatoOnce->id) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form action="{{ route('profesor.formato-once.destroy', $formatoOnce->id) }}"
                          method="POST"
                          onsubmit="return confirm('¿Está seguro de eliminar este formato? Esta acción no se puede deshacer.');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Información del coordinador -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Información del Coordinador</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nombre del Coordinador</p>
                    <p class="text-lg font-medium text-gray-900">{{ $formatoOnce->aula->profesor->nombre_completo ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Fecha</p>
                    <p class="text-lg font-medium text-gray-900">{{ $formatoOnce->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            @if($formatoOnce->firma_coordinador)
                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">Firma del Coordinador</p>
                    <div class="border border-gray-300 rounded-lg p-4 inline-block bg-white">
                        <img src="{{ asset('storage/' . $formatoOnce->firma_coordinador) }}"
                             alt="Firma del Coordinador"
                             class="max-w-xs h-auto">
                    </div>
                </div>
            @endif
        </div>

        <!-- Tabla de alumnos -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Alumnos Registrados ({{ $formatoOnce->formatoOnceAlumnos->count() }})</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sede de Prácticas</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Competencias</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacidades</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actividades</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Conformidad</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comentarios</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($formatoOnce->formatoOnceAlumnos as $index => $registro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $registro->alumno->nombre_completo }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $registro->alumno->codigo_matricula }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                {{ $registro->sede_practicas ?? '-' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                {{ $registro->ciclo_nivel ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $registro->competencias ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $registro->capacidades ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $registro->actividades ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $registro->producto ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @if($registro->conformidad)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        SÍ
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        NO
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <div class="max-w-xs">
                                    {{ $registro->comentarios ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Alumnos</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $formatoOnce->formatoOnceAlumnos->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Conformes</p>
                        <p class="text-2xl font-semibold text-green-600">
                            {{ $formatoOnce->formatoOnceAlumnos->where('conformidad', true)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">No Conformes</p>
                        <p class="text-2xl font-semibold text-red-600">
                            {{ $formatoOnce->formatoOnceAlumnos->where('conformidad', false)->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
