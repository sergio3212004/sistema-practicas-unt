@props(['data'])

<section class="rounded-2xl bg-blue-950 p-6 text-white shadow-panel sm:p-7">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-gold-400">Supervisión docente</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight">Bienvenido, {{ $data->profesor->user->nombre }}</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100">Supervisa el progreso de tus estudiantes y gestiona la documentación de cada aula.</p>
        </div>
        <div class="rounded-xl border border-white/15 bg-white/10 px-4 py-3">
            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-200">Código docente</p>
            <p class="mt-0.5 text-sm font-bold text-white">{{ $data->profesor->codigo_profesor }}</p>
        </div>
    </div>
</section>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat-card label="Aulas asignadas" :value="$data->aulas->count()" description="Grupos bajo supervisión" icon="heroicon-o-academic-cap" />
    <x-ui.stat-card label="Estudiantes" :value="$data->totalEstudiantes" description="En todas tus aulas" icon="heroicon-o-users" />
    <x-ui.stat-card label="Actividades activas" :value="$data->actividadesActivas" description="Dentro del plazo" icon="heroicon-o-clipboard-document-check" tone="warning" />
    <x-ui.stat-card label="Entregas recibidas" :value="$data->totalEntregas" description="Trabajos registrados" icon="heroicon-o-inbox-arrow-down" tone="success" />
</div>

<section>
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="ui-eyebrow">Periodo {{ $data->semestreActivo?->nombre ?? 'sin activar' }}</p>
            <h3 class="mt-1 text-xl font-bold text-gray-950">Mis aulas</h3>
            <p class="mt-1 text-sm text-gray-600">Selecciona un grupo para revisar estudiantes, semanas y actividades.</p>
        </div>
    </div>

    @if($data->aulas->isNotEmpty())
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($data->aulas as $resumen)
                <a href="{{ route('profesor.aulas.show', $resumen['aula']) }}" class="ui-card group overflow-hidden transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-raised">
                    <div class="border-b border-gray-100 bg-blue-900 px-5 py-4 text-white">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-gold-400">{{ $resumen['aula']->semestre->nombre ?? 'Semestre' }}</p>
                                <h4 class="mt-1 text-xl font-bold">Aula {{ $resumen['aula']->numero }}</h4>
                            </div>
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">@svg('heroicon-o-academic-cap', 'h-5 w-5')</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <dl class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Estudiantes</dt>
                                <dd class="mt-1 text-lg font-bold text-gray-950">{{ $resumen['estudiantes'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Semanas</dt>
                                <dd class="mt-1 text-lg font-bold text-gray-950">{{ $resumen['semanas'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Actividades</dt>
                                <dd class="mt-1 text-lg font-bold text-gray-950">{{ $resumen['actividades'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500">Entregas</dt>
                                <dd class="mt-1 text-lg font-bold text-gray-950">{{ $resumen['entregas'] }}</dd>
                            </div>
                        </dl>
                        <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">
                            <span class="ui-badge-success"><span class="h-2 w-2 rounded-full bg-green-500"></span> Activa</span>
                            <span class="flex items-center gap-1 text-sm font-bold text-blue-700">Abrir @svg('heroicon-o-arrow-right', 'h-4 w-4 transition group-hover:translate-x-0.5')</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <x-ui.empty-state
            title="No tienes aulas asignadas"
            description="Cuando administración asigne un grupo, aparecerá aquí con sus estudiantes, actividades y entregas."
            icon="heroicon-o-academic-cap"
        />
    @endif
</section>
