{{-- resources/views/alumno/aula/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Aula {{ $aula->numero }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $aula->semestre->nombre ?? 'Semestre' }} • Prof. {{ $aula->profesor->user->nombre ?? '—' }}
                </p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Resumen de estadísticas --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @php
                    $todasActividades = $aula->semanas->flatMap->actividades;
                    $misEntregas = auth()->user()->alumno->entregas;

                    $actividadesActivas = $todasActividades->filter->estaActiva()->count();
                    $actividadesVencidas = $todasActividades->filter->estaVencida()->count();
                    $entregasPendientes = $todasActividades->count() - $misEntregas->count();
                    $entregasRealizadas = $misEntregas->count();
                @endphp

                {{-- Total de Actividades --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Total Actividades</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $todasActividades->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-clipboard-document-list', 'w-6 h-6 text-indigo-600')
                        </div>
                    </div>
                </div>

                {{-- Actividades Activas --}}
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Activas</p>
                            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $actividadesActivas }}</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-clock', 'w-6 h-6 text-emerald-600')
                        </div>
                    </div>
                </div>

                {{-- Entregas Realizadas --}}
                <div class="bg-white rounded-xl shadow-sm border border-blue-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Entregadas</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $entregasRealizadas }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-check-circle', 'w-6 h-6 text-blue-600')
                        </div>
                    </div>
                </div>

                {{-- Pendientes --}}
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Pendientes</p>
                            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $entregasPendientes }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-amber-600')
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lista de Semanas con Actividades --}}
            <div class="space-y-6">
                @forelse($aula->semanas->sortBy('numero') as $semana)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        {{-- Header de la Semana --}}
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ $semana->numero }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $semana->nombre }}</h3>
                                        <p class="text-xs text-gray-500">
                                            {{ $semana->actividades->count() }}
                                            {{ \Illuminate\Support\Str::plural('actividad', $semana->actividades->count()) }}
                                        </p>
                                    </div>
                                </div>

                                @php
                                    $actividadesSemana = $semana->actividades->count();
                                    $entregasSemana = $misEntregas->whereIn('actividad_id', $semana->actividades->pluck('id'))->count();
                                    $progresoSemana = $actividadesSemana > 0 ? round(($entregasSemana / $actividadesSemana) * 100) : 0;
                                @endphp

                                <div class="flex items-center space-x-3">
                                    <span class="text-sm font-medium text-gray-600">{{ $progresoSemana }}%</span>
                                    <div class="w-32 bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full"
                                             style="width: {{ $progresoSemana }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actividades de la Semana --}}
                        <div class="divide-y divide-gray-100">
                            @forelse($semana->actividades->sortBy('fecha_inicio') as $actividad)
                                @php
                                    $miEntrega = $misEntregas->where('actividad_id', $actividad->id)->first();
                                    $estado = $miEntrega ? $miEntrega->estado : 'sin_entregar';

                                    // Determinar el estado visual de la actividad
                                    if ($actividad->estaVencida() && !$miEntrega) {
                                        $estadoActividad = 'vencida';
                                        $estadoClase = 'border-red-200 bg-red-50';
                                        $badgeClase = 'bg-red-100 text-red-800 border-red-200';
                                        $badgeTexto = 'Vencida';
                                        $iconColor = 'text-red-600';
                                    } elseif ($actividad->estaActiva()) {
                                        $estadoActividad = 'activa';
                                        $estadoClase = 'border-emerald-200 bg-emerald-50/30';
                                        $badgeClase = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                        $badgeTexto = 'Activa';
                                        $iconColor = 'text-emerald-600';
                                    } elseif ($actividad->esFutura()) {
                                        $estadoActividad = 'futura';
                                        $estadoClase = 'border-gray-200 bg-gray-50';
                                        $badgeClase = 'bg-gray-100 text-gray-800 border-gray-200';
                                        $badgeTexto = 'Próxima';
                                        $iconColor = 'text-gray-600';
                                    } else {
                                        $estadoActividad = 'normal';
                                        $estadoClase = 'border-gray-200';
                                        $badgeClase = 'bg-gray-100 text-gray-800 border-gray-200';
                                        $badgeTexto = 'Cerrada';
                                        $iconColor = 'text-gray-600';
                                    }
                                @endphp

                                <div class="p-6 hover:bg-gray-50 transition-colors {{ $estadoClase }}">
                                    <div class="flex items-start justify-between">
                                        {{-- Información de la Actividad --}}
                                        <div class="flex-1">
                                            <div class="flex items-start space-x-4">
                                                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-lg flex items-center justify-center border-2 {{ $estadoClase }}">
                                                    @svg('heroicon-o-document-text', 'w-6 h-6 ' . $iconColor)
                                                </div>

                                                <div class="flex-1">
                                                    <div class="flex items-start justify-between mb-2">
                                                        <div>
                                                            <h4 class="text-base font-semibold text-gray-900">
                                                                {{ $actividad->titulo }}
                                                            </h4>
                                                            <p class="text-sm text-gray-600 mt-1">
                                                                {{ $actividad->descripcion }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    {{-- Badges y Meta información --}}
                                                    <div class="flex flex-wrap items-center gap-3 mt-3">
                                                        {{-- Tipo de Actividad --}}
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                            @svg('heroicon-o-tag', 'w-3.5 h-3.5 mr-1')
                                                            {{ $actividad->tipoActividad->nombre }}
                                                        </span>

                                                        {{-- Estado de la Actividad --}}
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $badgeClase }}">
                                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $estadoActividad === 'activa' ? 'bg-emerald-500 animate-pulse' : '' }} {{ $estadoActividad === 'vencida' ? 'bg-red-500' : '' }} {{ $estadoActividad === 'futura' ? 'bg-gray-400' : '' }}"></span>
                                                            {{ $badgeTexto }}
                                                        </span>

                                                        {{-- Fechas --}}
                                                        <span class="text-xs text-gray-500 flex items-center">
                                                            @svg('heroicon-o-calendar', 'w-3.5 h-3.5 mr-1')
                                                            Inicio: {{ $actividad->fecha_inicio->format('d/m/Y H:i') }}
                                                        </span>

                                                        <span class="text-xs text-gray-500 flex items-center">
                                                            @svg('heroicon-o-clock', 'w-3.5 h-3.5 mr-1')
                                                            Límite: {{ $actividad->fecha_limite->format('d/m/Y H:i') }}
                                                        </span>
                                                    </div>

                                                    {{-- Estado de Entrega del Alumno --}}
                                                    @if($miEntrega)
                                                        @php
                                                            $estadoVisual = $miEntrega->obtenerEstadoVisual();
                                                        @endphp
                                                        <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                                                            <div class="flex items-center justify-between">
                                                                <div class="flex items-center space-x-3">
                                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold {{ $estadoVisual['clase'] }}">
                                                                        @if($miEntrega->estado === 'entregado')
                                                                            @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                                                        @elseif($miEntrega->estado === 'observado')
                                                                            @svg('heroicon-o-eye', 'w-4 h-4 mr-1')
                                                                        @elseif($miEntrega->estado === 'rechazado')
                                                                            @svg('heroicon-o-x-circle', 'w-4 h-4 mr-1')
                                                                        @endif
                                                                        {{ $estadoVisual['texto'] }}
                                                                    </span>

                                                                    @if($miEntrega->fecha_entrega)
                                                                        <span class="text-xs text-gray-500">
                                                                            Entregado: {{ $miEntrega->fecha_entrega->format('d/m/Y H:i') }}
                                                                        </span>
                                                                    @endif

                                                                    @if($miEntrega->nota)
                                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-800 border border-yellow-200">
                                                                            @svg('heroicon-o-star', 'w-3.5 h-3.5 mr-1')
                                                                            Nota: {{ $miEntrega->nota }}
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                                <a href="{{ route('alumno.entregas.show', $miEntrega->id) }}"
                                                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                                                    Ver detalles
                                                                    @svg('heroicon-o-arrow-right', 'w-4 h-4 ml-1')
                                                                </a>
                                                            </div>

                                                            @if($miEntrega->observaciones)
                                                                <div class="mt-2 pt-2 border-t border-gray-200">
                                                                    <p class="text-xs text-gray-600">
                                                                        <span class="font-medium">Observaciones:</span> {{ $miEntrega->observaciones }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        {{-- No ha entregado --}}
                                                        <div class="mt-4 flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-200">
                                                            <div class="flex items-center space-x-2">
                                                                @svg('heroicon-o-exclamation-triangle', 'w-5 h-5 text-amber-600')
                                                                <span class="text-sm font-medium text-amber-800">
                                                                    Aún no has entregado esta actividad
                                                                </span>
                                                            </div>

                                                            @if(!$actividad->estaVencida())
                                                                <a href="{{ route('alumno.entregas.create', $actividad->id) }}"
                                                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                                    @svg('heroicon-o-arrow-up-tray', 'w-4 h-4 mr-2')
                                                                    Entregar ahora
                                                                </a>
                                                            @else
                                                                <span class="text-sm font-medium text-red-600">
                                                                    Plazo vencido
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-3">
                                        @svg('heroicon-o-inbox', 'w-6 h-6 text-gray-400')
                                    </div>
                                    <p class="text-sm text-gray-500">No hay actividades en esta semana</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            @svg('heroicon-o-calendar-days', 'w-8 h-8 text-gray-400')
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay semanas disponibles</h3>
                        <p class="text-sm text-gray-500">El profesor aún no ha creado semanas para este aula.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
