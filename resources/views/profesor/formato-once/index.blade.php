<x-app-layout title="Formato 11">
    <x-slot name="header"><x-ui.page-header eyebrow="Documentación académica" title="Formato 11" description="Gestiona la conformidad de prácticas por aula y conserva un historial ordenado." icon="heroicon-o-document-text" /></x-slot>
    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Aulas asignadas" :description="$aulas->count().' aulas disponibles.'" icon="heroicon-o-academic-cap" /></div>
            @if($aulas->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="No tienes aulas asignadas" description="Los Formatos 11 estarán disponibles cuando el administrador te asigne un aula." icon="heroicon-o-academic-cap" /></div>
            @else
                <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6 xl:grid-cols-3">
                    @foreach($aulas as $aula)
                        <article class="rounded-xl border border-gray-200 bg-gray-50 p-5">
                            <div class="flex items-start justify-between gap-3"><div><h2 class="font-bold text-gray-950">Aula {{ $aula->numero }}</h2><p class="mt-1 text-sm text-gray-600">{{ $aula->semestre?->nombre ?? 'Sin semestre' }}</p></div><span class="ui-badge-info">{{ $aula->formatosOnce->count() }} formatos</span></div>
                            <dl class="mt-5 grid grid-cols-2 gap-3 text-sm"><div><dt class="text-gray-500">Estudiantes</dt><dd class="mt-1 font-bold text-gray-900">{{ $aula->alumnos->count() }}</dd></div><div><dt class="text-gray-500">Último registro</dt><dd class="mt-1 font-bold text-gray-900">{{ $aula->formatosOnce->sortByDesc('created_at')->first()?->created_at?->format('d/m/Y') ?? 'Ninguno' }}</dd></div></dl>
                            <div class="mt-5 flex flex-wrap gap-2"><a href="{{ route('profesor.formato-once.list', $aula) }}" class="ui-btn-secondary">Ver historial</a>@if($aula->alumnos->isNotEmpty())<a href="{{ route('profesor.formato-once.create', $aula) }}" class="ui-btn-primary">Nuevo formato</a>@endif</div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
