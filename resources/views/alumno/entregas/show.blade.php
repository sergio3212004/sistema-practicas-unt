{{-- resources/views/alumno/entregas/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Detalle de Entrega
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $entrega->actividad->titulo }}
                </p>
            </div>
            <a href="{{ route('alumno.aula.index', $entrega->actividad->aula) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver al Aula
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Columna Principal --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Estado de la Entrega --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                @svg('heroicon-o-document-check', 'w-5 h-5 mr-2 text-indigo-600')
                                Estado de la Entrega
                            </h3>
                        </div>

                        <div class="p-6">
                            @php
                                $estadoVisual = $entrega->obtenerEstadoVisual();
                            @endphp

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    @if($entrega->estado === 'entregado')
                                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                                            @svg('heroicon-o-check-circle', 'w-8 h-8 text-blue-600')
                                        </div>
                                    @elseif($entrega->estado === 'observado')
                                        <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center">
                                            @svg('heroicon-o-eye', 'w-8 h-8 text-emerald-600')
                                        </div>
                                    @elseif($entrega->estado === 'rechazado')
                                        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                                            @svg('heroicon-o-x-circle', 'w-8 h-8 text-red-600')
                                        </div>
                                    @else
                                        <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center">
                                            @svg('heroicon-o-clock', 'w-8 h-8 text-amber-600')
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold {{ $estadoVisual['clase'] }}">
                                            {{ $estadoVisual['texto'] }}
                                        </span>

                                        @if($entrega->fueEntregadaATiempo())
                                            <span class="inline-flex items-center text-xs font-medium text-emerald-700">
                                                @svg('heroicon-o-check', 'w-4 h-4 mr-1')
                                                A tiempo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-xs font-medium text-red-700">
                                                @svg('heroicon-o-exclamation-triangle', 'w-4 h-4 mr-1')
                                                Fuera de plazo
                                            </span>
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            @svg('heroicon-o-calendar', 'w-4 h-4 mr-2 text-gray-400')
                                            <span class="font-medium">Fecha de entrega:</span>
                                            <span class="ml-2">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</span>
                                        </div>

                                        @if($entrega->estaCalificada())
                                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        @svg('heroicon-o-star', 'w-5 h-5 text-yellow-600')
                                                        <span class="text-sm font-medium text-gray-700">Calificación</span>
                                                    </div>
                                                    <span class="text-2xl font-bold text-yellow-700">{{ $entrega->nota }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                                <p class="text-sm text-blue-800 flex items-center">
                                                    @svg('heroicon-o-information-circle', 'w-4 h-4 mr-2')
                                                    Pendiente de calificación
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Archivo Entregado --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                @svg('heroicon-o-paper-clip', 'w-5 h-5 mr-2 text-indigo-600')
                                Archivo Entregado
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($entrega->actividad->tipoActividad->modo_entrega === 'drive')
                                {{-- Enlace directo a Google Drive --}}
                                <a href="{{ $entrega->ruta }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                    @svg('heroicon-o-arrow-top-right-on-square', 'w-4 h-4 mr-1.5')
                                    Abrir en Google Drive
                                </a>
                            @else
                                {{-- Enlace directo al archivo en storage --}}
                                <a href="{{ asset('storage/entregas/' . basename($entrega->ruta)) }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                    @svg('heroicon-o-document-text', 'w-4 h-4 mr-1.5')
                                    Ver archivo
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Observaciones del Alumno --}}
                    @if($entrega->observaciones)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    @svg('heroicon-o-chat-bubble-left-right', 'w-5 h-5 mr-2 text-purple-600')
                                    Mis Observaciones
                                </h3>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $entrega->observaciones }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Acciones --}}
                    @if(in_array($entrega->estado, ['rechazado', 'observado']) && !$entrega->actividad->estaVencida())
                        <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-amber-600')
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-amber-900 mb-2">
                                        {{ $entrega->estado === 'rechazado' ? 'Entrega Rechazada' : 'Requiere Correcciones' }}
                                    </h4>
                                    <p class="text-sm text-amber-800 mb-4">
                                        Puedes reenviar tu trabajo con las correcciones necesarias antes de la fecha límite.
                                    </p>
                                    <a href="{{ route('alumno.entregas.edit', $entrega) }}"
                                       class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        @svg('heroicon-o-arrow-path', 'w-4 h-4 mr-2')
                                        Reenviar Entrega
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Columna Lateral --}}
                <div class="space-y-6">

                    {{-- Información de la Actividad --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 px-5 py-4 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">
                                Información
                            </h3>
                        </div>

                        <div class="p-5 space-y-4">
                            {{-- Tipo de Actividad --}}
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Tipo</p>
                                <div class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-200 rounded-lg">
                                    @svg('heroicon-o-tag', 'w-4 h-4 mr-2 text-indigo-600')
                                    <span class="text-sm font-medium text-indigo-900">
                                        {{ $entrega->actividad->tipoActividad->nombre }}
                                    </span>
                                </div>
                            </div>

                            {{-- Semana --}}
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Semana</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $entrega->actividad->semana->nombre }}</p>
                            </div>

                            {{-- Fecha Límite --}}
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Fecha Límite</p>
                                <div class="flex items-center space-x-2">
                                    @svg('heroicon-o-clock', 'w-4 h-4 text-gray-400')
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $entrega->actividad->fecha_limite->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Modo de Entrega --}}
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Modo de Entrega</p>
                                <div class="flex items-center space-x-2">
                                    @if($entrega->actividad->tipoActividad->modo_entrega === 'drive')
                                        <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">Google Drive</span>
                                    @else
                                        @svg('heroicon-o-document-arrow-up', 'w-4 h-4 text-indigo-600')
                                        <span class="text-sm font-medium text-gray-900">Archivo PDF</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Línea de Tiempo --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 px-5 py-4 border-b border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">
                                Cronología
                            </h3>
                        </div>

                        <div class="p-5">
                            <div class="space-y-4">
                                {{-- Entrega Realizada --}}
                                <div class="relative pl-6 pb-4 border-l-2 border-indigo-200">
                                    <div class="absolute -left-2 top-0 w-4 h-4 bg-indigo-600 rounded-full border-2 border-white"></div>
                                    <p class="text-xs font-medium text-gray-500">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">Entrega realizada</p>
                                </div>

                                {{-- Calificación --}}
                                @if($entrega->estaCalificada())
                                    <div class="relative pl-6 pb-4 border-l-2 border-yellow-200">
                                        <div class="absolute -left-2 top-0 w-4 h-4 bg-yellow-500 rounded-full border-2 border-white"></div>
                                        <p class="text-xs font-medium text-gray-500">
                                            {{ $entrega->updated_at->format('d/m/Y H:i') }}
                                        </p>
                                        <p class="text-sm font-semibold text-gray-900 mt-1">Calificada</p>
                                        <p class="text-xs text-gray-600 mt-1">Nota: {{ $entrega->nota }}</p>
                                    </div>
                                @endif

                                {{-- Estado Actual --}}
                                <div class="relative pl-6">
                                    <div class="absolute -left-2 top-0 w-4 h-4 bg-gray-300 rounded-full border-2 border-white"></div>
                                    <p class="text-xs font-medium text-gray-500">Estado actual</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-1">{{ $estadoVisual['texto'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Botón de Eliminar --}}
                    @if(!$entrega->estaCalificada() && !$entrega->actividad->estaVencida())
                        <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                            <div class="p-5">
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Zona de Peligro</h4>
                                <p class="text-xs text-gray-600 mb-4">
                                    Una vez eliminada, esta acción no se puede deshacer.
                                </p>
                                <form action="{{ route('alumno.entregas.destroy', $entrega) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta entrega? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        @svg('heroicon-o-trash', 'w-4 h-4 mr-2')
                                        Eliminar Entrega
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
