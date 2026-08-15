<x-app-layout title="Informes de entregas">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Evaluación académica" title="Informes de entregas" description="Revisa el avance y las calificaciones de los trabajos programados." icon="heroicon-o-chart-bar-square" />
    </x-slot>

    <div class="ui-page">
        <div class="px-6 lg:px-12">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-lg shadow-sm"
                     role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Header --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="bg-blue-900 px-8 py-10">
                    <div>
                        <h3 class="text-4xl font-black text-white drop-shadow-lg">Informes de Entregas</h3>
                        <p class="text-indigo-50 mt-2 text-lg font-medium">Revisa y califica los trabajos de tus
                            estudiantes</p>
                    </div>
                </div>
            </div>

            {{-- Lista de Entregas --}}
            @if($entregas->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-600 text-lg">No hay entregas creadas aún.</p>
                    <a href="{{ route('profesor.entregas.create') }}"
                       class="mt-4 inline-flex items-center px-6 py-3 bg-blue-800 text-white font-semibold rounded-lg hover:bg-blue-900 transition">
                        Crear Primera Entrega
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($entregas as $entrega)
                        <div class="bg-white rounded-lg shadow-md  transition-all duration-300 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $entrega['titulo'] }}</h4>
                                        @if($entrega['descripcion'])
                                            <p class="text-gray-600 mb-4">{{ $entrega['descripcion'] }}</p>
                                        @endif

                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($entrega['fecha_inicio'])->format('d/m/Y') }}
                                                - {{ \Carbon\Carbon::parse($entrega['fecha_fin'])->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        {{-- Estadísticas --}}
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                            <div class="bg-blue-50 rounded-lg p-3 text-center">
                                                <div class="text-2xl font-bold text-blue-600">{{ $entrega['total_alumnos'] }}</div>
                                                <div class="text-xs text-blue-700 font-medium">Total Alumnos</div>
                                            </div>
                                            <div class="bg-green-50 rounded-lg p-3 text-center">
                                                <div class="text-2xl font-bold text-green-600">{{ $entrega['entregados'] }}</div>
                                                <div class="text-xs text-green-700 font-medium">Entregados</div>
                                            </div>
                                            <div class="bg-amber-50 rounded-lg p-3 text-center">
                                                <div class="text-2xl font-bold text-amber-600">{{ $entrega['pendientes'] }}</div>
                                                <div class="text-xs text-amber-700 font-medium">Pendientes</div>
                                            </div>
                                            <div class="bg-blue-50 rounded-lg p-3 text-center">
                                                <div class="text-2xl font-bold text-blue-700">{{ $entrega['calificados'] }}</div>
                                                <div class="text-xs text-blue-800 font-medium">Calificados</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <a href="{{ route('profesor.informes.show', $entrega['id']) }}"
                                           class="inline-flex items-center px-6 py-3 ui-btn-primary text-white font-bold rounded-lg shadow-lg  transform  transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Revisar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
