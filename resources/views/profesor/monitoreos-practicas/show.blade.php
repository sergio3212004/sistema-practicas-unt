<x-app-layout :title="'Monitoreo · Semana '.$monitoreo->semana->numero">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Seguimiento de prácticas"
            title="Monitoreo · Semana {{ $monitoreo->semana->numero }}"
            description="{{ $monitoreo->alumno->user->nombre }} · {{ $monitoreo->alumno->codigo_matricula }}"
            icon="heroicon-o-clipboard-document-check"
        >
            <x-slot name="actions">
                <a href="{{ route('profesor.monitoreos-practicas.index', $monitoreo->alumno) }}" class="ui-btn-secondary">
                    @svg('heroicon-o-arrow-left', 'h-4 w-4')
                    Volver al seguimiento
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <section class="grid gap-4 sm:grid-cols-3" aria-label="Resumen del monitoreo">
            <x-ui.stat-card
                label="Actividades monitoreadas"
                :value="$metricas['actividades']"
                description="Total de la semana"
                icon="heroicon-o-clipboard-document-list"
            />
            <x-ui.stat-card
                label="Al día"
                :value="$metricas['alDia']"
                description="Avance conforme"
                icon="heroicon-o-check-circle"
                tone="success"
            />
            <x-ui.stat-card
                label="Con retraso"
                :value="$metricas['conRetraso']"
                description="Requieren seguimiento"
                icon="heroicon-o-exclamation-triangle"
                tone="warning"
            />
        </section>

        <div class="grid gap-6 lg:grid-cols-[0.75fr_1.25fr]">
            <aside class="ui-card self-start">
                <div class="ui-card-header">
                    <div>
                        <h2 class="font-bold text-gray-950">Contexto de la práctica</h2>
                        <p class="mt-1 text-sm text-gray-600">Datos asociados al monitoreo.</p>
                    </div>
                </div>
                <dl class="space-y-4 p-5 sm:p-6">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Estudiante</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $monitoreo->alumno->user->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Código</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $monitoreo->alumno->codigo_matricula }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Empresa</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $monitoreo->cronograma->fichaRegistro->razon_social ?? 'No registrada' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Área</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $monitoreo->cronograma->fichaRegistro->area_practicas ?? 'No registrada' }}</dd>
                    </div>
                </dl>
            </aside>

            <section class="ui-card">
                <div class="ui-card-header">
                    <div>
                        <h2 class="font-bold text-gray-950">Actividades del cronograma</h2>
                        <p class="mt-1 text-sm text-gray-600">Estado registrado durante esta semana.</p>
                    </div>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($monitoreo->monitoreosPracticasActividades as $actividad)
                        <article class="flex items-start gap-4 p-5 sm:p-6">
                            <span @class([
                                'flex h-10 w-10 shrink-0 items-center justify-center rounded-xl',
                                'bg-green-100 text-green-700' => $actividad->al_dia,
                                'bg-red-100 text-red-700' => ! $actividad->al_dia,
                            ])>
                                @if($actividad->al_dia)
                                    @svg('heroicon-o-check', 'h-5 w-5')
                                @else
                                    @svg('heroicon-o-x-mark', 'h-5 w-5')
                                @endif
                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm font-bold text-gray-900">
                                    {{ $actividad->cronogramaActividad->actividad ?? 'Actividad no especificada' }}
                                </h3>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $actividad->al_dia ? 'Avance registrado dentro de lo previsto.' : 'La actividad presenta retraso y requiere seguimiento.' }}
                                </p>
                            </div>
                            <span class="{{ $actividad->al_dia ? 'ui-badge-success' : 'ui-badge-danger' }}">
                                {{ $actividad->al_dia ? 'Al día' : 'Con retraso' }}
                            </span>
                        </article>
                    @empty
                        <x-ui.empty-state
                            title="Sin actividades registradas"
                            description="Este monitoreo todavía no contiene detalles de actividades."
                            icon="heroicon-o-clipboard-document-list"
                        />
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
