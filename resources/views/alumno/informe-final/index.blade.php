<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Informe Final
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

            {{-- Mensajes --}}
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

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-r-lg shadow-sm"
                     role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Header --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-purple-600 px-8 py-10">
                    <div>
                        <h3 class="text-4xl font-black text-white drop-shadow-lg">Informe Final de Prácticas</h3>
                        <p class="text-purple-50 mt-2 text-lg font-medium">Sube tu informe final en formato PDF</p>
                        @if($semestreActual)
                            <p class="text-purple-100 mt-1 text-sm">Semestre: {{ $semestreActual->nombre }}</p>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$semestreActual)
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-600 text-lg">No hay un semestre activo actualmente.</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Formulario de Carga --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-purple-50 border-b border-purple-200">
                            <h4 class="text-lg font-bold text-purple-900">
                                {{ $informe ? 'Actualizar Informe' : 'Subir Informe' }}
                            </h4>
                        </div>
                        <form method="POST" action="{{ route('alumno.informe-final.store') }}" enctype="multipart/form-data"
                              class="p-6 space-y-6">
                            @csrf

                            <div>
                                <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Archivo PDF <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="archivo" id="archivo" accept=".pdf" required
                                       class="w-full px-4 py-3 border-2 border-purple-300 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 rounded-lg shadow-sm transition-all duration-200">
                                <p class="text-xs text-gray-500 mt-2">
                                    Tamaño máximo: 20MB. Solo archivos PDF.
                                </p>
                                @error('archivo')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="currentColor"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              clip-rule="evenodd" />
                                    </svg>
                                    <div class="text-sm text-blue-700">
                                        <p class="font-semibold mb-1">Recomendaciones:</p>
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Revisa que el archivo no esté corrupto</li>
                                            <li>Asegúrate de que el PDF sea legible</li>
                                            <li>Incluye todas las secciones requeridas</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                {{ $informe ? 'Actualizar Informe' : 'Subir Informe' }}
                            </button>
                        </form>
                    </div>

                    {{-- Estado Actual --}}
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h4 class="text-lg font-bold text-gray-800">Estado del Informe</h4>
                        </div>
                        <div class="p-6">
                            @if($informe)
                                <div class="space-y-4">
                                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                                        <div class="flex items-center">
                                            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-green-800 font-semibold">Informe Subido</p>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-600">Archivo:</span>
                                            <span class="text-sm text-gray-900">{{ $informe->nombre_original }}</span>
                                        </div>
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-600">Tamaño:</span>
                                            <span class="text-sm text-gray-900">{{ $informe->tamanio_formateado }}</span>
                                        </div>
                                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-600">Fecha de Subida:</span>
                                            <span
                                                class="text-sm text-gray-900">{{ $informe->fecha_subida->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('alumno.informe-final.download') }}"
                                       class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Descargar Mi Informe
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No has subido tu informe aún</p>
                                    <p class="text-gray-400 text-sm mt-2">Usa el formulario de la izquierda para subir tu PDF
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('archivo').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const maxSize = 20 * 1024 * 1024; // 20MB

            if (!file) return;

            if (file.type !== 'application/pdf') {
                alert('Solo se permiten archivos PDF');
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                alert('El archivo no debe superar los 20MB');
                this.value = '';
                return;
            }
        });
    </script>
</x-app-layout>
