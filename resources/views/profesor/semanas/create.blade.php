<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Nueva Semana - Aula {{ $aula->numero }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $aula->semestre->nombre }}
                </p>
            </div>
            <a href="{{ route('profesor.aulas.show', $aula) }}"
               class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors duration-200 shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Aula
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">

                <!-- Header del formulario -->
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg p-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-white">Crear Nueva Semana</h3>
                            <p class="text-blue-200 text-sm mt-1">Complete la información de la semana</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form action="{{ route('profesor.semanas.store', $aula) }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Información del aula -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-900">
                                    Creando semana para: <span class="font-bold">Aula {{ $aula->numero }}</span>
                                </p>
                                <p class="text-xs text-blue-700 mt-1">
                                    Total de semanas existentes: {{ $aula->semanas->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Campo Número de Semana -->
                    <div>
                        <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Semana <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="numero"
                               id="numero"
                               value="{{ old('numero', $siguienteNumero) }}"
                               min="1"
                               max="15"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('numero') border-red-500 @enderror">
                        @error('numero')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Número correlativo de la semana (sugerido: {{ $siguienteNumero }})
                        </p>
                    </div>

                    <!-- Campo Nombre/Descripción -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre o Descripción (opcional)
                        </label>
                        <input type="text"
                               name="nombre"
                               id="nombre"
                               value="{{ old('nombre') }}"
                               maxlength="255"
                               placeholder="Ej: Introducción al proyecto, Desarrollo de metodología, etc."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Puedes agregar un nombre descriptivo para identificar mejor esta semana
                        </p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('profesor.aulas.show', $aula) }}"
                           class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-800 hover:bg-blue-900 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Crear Semana
                        </button>
                    </div>
                </form>

                <!-- Semanas existentes (referencia) -->
                @if($aula->semanas->count() > 0)
                    <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Semanas existentes en esta aula
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach($aula->semanas->sortBy('numero') as $semana)
                                <div class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-center">
                                    <p class="text-xs text-gray-500">Semana</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $semana->numero }}</p>
                                    @if($semana->nombre)
                                        <p class="text-xs text-gray-600 truncate">{{ $semana->nombre }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
