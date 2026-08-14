<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Informes Finales
            </h2>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver al Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 mt-12">
        <div class="px-6 lg:px-12">

            {{-- Mensajes --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-lg shadow-sm"
                     role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Header --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="bg-gradient-to-r from-teal-500 via-cyan-500 to-teal-600 px-8 py-10">
                    <div>
                        <h3 class="text-4xl font-black text-white drop-shadow-lg">Informes Finales de Alumnos</h3>
                        <p class="text-teal-50 mt-2 text-lg font-medium">Gestiona los informes finales del sistema</p>
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Informes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalInformes }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-amber-500 rounded-md p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Alumnos sin Informe</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $alumnosSinInforme }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Por Año</p>
                            <p class="text-sm text-gray-900">
                                @foreach($informesPorAnio as $anio => $count)
                                    <span class="inline-block mr-2">{{ $anio }}: {{ $count }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buscador --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <form method="GET" action="{{ route('admin.informes-finales.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                                Buscar por Alumno
                            </label>
                            <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}"
                                   placeholder="Nombre, apellido o código..."
                                   class="w-full px-4 py-3 border-2 border-gray-300 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 rounded-lg shadow-sm transition-all duration-200">
                        </div>
                        <div>
                            <label for="semestre_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Filtrar por Año/Semestre
                            </label>
                            <select name="semestre_id" id="semestre_id"
                                    class="w-full px-4 py-3 border-2 border-gray-300 focus:border-teal-500 focus:ring-4 focus:ring-teal-100 rounded-lg shadow-sm transition-all duration-200">
                                <option value="">Todos los semestres</option>
                                @foreach($semestres as $semestre)
                                    <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                        {{ $semestre->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                            <a href="{{ route('admin.informes-finales.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabla de Informes --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Código
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Alumno
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Semestre
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Fecha de Subida
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tamaño
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($informes as $informe)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $informe->alumno->codigo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $informe->alumno->apellido_paterno }}
                                        {{ $informe->alumno->apellido_materno }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $informe->alumno->nombres }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $informe->semestre ? $informe->semestre->nombre : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $informe->fecha_subida->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $informe->tamanio_formateado }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.informes-finales.download', $informe->id) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Descargar
                                        </a>
                                        <form method="POST"
                                              action="{{ route('admin.informes-finales.destroy', $informe->id) }}"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este informe?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg">No se encontraron informes finales</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($informes->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $informes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
