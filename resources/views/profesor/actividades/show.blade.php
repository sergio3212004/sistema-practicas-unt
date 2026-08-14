<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ $actividad->titulo }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $actividad->aula->semestre?->nombre ?? 'Sin semestre' }} ·
                    {{ $actividad->tipoActividad->nombre }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('profesor.aulas.show', $actividad->aula) }}"
                   class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-gh"/>
                    </svg>
                    Volver al Aula
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Detalles de la actividad -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200 mb-8">
            <div class="bg-gradient-to-r from-blue-700 to-blue-800 px-6 py-5">
                <h3 class="text-xl font-bold text-white">Detalles de la Actividad</h3>
                <p class="text-blue-200 text-sm mt-1">Información clave sobre esta tarea</p>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Semana</p>
                        <p class="text-gray-800">Semana {{ $actividad->semana->numero }} {{ $actividad->semana->nombre ? '— ' . $actividad->semana->nombre : '' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fechas</p>
                        <p class="text-gray-800">
                            <span class="font-medium">Inicio:</span> {{ $actividad->fecha_inicio->format('d/m/Y H:i') }}<br>
                            <span class="font-medium">Límite:</span> {{ $actividad->fecha_limite->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                @if($actividad->descripcion)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Descripción</p>
                        <p class="text-gray-700 whitespace-pre-line">{{ $actividad->descripcion }}</p>
                    </div>
                @endif

                <!-- Acciones rápidas -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                    <form action="{{ route('profesor.actividades.destroy', $actividad) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta actividad? Esto también eliminará todas las entregas asociadas.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white font-medium rounded-lg shadow-md hover:from-red-700 hover:to-red-800 focus:ring-2 focus:ring-red-500 focus:outline-none transition">
                            Eliminar Actividad
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Entregas -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-5">
                <h3 class="text-xl font-bold text-white">Entregas de Alumnos</h3>
                <p class="text-emerald-200 text-sm mt-1">
                    {{ $actividad->entregas->count() }} entrega(s) registrada(s)
                </p>
            </div>

            <div class="p-6">
                @if($actividad->entregas->isEmpty())
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h4 class="mt-4 text-lg font-medium text-gray-700">Aún no hay entregas</h4>
                        <p class="text-gray-500">Los alumnos aún no han enviado trabajos para esta actividad.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entregado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($actividad->entregas as $entrega)
                                @php
                                    $estado = $entrega->obtenerEstadoVisual();
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <!-- Alumno -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">
                                            {{ $entrega->alumno->user->nombre }} ({{ $entrega->alumno->codigo_matricula }})
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $entrega->alumno->matricula }}</div>
                                    </td>

                                    <!-- Nota -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($entrega->estaCalificada())
                                            <span class="font-bold text-green-700">{{ number_format($entrega->nota, 1) }}</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>

                                    <!-- Estado -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estado['clase'] }}">
                    {{ $estado['texto'] }}
                </span>
                                    </td>

                                    <!-- Entregado (fecha) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @if($entrega->fecha_entrega)
                                            {{ $entrega->fecha_entrega->format('d/m H:i') }}
                                            @if(!$entrega->fueEntregadaATiempo())
                                                <span class="ml-2 inline-flex items-center text-xs text-red-600">
                            ⏰ Fuera de plazo
                        </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <!-- Ver archivo -->
                                        @if($entrega->actividad->tipoActividad->modo_entrega === "pdf")
                                            <a href="{{ asset('storage/' . $entrega->ruta) }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                Ver archivo
                                            </a>
                                        @elseif($entrega->actividad->tipoActividad->modo_entrega === "drive")
                                            <a href="{{ $entrega->ruta }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                Ver archivo
                                            </a>
                                        @endif

                                        <!-- Calificar -->
                                        <button type="button"
                                                onclick="openCalificarModal({{ $entrega->id }}, '{{ $entrega->alumno->user->nombre }}')"
                                                class="text-indigo-600 hover:text-indigo-900">
                                            {{ $entrega->estaCalificada() ? 'Editar nota' : 'Calificar' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de Calificación (dinámico con JS simple) -->
    <div id="modal-calificar" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Calificar entrega</h3>
                <p id="modal-alumno" class="text-sm text-gray-500"></p>
            </div>
            <form id="form-calificar" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="entrega_id" id="entrega_id">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nota (0–20)</label>
                    <input type="number" name="nota" min="0" max="20" step="0.1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones (opcional)</label>
                    <textarea name="observaciones" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50">Cancelar</button>
                    <button type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg shadow-md hover:from-indigo-700 hover:to-indigo-800">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function openCalificarModal(entregaId, nombreAlumno) {
                document.getElementById('entrega_id').value = entregaId;
                document.getElementById('modal-alumno').textContent = 'Alumno: ' + nombreAlumno;
                document.getElementById('form-calificar').action = `/profesor/entregas/${entregaId}/calificar`;
                document.getElementById('modal-calificar').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('modal-calificar').classList.add('hidden');
            }

            // Cerrar modal al hacer clic fuera
            document.getElementById('modal-calificar').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        </script>
    @endpush
</x-app-layout>
