<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Editar Semana {{ $semana->numero }} - Aula {{ $semana->aula->numero }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $semana->aula->semestre->nombre }}
                </p>
            </div>
            <a href="{{ route('profesor.aulas.show', $semana->aula) }}"
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-white">Editar Semana</h3>
                            <p class="text-blue-200 text-sm mt-1">Actualice la información de la semana</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form action="{{ route('profesor.semanas.update', $semana) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Información de la semana -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">
                                        Editando semana de: <span class="font-bold">Aula {{ $semana->aula->numero }}</span>
                                    </p>
                                    <p class="text-xs text-blue-700 mt-1">
                                        {{ $semana->actividades->count() }} {{ $semana->actividades->count() === 1 ? 'actividad asociada' : 'actividades asociadas' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advertencia si tiene actividades -->
                    @if($semana->actividades->count() > 0)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-yellow-900">
                                        Ten cuidado al modificar el número de semana
                                    </p>
                                    <p class="text-xs text-yellow-700 mt-1">
                                        Esta semana tiene actividades asociadas. Cambiar el número no afectará las actividades, pero podría generar confusión en la organización del curso.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Campo Número de Semana -->
                    <div>
                        <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de Semana <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               name="numero"
                               id="numero"
                               value="{{ old('numero', $semana->numero) }}"
                               min="1"
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
                            Número correlativo de la semana en el curso
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
                               value="{{ old('nombre', $semana->nombre) }}"
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
                            Nombre descriptivo para identificar mejor esta semana
                        </p>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('profesor.aulas.show', $semana->aula) }}"
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
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <!-- Actividades de esta semana (si existen) -->
                @if($semana->actividades->count() > 0)
                    <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Actividades asociadas a esta semana
                        </h4>
                        <div class="space-y-2">
                            @foreach($semana->actividades as $actividad)
                                <div class="bg-white border border-gray-200 rounded-lg px-4 py-3">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $actividad->titulo }}</p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                {{ $actividad->tipoActividad->nombre }} •
                                                Límite: {{ $actividad->fecha_limite->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($actividad->estaActiva()) bg-green-100 text-green-800
                                            @elseif($actividad->estaVencida()) bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            @if($actividad->estaActiva()) Activa
                                            @elseif($actividad->estaVencida()) Vencida
                                            @else Próxima
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
