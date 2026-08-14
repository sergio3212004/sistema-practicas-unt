<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Nueva Actividad - Aula {{ $aula->numero }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $aula->semestre?->nombre ?? 'Sin semestre asignado' }}
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

    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-5">
                <h3 class="text-xl font-bold text-white">Crear Nueva Actividad</h3>
                <p class="text-blue-200 text-sm mt-1">Define los detalles de la actividad académica para tus estudiantes</p>
            </div>

            <form action="{{ route('profesor.actividades.store', $aula) }}" method="POST" class="p-6">
                @csrf

                <!-- Título -->
                <div class="mb-6">
                    <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título de la Actividad</label>
                    <input type="text"
                           name="titulo"
                           id="titulo"
                           value="{{ old('titulo') }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           placeholder="Ej: Análisis de caso práctico">
                    @error('titulo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo de Actividad -->
                <div class="mb-6">
                    <label for="tipo_actividad_id" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Actividad</label>
                    <select name="tipo_actividad_id"
                            id="tipo_actividad_id"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">-- Selecciona un tipo --</option>
                        @foreach($tiposActividad as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_actividad_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_actividad_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Semana -->
                <div class="mb-6">
                    <label for="semana_id" class="block text-sm font-medium text-gray-700 mb-2">Semana</label>
                    <select name="semana_id"
                            id="semana_id"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">-- Selecciona una semana --</option>
                        @foreach($semanas as $semana)
                            <option value="{{ $semana->id }}" {{ old('semana_id') == $semana->id ? 'selected' : '' }}>
                                Semana {{ $semana->numero }} {{ $semana->nombre ? '— ' . $semana->nombre : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('semana_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio</label>
                        <input type="datetime-local"
                               name="fecha_inicio"
                               id="fecha_inicio"
                               value="{{ old('fecha_inicio') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('fecha_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fecha_limite" class="block text-sm font-medium text-gray-700 mb-2">Fecha Límite</label>
                        <input type="datetime-local"
                               name="fecha_limite"
                               id="fecha_limite"
                               value="{{ old('fecha_limite') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        @error('fecha_limite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-8">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción (Opcional)</label>
                    <textarea name="descripcion"
                              id="descripcion"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                              placeholder="Detalla las instrucciones, objetivos o entregables...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Acciones -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('profesor.aulas.show', $aula) }}"
                       class="px-5 py-2.5 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                        Crear Actividad
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
