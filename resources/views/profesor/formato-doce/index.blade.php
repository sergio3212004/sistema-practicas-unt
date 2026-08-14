<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-900">Monitoreo de Prácticas Pre Profesionales</h1>
                        <p class="text-gray-600 mt-2">Gestión de formatos F12</p>
                    </div>
                    <a href="{{ route('profesor.formato-doce.create') }}"
                       class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nuevo Formato
                    </a>
                </div>
            </div>

            <!-- Mensajes de Éxito -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Mensajes de Error -->
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Tabla de Formatos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                @if($formatos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-900">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Curso
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Ciclo
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Semestre
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    N° Estudiantes
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($formatos as $formato)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ $formato->created_at->format('d/m/Y') }}
                                        <span class="block text-xs text-gray-500">{{ $formato->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="font-medium">{{ $formato->aula->curso->nombre ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Ciclo {{ $formato->aula->ciclo ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $formato->aula->semestre->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-800 rounded-full font-bold">
                                            {{ $formato->formatosDoceAlumnos->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center gap-3">
                                            <a href="{{ route('profesor.formato-doce.show', $formato->id) }}"
                                               class="inline-flex items-center text-blue-700 hover:text-blue-900 font-semibold transition duration-150"
                                               title="Ver detalles">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Ver
                                            </a>
                                            <form action="{{ route('profesor.formato-doce.destroy', $formato->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este formato? Esta acción no se puede deshacer.');"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold transition duration-150"
                                                        title="Eliminar formato">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($formatos->hasPages())
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            {{ $formatos->links() }}
                        </div>
                    @endif
                @else
                    <!-- Estado vacío -->
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No hay formatos registrados</h3>
                        <p class="mt-2 text-sm text-gray-500">Comience creando un nuevo formato de monitoreo de prácticas pre profesionales.</p>
                        <div class="mt-6">
                            <a href="{{ route('profesor.formato-doce.create') }}"
                               class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-blue-700 hover:bg-blue-800 transition duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Crear Primer Formato
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-700 p-4 rounded-r-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-700 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Los formatos de monitoreo registran el seguimiento de las prácticas pre profesionales de los estudiantes, incluyendo información sobre la sede de práctica, responsables y avances.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
