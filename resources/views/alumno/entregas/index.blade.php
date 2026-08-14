<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis Entregas
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
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-lg shadow-sm"
                     role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Header --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-500 via-cyan-500 to-blue-600 px-8 py-10">
                    <div>
                        <h3 class="text-4xl font-black text-white drop-shadow-lg">Mis Entregas</h3>
                        <p class="text-blue-50 mt-2 text-lg font-medium">Revisa tus trabajos y calificaciones</p>
                    </div>
                </div>
            </div>

            {{-- Lista de Entregas --}}
            @if(isset($mensaje))
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-600 text-lg">{{ $mensaje }}</p>
                </div>
            @elseif($entregas->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-600 text-lg">No hay entregas asignadas aún.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($entregas as $entrega)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-xl font-bold text-gray-800">{{ $entrega['titulo'] }}</h4>
                                            @if($entrega['estado'] == 'Calificado')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                                    {{ $entrega['nota'] >= 14 ? 'bg-green-100 text-green-800' : ($entrega['nota'] >= 11 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    Nota: {{ number_format($entrega['nota'], 2) }}
                                                </span>
                                            @elseif($entrega['estado'] == 'Entregado')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                                    Entregado
                                                </span>
                                            @elseif($entrega['estado'] == 'Vencido')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                                    Vencido
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-amber-100 text-amber-800">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </div>

                                        @if($entrega['descripcion'])
                                            <p class="text-gray-600 mb-3">{{ $entrega['descripcion'] }}</p>
                                        @endif

                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Inicio: {{ \Carbon\Carbon::parse($entrega['fecha_inicio'])->format('d/m/Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Fin: {{ \Carbon\Carbon::parse($entrega['fecha_fin'])->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        {{-- Información de entrega --}}
                                        @if($entrega['link_entrega'])
                                            <div class="bg-blue-50 rounded-lg p-4 mb-3">
                                                <p class="text-sm font-semibold text-blue-900 mb-2">Tu entrega:</p>
                                                <a href="{{ $entrega['link_entrega'] }}" target="_blank"
                                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                    </svg>
                                                    Ver mi trabajo
                                                </a>
                                                @if($entrega['fecha_subida'])
                                                    <p class="text-xs text-blue-700 mt-1">
                                                        Entregado: {{ \Carbon\Carbon::parse($entrega['fecha_subida'])->format('d/m/Y H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Comentario del profesor --}}
                                        @if($entrega['comentario_profesor'])
                                            <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                                                <p class="text-sm font-semibold text-purple-900 mb-1">Comentario del
                                                    profesor:</p>
                                                <p class="text-sm text-purple-800">{{ $entrega['comentario_profesor'] }}</p>
                                                @if($entrega['fecha_revision'])
                                                    <p class="text-xs text-purple-600 mt-2">
                                                        Revisado: {{ \Carbon\Carbon::parse($entrega['fecha_revision'])->format('d/m/Y H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4">
                                        @if(!$entrega['link_entrega'] && $entrega['estado'] != 'Vencido')
                                            <button onclick="abrirModalSubir({{ $entrega['id'] }})"
                                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                Entregar
                                            </button>
                                        @elseif($entrega['link_entrega'] && $entrega['estado'] != 'Vencido' && !$entrega['nota'])
                                            <button onclick="abrirModalSubir({{ $entrega['id'] }}, '{{ $entrega['link_entrega'] }}')"
                                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-yellow-600 hover:from-amber-700 hover:to-yellow-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Actualizar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Modal para subir link --}}
    <div id="modalSubir" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto z-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full">
                <form id="formSubir" method="POST">
                    @csrf
                    <div class="px-8 py-6 bg-gradient-to-r from-blue-500 to-cyan-600">
                        <h3 class="text-2xl font-bold text-white">Subir Entrega</h3>
                        <p class="text-blue-100 mt-1">Proporciona el link de tu trabajo</p>
                    </div>

                    <div class="p-8 space-y-6">
                        <div>
                            <label for="link_entrega" class="block text-sm font-semibold text-gray-700 mb-2">
                                Link del Trabajo (Google Drive, GitHub, etc.) <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="link_entrega" id="link_entrega" required
                                   placeholder="https://drive.google.com/..."
                                   class="w-full px-4 py-3 border-2 border-blue-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 rounded-lg shadow-sm transition-all duration-200">
                            <p class="text-xs text-gray-500 mt-2">Asegúrate de que el link sea accesible para el
                                profesor</p>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-gray-50 flex items-center justify-end gap-4 rounded-b-lg">
                        <button type="button" onclick="cerrarModalSubir()"
                                class="px-6 py-3 bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-semibold rounded-lg transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            Guardar Entrega
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function abrirModalSubir(entregaId, linkActual = '') {
            const modal = document.getElementById('modalSubir');
            const form = document.getElementById('formSubir');
            const linkInput = document.getElementById('link_entrega');

            form.action = `/alumno/mis-entregas/${entregaId}/guardar-link`;
            linkInput.value = linkActual;

            modal.classList.remove('hidden');
        }

        function cerrarModalSubir() {
            const modal = document.getElementById('modalSubir');
            modal.classList.add('hidden');
        }

        document.getElementById('modalSubir').addEventListener('click', function (e) {
            if (e.target === this) {
                cerrarModalSubir();
            }
        });
    </script>
</x-app-layout>
