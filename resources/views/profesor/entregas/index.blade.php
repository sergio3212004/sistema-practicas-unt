<x-app-layout title="Entregas por semana">
    <x-slot name="header"><x-ui.page-header eyebrow="Evaluación académica" title="Entregas por semana" description="Consulta el avance de los trabajos programados en tus aulas." icon="heroicon-o-inbox-stack" /></x-slot>
    <div class="ui-page">
        <section class="ui-card overflow-hidden"><div class="ui-card-header"><x-ui.section-heading title="Actividades con entrega" :description="$entregas->count().' registros disponibles.'" icon="heroicon-o-clipboard-document-list" /></div>
            @if($entregas->isEmpty())<div class="p-5 sm:p-6"><x-ui.empty-state title="No hay entregas programadas" description="Las actividades con entrega aparecerán en este espacio." icon="heroicon-o-inbox" /></div>@else<div class="divide-y divide-gray-200">@foreach($entregas as $entrega)@php(preg_match('/Semana (\d+)/', $entrega->titulo, $match))<a href="{{ route('profesor.entregas.show', $entrega) }}" class="block p-5 hover:bg-blue-50/40 sm:p-6"><div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-bold text-gray-950">Semana {{ $match[1] ?? '—' }} · {{ $entrega->titulo }}</h2><p class="mt-1 text-sm text-gray-600">Límite {{ $entrega->fecha_fin->format('d/m/Y') }}</p></div><span class="ui-badge-info">{{ $entrega->entregas_alumnos->count() }} / {{ $entrega->aula->alumnos->count() }} entregados</span></div></a>@endforeach</div>@endif
        </section>
    </div>
</x-app-layout>
