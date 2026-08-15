<x-app-layout :title="'Semana '.$semana->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Planificación académica" :title="'Semana '.$semana->numero.($semana->nombre ? ' · '.$semana->nombre : '')" :description="'Aula '.$semana->aula->numero.' · '.($semana->aula->semestre?->nombre ?? 'Sin semestre')" icon="heroicon-o-calendar-days">
            <x-slot name="actions">
                <a href="{{ route('profesor.aulas.show', $semana->aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Aula</a>
                <a href="{{ route('profesor.actividades.create', ['aula' => $semana->aula, 'semana' => $semana]) }}" class="ui-btn-primary">@svg('heroicon-o-plus', 'h-4 w-4') Nueva actividad</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Actividades" :value="$metricas['actividades']" description="Planificadas esta semana" icon="heroicon-o-clipboard-document-list" />
            <x-ui.stat-card label="Activas" :value="$metricas['activas']" description="Disponibles ahora" icon="heroicon-o-bolt" tone="success" />
            <x-ui.stat-card label="Entregas" :value="$metricas['entregas']" description="Trabajos recibidos" icon="heroicon-o-inbox-arrow-down" />
        </div>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading title="Actividades de la semana" :description="$metricas['actividades'].' actividades registradas.'" icon="heroicon-o-list-bullet">
                    <x-slot name="actions"><a href="{{ route('profesor.semanas.edit', $semana) }}" class="ui-btn-secondary">@svg('heroicon-o-pencil', 'h-4 w-4') Editar semana</a></x-slot>
                </x-ui.section-heading>
            </div>

            @if($semana->actividades->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="La semana aún no tiene actividades" description="Crea la primera actividad para indicar objetivos, instrucciones y plazo." icon="heroicon-o-clipboard-document-list"><x-slot name="actions"><a href="{{ route('profesor.actividades.create', ['aula' => $semana->aula, 'semana' => $semana]) }}" class="ui-btn-primary">Crear actividad</a></x-slot></x-ui.empty-state></div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach($semana->actividades as $actividad)
                        @php($progreso = $progresoActividades[$actividad->id])
                        <article class="p-5 sm:p-6">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-bold text-gray-950">{{ $actividad->titulo }}</h3>
                                        <span class="ui-badge-info">{{ $actividad->tipoActividad->nombre }}</span>
                                        @if($actividad->estaActiva())<span class="ui-badge-success">Activa</span>@elseif($actividad->estaVencida())<span class="ui-badge-danger">Vencida</span>@else<span class="ui-badge-warning">Próxima</span>@endif
                                    </div>
                                    @if($actividad->descripcion)<p class="mt-2 line-clamp-2 text-sm leading-6 text-gray-600">{{ $actividad->descripcion }}</p>@endif
                                    <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-3">
                                        <div><dt class="text-gray-500">Plazo</dt><dd class="mt-1 font-semibold text-gray-800">{{ $actividad->fecha_limite->format('d/m/Y H:i') }}</dd></div>
                                        <div><dt class="text-gray-500">Entregas</dt><dd class="mt-1 font-semibold text-gray-800">{{ $progreso['entregadas'] }} de {{ $progreso['total'] }}</dd></div>
                                        <div><dt class="text-gray-500">Avance</dt><dd class="mt-1 font-semibold text-gray-800">{{ $progreso['porcentaje'] }}%</dd></div>
                                    </dl>
                                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200" role="progressbar" aria-label="Progreso de entregas" aria-valuenow="{{ $progreso['porcentaje'] }}" aria-valuemin="0" aria-valuemax="100"><div class="h-full rounded-full bg-blue-800" style="width: {{ $progreso['porcentaje'] }}%"></div></div>
                                </div>
                                <a href="{{ route('profesor.actividades.show', $actividad) }}" class="ui-btn-secondary">Revisar entregas @svg('heroicon-o-arrow-right', 'h-4 w-4')</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="rounded-xl border border-red-200 bg-red-50 p-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div><h2 class="font-bold text-red-900">Eliminar semana</h2><p class="mt-1 text-sm text-red-800">También eliminará sus actividades y entregas asociadas.</p></div>
                <form action="{{ route('profesor.semanas.destroy', $semana) }}" method="POST" onsubmit="return confirm('¿Eliminar esta semana y todas sus actividades? Esta acción no se puede deshacer.');">@csrf @method('DELETE')<button type="submit" class="ui-btn-danger">@svg('heroicon-o-trash', 'h-4 w-4') Eliminar</button></form>
            </div>
        </section>
    </div>
</x-app-layout>
