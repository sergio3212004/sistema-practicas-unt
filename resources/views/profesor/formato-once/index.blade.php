<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Formato 11 - Conformidad de Prácticas Pre Profesionales</h1>
            <p class="text-gray-600 mt-2">Gestione los formatos de conformidad para sus aulas asignadas</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($aulas as $aula)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4">
                        <h3 class="text-xl font-semibold">Aula {{ $aula->numero }}</h3>
                        <p class="text-blue-100 text-sm">{{ $aula->semestre->nombre ?? 'Sin semestre' }}</p>
                    </div>

                    <div class="p-4">
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span class="font-medium">{{ $aula->alumnos->count() }}</span> alumnos
                            </div>

                            @if($aula->formatosOnce->count() > 0)
                                <div class="flex items-center text-sm text-green-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $aula->formatosOnce->count() }} formato(s) creado(s)
                                </div>
                            @else
                                <div class="flex items-center text-sm text-orange-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    Sin formatos
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-2 mt-4">
                            @if($aula->formatosOnce->count() > 0)
                                <a href="{{ route('profesor.formato-once.list', $aula->id) }}"
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded transition-colors duration-200 text-sm font-medium">
                                    Ver Formatos ({{ $aula->formatosOnce->count() }})
                                </a>
                            @endif

                            @if($aula->alumnos->count() > 0)
                                <a href="{{ route('profesor.formato-once.create', $aula->id) }}"
                                   class="flex-1 bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded transition-colors duration-200 text-sm font-medium">
                                    Crear Formato
                                </a>
                            @else
                                <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 text-center py-2 px-4 rounded cursor-not-allowed text-sm font-medium"
                                        title="El aula no tiene alumnos asignados">
                                    Sin Alumnos
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No tiene aulas asignadas</h3>
                        <p class="text-gray-600">Contacte al administrador para que le asigne aulas.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
