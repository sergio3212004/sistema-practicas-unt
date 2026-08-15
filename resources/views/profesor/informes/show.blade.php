<x-app-layout :title="$entrega->titulo">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Evaluación académica" :title="$entrega->titulo" description="Revisa trabajos y registra calificaciones." icon="heroicon-o-clipboard-document-check"><x-slot name="actions"><a href="{{ route('profesor.informes.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver</a></x-slot></x-ui.page-header>
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
                                  clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Información de la Entrega --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="bg-blue-900 px-8 py-8">
                    <h3 class="text-3xl font-black text-white drop-shadow-lg">{{ $entrega->titulo }}</h3>
                    @if($entrega->descripcion)
                        <p class="text-indigo-50 mt-2 text-base">{{ $entrega->descripcion }}</p>
                    @endif
                    <div class="flex items-center gap-6 mt-4 text-indigo-100">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Inicio: {{ \Carbon\Carbon::parse($entrega->fecha_inicio)->format('d/m/Y') }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Fin: {{ \Carbon\Carbon::parse($entrega->fecha_fin)->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tabla de Alumnos --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h4 class="text-lg font-bold text-gray-800">Entregas de Alumnos</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <caption class="sr-only">Estado de entregas de estudiantes</caption>
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
                                Link de Entrega
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Fecha Subida
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Calificación
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alumnos as $alumno)
                            <tr class="hover:bg-gray-50 transition" id="alumno-{{ $alumno['id'] }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $alumno['codigo'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $alumno['apellido_paterno'] }} {{ $alumno['apellido_materno'] }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $alumno['nombres'] }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($alumno['link_entrega'])
                                        <a href="{{ $alumno['link_entrega'] }}" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center text-blue-800 hover:text-blue-950 text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            Ver trabajo <span class="sr-only">(se abre en una pestaña nueva)</span>
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">Sin entregar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($alumno['fecha_subida'])
                                        {{ \Carbon\Carbon::parse($alumno['fecha_subida'])->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($alumno['nota'] !== null)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                                    {{ $alumno['nota'] >= 14 ? 'bg-green-100 text-green-800' : ($alumno['nota'] >= 11 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ number_format($alumno['nota'], 2) }}
                                            </span>
                                    @else
                                        <span class="text-sm text-gray-400">Sin calificar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($alumno['entrega_alumno_id'])
                                        <button type="button" onclick="abrirModalCalificar({{ json_encode($alumno) }})"
                                                class="inline-flex items-center px-4 py-2 bg-blue-800 text-white font-semibold rounded-lg hover:bg-blue-900 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Calificar
                                        </button>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Calificación --}}
    <div id="modalCalificar" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto z-50"
         role="dialog" aria-modal="true" aria-labelledby="modalCalificarTitulo" aria-describedby="modalAlumnoNombre">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-sm max-w-2xl w-full">
                <form id="formCalificar" method="POST">
                    @csrf
                    <div class="px-8 py-6 bg-blue-900">
                        <h2 id="modalCalificarTitulo" class="text-2xl font-bold text-white">Calificar entrega</h2>
                        <p class="text-indigo-100 mt-1" id="modalAlumnoNombre"></p>
                    </div>

                    <div class="p-8 space-y-6">
                        {{-- Link de Entrega --}}
                        <div>
                            <p class="block text-sm font-semibold text-gray-700 mb-2">Enlace de entrega</p>
                            <a id="modalLinkEntrega" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center text-blue-800 hover:text-blue-950 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <span id="modalLinkTexto">Ver trabajo del alumno</span>
                                <span class="sr-only">(se abre en una pestaña nueva)</span>
                            </a>
                        </div>

                        {{-- Nota --}}
                        <div>
                            <label for="nota" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nota (0-20) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="nota" id="nota" min="0" max="20" step="0.01" required
                                   class="w-full px-4 py-3 border-2 border-indigo-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 rounded-lg shadow-sm transition-all duration-200">
                        </div>

                        {{-- Comentario --}}
                        <div>
                            <label for="comentario_profesor" class="block text-sm font-semibold text-gray-700 mb-2">
                                Comentario
                            </label>
                            <textarea name="comentario_profesor" id="comentario_profesor" rows="4"
                                      placeholder="Escribe un comentario para el alumno..."
                                      class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm transition-all duration-200 resize-none"></textarea>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-gray-50 flex items-center justify-end gap-4 rounded-b-lg">
                        <button type="button" onclick="cerrarModalCalificar()"
                                class="px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-8 py-3 ui-btn-primary text-white font-bold rounded-lg shadow-lg  transform  transition-all duration-200">
                            Guardar Calificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let modalCalificarTrigger = null;

        function abrirModalCalificar(alumno) {
            const modal = document.getElementById('modalCalificar');
            const form = document.getElementById('formCalificar');
            const nombreElement = document.getElementById('modalAlumnoNombre');
            const linkElement = document.getElementById('modalLinkEntrega');
            const notaInput = document.getElementById('nota');
            const comentarioInput = document.getElementById('comentario_profesor');

            // Configurar el formulario
            form.action = `/profesor/informes/${alumno.entrega_alumno_id}/calificar`;

            // Configurar nombre del alumno
            nombreElement.textContent = `${alumno.nombres} ${alumno.apellido_paterno} ${alumno.apellido_materno}`;

            // Configurar link
            linkElement.href = alumno.link_entrega;

            // Rellenar valores existentes
            notaInput.value = alumno.nota || '';
            comentarioInput.value = alumno.comentario_profesor || '';

            // Mostrar modal
            modalCalificarTrigger = document.activeElement;
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            requestAnimationFrame(() => notaInput.focus());
        }

        function cerrarModalCalificar() {
            const modal = document.getElementById('modalCalificar');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            modalCalificarTrigger?.focus();
        }

        // Cerrar modal al hacer clic fuera de él
        document.getElementById('modalCalificar').addEventListener('click', function (e) {
            if (e.target === this) {
                cerrarModalCalificar();
            }
        });

        document.getElementById('modalCalificar').addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                cerrarModalCalificar();
                return;
            }

            if (e.key !== 'Tab') return;

            const focusable = [...this.querySelectorAll('a[href], button, input, textarea')]
                .filter(element => !element.disabled && element.offsetParent !== null);
            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        });
    </script>
    @endpush
</x-app-layout>
