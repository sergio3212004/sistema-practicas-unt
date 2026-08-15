<x-app-layout title="Informes finales">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Seguimiento académico" title="Informes finales" description="Consulta y descarga únicamente los informes entregados por estudiantes de tus aulas." icon="heroicon-o-document-check" />
    </x-slot>

    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Buscar informes" description="Filtra por identidad del estudiante o periodo académico." icon="heroicon-o-funnel" /></div>
            <form method="GET" action="{{ route('profesor.informes-finales.index') }}" class="grid gap-4 p-5 sm:grid-cols-[minmax(0,1fr)_minmax(14rem,0.6fr)_auto] sm:items-end sm:p-6" role="search">
                <div><label for="nombre" class="ui-label">Estudiante</label><input id="nombre" type="search" name="nombre" value="{{ request('nombre') }}" class="ui-field" placeholder="Nombre, apellido o código"></div>
                <div><label for="semestre_id" class="ui-label">Semestre</label><select id="semestre_id" name="semestre_id" class="ui-field"><option value="">Todos</option>@foreach($semestres as $semestre)<option value="{{ $semestre->id }}" @selected((string) request('semestre_id') === (string) $semestre->id)>{{ $semestre->nombre }}</option>@endforeach</select></div>
                <div class="flex gap-2"><button type="submit" class="ui-btn-primary flex-1">@svg('heroicon-o-magnifying-glass', 'h-4 w-4') Buscar</button>@if(request()->filled('nombre') || request()->filled('semestre_id'))<a href="{{ route('profesor.informes-finales.index') }}" class="ui-btn-secondary px-3" aria-label="Limpiar filtros">@svg('heroicon-o-x-mark', 'h-5 w-5')</a>@endif</div>
            </form>
        </section>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Documentos recibidos" :description="$informes->total().' informes coinciden con la consulta.'" icon="heroicon-o-folder-open"><x-slot name="actions"><span class="ui-badge-info">{{ $informes->total() }} resultados</span></x-slot></x-ui.section-heading></div>
            @if($informes->isEmpty())
                <div class="p-5 sm:p-6">
                    <x-ui.empty-state
                        title="No se encontraron informes"
                        :description="request()->filled('nombre') || request()->filled('semestre_id') ? 'Prueba con otros criterios o limpia los filtros.' : 'Tus estudiantes aún no han entregado informes finales.'"
                        icon="heroicon-o-document-magnifying-glass"
                    >
                        @if(request()->filled('nombre') || request()->filled('semestre_id'))
                            <x-slot name="actions">
                                <a href="{{ route('profesor.informes-finales.index') }}" class="ui-btn-primary">Limpiar filtros</a>
                            </x-slot>
                        @endif
                    </x-ui.empty-state>
                </div>
            @else
                <div class="overflow-x-auto"><table class="ui-table"><caption class="sr-only">Informes finales de estudiantes</caption><thead><tr><th scope="col">Estudiante</th><th scope="col">Semestre</th><th scope="col">Entrega</th><th scope="col">Archivo</th><th scope="col" class="text-right">Acción</th></tr></thead><tbody>
                    @foreach($informes as $informe)<tr><td><p class="font-semibold text-gray-900">{{ $informe->alumno->nombre_completo }}</p><p class="mt-0.5 text-xs text-gray-500">{{ $informe->alumno->codigo_matricula }}</p></td><td><span class="ui-badge-info">{{ $informe->semestre?->nombre ?? 'Sin semestre' }}</span></td><td><time datetime="{{ $informe->fecha_subida->toIso8601String() }}" class="font-medium text-gray-700">{{ $informe->fecha_subida->format('d/m/Y H:i') }}</time></td><td><p class="max-w-56 truncate font-medium text-gray-700" title="{{ $informe->nombre_original }}">{{ $informe->nombre_original }}</p><p class="mt-0.5 text-xs text-gray-500">{{ $informe->tamanio_formateado }}</p></td><td><div class="flex justify-end"><a href="{{ route('profesor.informes-finales.download', $informe) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-down-tray', 'h-4 w-4') Descargar</a></div></td></tr>@endforeach
                </tbody></table></div>
                <div class="border-t border-gray-200 bg-gray-50 px-5 py-4">{{ $informes->onEachSide(1)->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
