<x-app-layout :title="'Monitoreo · '.$alumno->user->nombre">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Seguimiento de prácticas" title="Monitoreo semanal" :description="$alumno->user->nombre.' · '.$alumno->codigo_matricula" icon="heroicon-o-chart-bar-square">
            <x-slot name="actions"><a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula</a></x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Semanas planificadas" :value="$progresoMonitoreo['totalSemanas']" description="En el aula" icon="heroicon-o-calendar-days" />
            <x-ui.stat-card label="Monitoreos registrados" :value="$progresoMonitoreo['semanasRegistradas']" description="Con seguimiento" icon="heroicon-o-clipboard-document-check" tone="success" />
            <x-ui.stat-card label="Avance" :value="$progresoMonitoreo['porcentaje'].'%'" description="Cobertura del monitoreo" icon="heroicon-o-chart-pie" />
        </div>

        <div class="grid gap-6 lg:grid-cols-[20rem_minmax(0,1fr)]">
            <aside class="space-y-6">
                <section class="ui-card"><div class="ui-card-header"><x-ui.section-heading title="Practicante" icon="heroicon-o-user" /></div><dl class="ui-card-body space-y-4 text-sm"><div><dt class="text-gray-500">Nombre</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->user->nombre }}</dd></div><div><dt class="text-gray-500">Código</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->codigo_matricula }}</dd></div><div><dt class="text-gray-500">Correo</dt><dd class="mt-1 break-all font-semibold text-gray-900">{{ $alumno->user->email }}</dd></div></dl></section>
                <section class="ui-card"><div class="ui-card-header"><x-ui.section-heading title="Centro de prácticas" icon="heroicon-o-building-office-2" /></div><dl class="ui-card-body space-y-4 text-sm"><div><dt class="text-gray-500">Empresa</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->fichaRegistro->razon_social }}</dd></div><div><dt class="text-gray-500">RUC</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->fichaRegistro->ruc }}</dd></div><div><dt class="text-gray-500">Área</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->fichaRegistro->area_practicas }}</dd></div><div><dt class="text-gray-500">Periodo</dt><dd class="mt-1 font-semibold text-gray-900">{{ $alumno->fichaRegistro->fecha_inicio->format('d/m/Y') }}–{{ $alumno->fichaRegistro->fecha_termino->format('d/m/Y') }}</dd></div></dl></section>
            </aside>

            <section class="ui-card overflow-hidden">
                <div class="ui-card-header"><x-ui.section-heading title="Seguimiento por semana" description="Compara las actividades previstas con el avance reportado." icon="heroicon-o-list-bullet" /></div>
                @if($semanas->isEmpty())
                    <div class="p-5 sm:p-6"><x-ui.empty-state title="No hay semanas configuradas" description="La planificación del aula todavía no contiene semanas para monitorear." icon="heroicon-o-calendar-days" /></div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($semanas as $semana)
                            @php($resumen = $resumenSemanas[$semana->id])
                            <article class="p-5 sm:p-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2"><h3 class="font-bold text-gray-950">Semana {{ $semana->numero }}{{ $semana->nombre ? ' · '.$semana->nombre : '' }}</h3>@if($resumen['registrado'])<span class="ui-badge-success">Registrado</span>@else<span class="ui-badge-warning">Pendiente</span>@endif</div>
                                        @if($resumen['registrado'])
                                            <dl class="mt-4 grid grid-cols-3 gap-3 text-sm"><div><dt class="text-gray-500">Actividades</dt><dd class="mt-1 text-lg font-bold text-gray-900">{{ $resumen['totalActividades'] }}</dd></div><div><dt class="text-gray-500">Al día</dt><dd class="mt-1 text-lg font-bold text-green-700">{{ $resumen['actividadesAlDia'] }}</dd></div><div><dt class="text-gray-500">Con retraso</dt><dd class="mt-1 text-lg font-bold text-red-700">{{ $resumen['actividadesConRetraso'] }}</dd></div></dl>
                                        @else<p class="mt-3 text-sm text-gray-600">El estudiante todavía no ha registrado el monitoreo de esta semana.</p>@endif
                                    </div>
                                    @if($resumen['registrado'])<a href="{{ route('profesor.monitoreos-practicas.show', $resumen['monitoreo']) }}" class="ui-btn-secondary">Ver detalle @svg('heroicon-o-arrow-right', 'h-4 w-4')</a>@endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
