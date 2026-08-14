<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Nueva Entrega
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

            {{-- Mensaje de éxito --}}
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

            {{-- Card del formulario --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">

                {{-- Header con gradiente --}}
                <div class="bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 px-8 py-10">
                    <div>
                        <h3 class="text-4xl font-black text-white drop-shadow-lg">Nueva Entrega</h3>
                        <p class="text-amber-50 mt-2 text-lg font-medium">Asigna una tarea a tus estudiantes</p>
                    </div>
                </div>

                {{-- Contenido del formulario --}}
                <div class="px-12 py-10">
                    <form method="POST" action="{{ route('profesor.entregas.store') }}" class="space-y-8">
                        @csrf

                        {{-- Título de la entrega con selector de semana --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-3 text-base">
                                Título de la Entrega <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <span class="text-gray-700 font-medium">Entrega de trabajo - Semana</span>
                                <select name="semana" id="semanaSel" required
                                        class="w-24 px-4 py-3 border-2 border-amber-300 focus:border-amber-500 focus:ring-4 focus:ring-amber-100 rounded-xl shadow-sm transition-all duration-200 font-bold text-lg text-gray-700 hover:border-amber-400">
                                    @for ($i = 1; $i <= 14; $i++)
                                        <option value="{{ $i }}" {{ $i == $semanaSugerida ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <input type="hidden" name="titulo" id="tituloCompleto"
                                   value="Entrega de trabajo - Semana {{ $semanaSugerida }}">
                            @error('titulo')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                          clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label class="block font-semibold text-gray-700 mb-3 text-base">
                                Descripción
                            </label>
                            <textarea name="descripcion" rows="4"
                                      placeholder="Instrucciones adicionales para los alumnos (opcional)..."
                                      class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100 rounded-xl shadow-sm transition-all duration-200 resize-none hover:border-gray-400">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                          clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Fechas de entrega --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-semibold text-gray-700 mb-3 text-base">
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inicio" id="fechaInicio"
                                       value="{{ old('fecha_inicio', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required
                                       class="w-full px-4 py-3 border-2 border-green-300 focus:border-green-500 focus:ring-4 focus:ring-green-100 rounded-xl shadow-sm transition-all duration-200 font-medium hover:border-green-400">
                                @error('fecha_inicio')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                              clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block font-semibold text-gray-700 mb-3 text-base">
                                    Fecha de Fin <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_fin" id="fechaFin"
                                       value="{{ old('fecha_fin', date('Y-m-d', strtotime('+7 days'))) }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                       class="w-full px-4 py-3 border-2 border-purple-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 rounded-xl shadow-sm transition-all duration-200 font-medium hover:border-purple-400">
                                <p class="text-xs text-gray-500 mt-2">
                                    Sugerimos 7 días (1 semana)
                                </p>
                                @error('fecha_fin')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                              clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-600 to-yellow-600 hover:from-amber-700 hover:to-yellow-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2')
                                Crear Entrega
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Información adicional --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="group bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-default">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-14 h-14 bg-blue-500 rounded-lg flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-blue-900 text-base mb-2">Periodo de 7 días</h4>
                    <p class="text-sm text-blue-700">Sugerimos 1 semana para completar la tarea</p>
                </div>
            </div>

            <div
                class="group bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-default">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-14 h-14 bg-green-500 rounded-lg flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-green-900 text-base mb-2">Visible al instante</h4>
                    <p class="text-sm text-green-700">Los alumnos verán la entrega inmediatamente</p>
                </div>
            </div>

            <div
                class="group bg-gradient-to-br from-amber-50 to-yellow-100 border-2 border-amber-200 rounded-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-default">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-14 h-14 bg-amber-500 rounded-lg flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-amber-900 text-base mb-2">Entrega por link</h4>
                    <p class="text-sm text-amber-700">Los alumnos entregarán un link de su informe subido al Drive</p>
                </div>
            </div>
        </div>

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const semanaSel = document.getElementById('semanaSel');
            const tituloCompleto = document.getElementById('tituloCompleto');
            const fechaInicio = document.getElementById('fechaInicio');
            const fechaFin = document.getElementById('fechaFin');

            // Actualizar título cuando cambia la semana
            semanaSel.addEventListener('change', function () {
                const semana = this.value;
                const nuevoTitulo = `Entrega de trabajo - Semana ${semana}`;
                tituloCompleto.value = nuevoTitulo;
            });

            // Actualizar fecha fin automáticamente (7 días después de la fecha inicio)
            fechaInicio.addEventListener('change', function () {
                const fechaInicioDate = new Date(this.value);
                if (!isNaN(fechaInicioDate)) {
                    // Sumar 7 días
                    fechaInicioDate.setDate(fechaInicioDate.getDate() + 7);

                    // Formatear la fecha
                    const year = fechaInicioDate.getFullYear();
                    const month = String(fechaInicioDate.getMonth() + 1).padStart(2, '0');
                    const day = String(fechaInicioDate.getDate()).padStart(2, '0');

                    fechaFin.value = `${year}-${month}-${day}`;
                }
            });
        });
    </script>
</x-app-layout>
