@props(['data'])

<article class="p-6 transition-colors hover:bg-gray-50 {{ $data['estado']['containerClass'] }}">
    <div class="flex items-start gap-4">
        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg border-2 bg-white {{ $data['estado']['containerClass'] }}">
            @svg('heroicon-o-document-text', 'h-6 w-6 '.$data['estado']['iconClass'])
        </span>

        <div class="min-w-0 flex-1">
            <h4 class="text-base font-semibold text-gray-900">{{ $data['actividad']->titulo }}</h4>
            <p class="mt-1 text-sm text-gray-600">{{ $data['actividad']->descripcion }}</p>

            <div class="mt-3 flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-lg border border-indigo-200 bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">
                    @svg('heroicon-o-tag', 'mr-1 h-3.5 w-3.5')
                    {{ $data['actividad']->tipoActividad->nombre }}
                </span>
                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-medium {{ $data['estado']['badgeClass'] }}">
                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full {{ $data['estado']['dotClass'] }}"></span>
                    {{ $data['estado']['badgeText'] }}
                </span>
                <span class="flex items-center text-xs text-gray-500">
                    @svg('heroicon-o-calendar', 'mr-1 h-3.5 w-3.5')
                    Inicio: {{ $data['actividad']->fecha_inicio->format('d/m/Y H:i') }}
                </span>
                <span class="flex items-center text-xs text-gray-500">
                    @svg('heroicon-o-clock', 'mr-1 h-3.5 w-3.5')
                    Límite: {{ $data['actividad']->fecha_limite->format('d/m/Y H:i') }}
                </span>
            </div>

            @if($data['entrega'])
                <div class="mt-4 rounded-lg border border-gray-200 bg-white p-3">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold {{ $data['estadoEntrega']['class'] }}">
                                @if($data['entrega']->estado === 'entregado')
                                    @svg('heroicon-o-check-circle', 'mr-1 h-4 w-4')
                                @elseif($data['entrega']->estado === 'observado')
                                    @svg('heroicon-o-eye', 'mr-1 h-4 w-4')
                                @elseif($data['entrega']->estado === 'rechazado')
                                    @svg('heroicon-o-x-circle', 'mr-1 h-4 w-4')
                                @endif
                                {{ $data['estadoEntrega']['text'] }}
                            </span>

                            @if($data['entrega']->fecha_entrega)
                                <span class="text-xs text-gray-500">
                                    Entregado: {{ $data['entrega']->fecha_entrega->format('d/m/Y H:i') }}
                                </span>
                            @endif

                            @if($data['entrega']->nota)
                                <span class="inline-flex items-center rounded-lg border border-yellow-200 bg-yellow-50 px-2.5 py-1 text-xs font-bold text-yellow-800">
                                    @svg('heroicon-o-star', 'mr-1 h-3.5 w-3.5')
                                    Nota: {{ $data['entrega']->nota }}
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('alumno.entregas.show', $data['entrega']) }}" class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Ver detalles
                            @svg('heroicon-o-arrow-right', 'ml-1 h-4 w-4')
                        </a>
                    </div>

                    @if($data['entrega']->observaciones)
                        <p class="mt-2 border-t border-gray-200 pt-2 text-xs text-gray-600">
                            <span class="font-medium">Observaciones:</span> {{ $data['entrega']->observaciones }}
                        </p>
                    @endif
                </div>
            @else
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-amber-200 bg-amber-50 p-3">
                    <span class="flex items-center gap-2 text-sm font-medium text-amber-800">
                        @svg('heroicon-o-exclamation-triangle', 'h-5 w-5 text-amber-600')
                        Aún no has entregado esta actividad
                    </span>

                    @if($data['puedeEntregar'])
                        <a href="{{ route('alumno.entregas.create', $data['actividad']) }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-indigo-700">
                            @svg('heroicon-o-arrow-up-tray', 'mr-2 h-4 w-4')
                            Entregar ahora
                        </a>
                    @else
                        <span class="text-sm font-medium text-red-600">Plazo vencido</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</article>
