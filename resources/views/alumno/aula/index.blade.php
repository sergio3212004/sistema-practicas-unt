<x-app-layout :title="'Aula '.$pagina->aula->numero">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Espacio del estudiante"
            title="Aula {{ $pagina->aula->numero }}"
            description="{{ $pagina->aula->semestre->nombre ?? 'Semestre' }} · Prof. {{ $pagina->aula->profesor->user->nombre ?? 'Sin asignar' }}"
            icon="heroicon-o-academic-cap"
        >
            <x-slot name="actions">
                <a href="{{ route('dashboard') }}" class="ui-btn-secondary">
                    @svg('heroicon-o-arrow-left', 'h-4 w-4')
                    Volver
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Resumen del aula">
            <x-ui.stat-card
                label="Total de actividades"
                :value="$pagina->metricas['actividades']"
                description="Actividades registradas"
                icon="heroicon-o-clipboard-document-list"
            />
            <x-ui.stat-card
                label="Activas"
                :value="$pagina->metricas['activas']"
                description="Dentro del plazo"
                icon="heroicon-o-clock"
                tone="success"
            />
            <x-ui.stat-card
                label="Entregadas"
                :value="$pagina->metricas['entregadas']"
                description="Trabajos enviados"
                icon="heroicon-o-check-circle"
            />
            <x-ui.stat-card
                label="Pendientes"
                :value="$pagina->metricas['pendientes']"
                description="Requieren atención"
                icon="heroicon-o-exclamation-triangle"
                tone="warning"
            />
        </section>

        <section class="space-y-6" aria-label="Semanas y actividades">
            @forelse($pagina->semanas as $semana)
                <x-alumno.aula.semana :data="$semana" />
            @empty
                <x-ui.empty-state
                    title="No hay semanas disponibles"
                    description="El profesor aún no ha creado semanas para esta aula."
                    icon="heroicon-o-calendar-days"
                />
            @endforelse
        </section>
    </div>
</x-app-layout>
