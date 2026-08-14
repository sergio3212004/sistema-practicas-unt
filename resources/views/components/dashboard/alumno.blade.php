@props(['alumno', 'metricas'])

<section class="rounded-2xl bg-blue-950 p-6 text-white shadow-panel sm:p-7">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-gold-400">Espacio del estudiante</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight">Hola, {{ auth()->user()->nombre }}</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100">Revisa tu aula, controla tus entregas y mantén al día la documentación de tus prácticas.</p>
        </div>
        <span class="ui-badge border-white/15 bg-white/10 text-white">
            <span class="h-2 w-2 rounded-full {{ $alumno->aula ? 'bg-green-400' : 'bg-gold-400' }}"></span>
            {{ $alumno->aula ? 'Aula asignada' : 'Asignación pendiente' }}
        </span>
    </div>
</section>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat-card label="Total de entregas" :value="$metricas['total']" description="Actividades registradas" icon="heroicon-o-document-text" />
    <x-ui.stat-card label="Pendientes" :value="$metricas['pendientes']" description="Requieren tu atención" icon="heroicon-o-clock" tone="warning" />
    <x-ui.stat-card label="Progreso" :value="$metricas['progreso'].'%'" description="Entregas completadas" icon="heroicon-o-chart-bar" tone="success" />
    <x-ui.stat-card label="Promedio" :value="$metricas['promedio'] ?? '—'" description="Según notas disponibles" icon="heroicon-o-star" tone="neutral" />
</div>

@if($alumno->aula)
    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <a href="{{ route('alumno.aula.index', $alumno->aula) }}" class="ui-card group overflow-hidden transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-raised">
            <div class="border-b border-blue-900/20 bg-blue-900 px-5 py-5 text-white sm:px-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-gold-400">Aula asignada</p>
                        <h3 class="mt-1 text-2xl font-bold">Aula {{ $alumno->aula->numero }}</h3>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10">@svg('heroicon-o-academic-cap', 'h-6 w-6')</span>
                </div>
            </div>
            <div class="p-5 sm:p-6">
                <dl class="grid gap-5 sm:grid-cols-2">
                    <div class="flex items-start gap-3">
                        <span class="ui-icon-box">@svg('heroicon-o-calendar-days', 'h-5 w-5')</span>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Semestre</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $alumno->aula->semestre->nombre ?? 'No registrado' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="ui-icon-box">@svg('heroicon-o-user', 'h-5 w-5')</span>
                        <div>
                            <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Docente</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $alumno->aula->profesor->user->nombre ?? 'No asignado' }}</dd>
                        </div>
                    </div>
                </dl>
                <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                    <span class="ui-badge-success"><span class="h-2 w-2 rounded-full bg-green-500"></span> Activa</span>
                    <span class="flex items-center gap-1 text-sm font-bold text-blue-700 group-hover:text-blue-900">
                        Ver aula @svg('heroicon-o-arrow-right', 'h-4 w-4 transition group-hover:translate-x-0.5')
                    </span>
                </div>
            </div>
        </a>

        <section class="ui-card p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-gray-950">Estado de entregas</p>
                    <p class="mt-1 text-xs text-gray-500">Distribución de tus actividades</p>
                </div>
                <span class="ui-icon-box">@svg('heroicon-o-presentation-chart-line', 'h-5 w-5')</span>
            </div>

            <div class="mt-6 space-y-3">
                @foreach([
                    ['label' => 'Pendientes', 'value' => $metricas['pendientes'], 'dot' => 'bg-gold-500'],
                    ['label' => 'Entregadas', 'value' => $metricas['entregadas'], 'dot' => 'bg-blue-600'],
                    ['label' => 'Revisadas', 'value' => $metricas['revisadas'], 'dot' => 'bg-green-600'],
                ] as $row)
                    <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                        <span class="flex items-center gap-2 text-sm font-medium text-gray-700"><span class="h-2.5 w-2.5 rounded-full {{ $row['dot'] }}"></span>{{ $row['label'] }}</span>
                        <span class="text-sm font-bold text-gray-950">{{ $row['value'] }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <div class="mb-2 flex items-center justify-between text-xs font-semibold">
                    <span class="text-gray-600">Progreso general</span>
                    <span class="text-blue-800">{{ $metricas['progreso'] }}%</span>
                </div>
                <div class="h-2.5 overflow-hidden rounded-full bg-gray-200" role="progressbar" aria-valuenow="{{ $metricas['progreso'] }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de entregas">
                    <div class="h-full rounded-full bg-blue-700" style="width: {{ $metricas['progreso'] }}%"></div>
                </div>
            </div>
        </section>
    </div>
@else
    <x-ui.empty-state
        title="Tu aula aún no ha sido asignada"
        description="La coordinación realiza las asignaciones al inicio de cada semestre. Mientras tanto, puedes revisar oportunidades y preparar tu ficha de registro."
        icon="heroicon-o-academic-cap"
    >
        <x-slot name="actions">
            <a href="{{ route('alumno.practicas.index') }}" class="ui-btn-primary">Explorar prácticas</a>
            <a href="{{ route('alumno.ficha.index') }}" class="ui-btn-secondary">Revisar ficha</a>
        </x-slot>
    </x-ui.empty-state>
@endif

<section class="ui-card">
    <div class="ui-card-header">
        <div>
            <h3 class="font-bold text-gray-950">Acciones principales</h3>
            <p class="mt-1 text-sm text-gray-600">Continúa con tu proceso de prácticas.</p>
        </div>
    </div>
    <div class="grid divide-y divide-gray-100 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
        @foreach([
            ['route' => 'alumno.practicas.index', 'icon' => 'heroicon-o-briefcase', 'label' => 'Prácticas disponibles', 'description' => 'Consulta ofertas y postula'],
            ['route' => 'alumno.ficha.index', 'icon' => 'heroicon-o-document-text', 'label' => 'Ficha de registro', 'description' => 'Completa tu documentación'],
            ['route' => 'alumno.informe-final.index', 'icon' => 'heroicon-o-document-arrow-up', 'label' => 'Informe final', 'description' => 'Revisa el estado del informe'],
        ] as $action)
            <a href="{{ route($action['route']) }}" class="group flex items-center gap-4 p-5 transition hover:bg-blue-50/60 sm:p-6">
                <span class="ui-icon-box">@svg($action['icon'], 'h-5 w-5')</span>
                <span>
                    <span class="block text-sm font-bold text-gray-900 group-hover:text-blue-800">{{ $action['label'] }}</span>
                    <span class="mt-1 block text-xs text-gray-500">{{ $action['description'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>
