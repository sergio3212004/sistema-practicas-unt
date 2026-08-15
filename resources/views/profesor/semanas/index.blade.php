<x-app-layout title="Semanas académicas">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Docencia" title="Semanas académicas" description="Consulta la planificación semanal de todas tus aulas asignadas." icon="heroicon-o-calendar-days" />
    </x-slot>

    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading title="Planificación por aula" :description="$semanas->count().' semanas registradas.'" icon="heroicon-o-rectangle-stack" />
            </div>

            @if($semanas->isEmpty())
                <div class="p-5 sm:p-6">
                    <x-ui.empty-state title="Todavía no hay semanas" description="Abre una de tus aulas y crea su primera semana para organizar las actividades." icon="heroicon-o-calendar" />
                </div>
            @else
                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6 xl:grid-cols-3">
                    @foreach($semanas->groupBy('aula_id') as $semanasAula)
                        @php($aula = $semanasAula->first()->aula)
                        <article class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-gray-950">Aula {{ $aula->numero }}</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $aula->semestre?->nombre ?? 'Sin semestre' }}</p>
                                </div>
                                <span class="ui-badge-info">{{ $semanasAula->count() }} semanas</span>
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($semanasAula as $semana)
                                    <a href="{{ route('profesor.semanas.show', $semana) }}" class="ui-btn-secondary px-3 py-1.5">Semana {{ $semana->numero }}</a>
                                @endforeach
                            </div>
                            <a href="{{ route('profesor.aulas.show', $aula) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-blue-800 hover:text-blue-950">Gestionar aula @svg('heroicon-o-arrow-right', 'h-4 w-4')</a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
