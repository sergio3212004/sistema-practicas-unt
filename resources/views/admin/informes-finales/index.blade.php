<x-app-layout title="Informes finales">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Seguimiento académico"
            title="Informes finales"
            description="Localiza, descarga y administra los documentos finales entregados por los estudiantes."
            icon="heroicon-o-document-check"
        />
    </x-slot>

    <div class="ui-page">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Informes recibidos" :value="$totalInformes" description="Documentos registrados" icon="heroicon-o-document-text" />
            <x-ui.stat-card label="Estudiantes pendientes" :value="$alumnosSinInforme" description="Todavía sin entrega final" icon="heroicon-o-clock" tone="warning" />
            <x-ui.stat-card label="Periodos con entregas" :value="$informesPorAnio->count()" :description="$informesPorAnio->isEmpty() ? 'Sin actividad registrada' : $informesPorAnio->map(fn ($total, $periodo) => $periodo.': '.$total)->take(2)->implode(' · ')" icon="heroicon-o-calendar-days" />
        </div>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Buscar informes"
                    description="Filtra por identidad del estudiante o por semestre académico."
                    icon="heroicon-o-funnel"
                />
            </div>
            <form method="GET" action="{{ route('admin.informes-finales.index') }}" class="grid gap-4 p-5 sm:grid-cols-[minmax(0,1fr)_minmax(14rem,0.6fr)_auto] sm:items-end sm:p-6" role="search">
                <div>
                    <label for="nombre" class="ui-label">Estudiante</label>
                    <input id="nombre" type="search" name="nombre" value="{{ request('nombre') }}" class="ui-field" placeholder="Nombre, apellido o código">
                </div>
                <div>
                    <label for="semestre_id" class="ui-label">Semestre</label>
                    <select id="semestre_id" name="semestre_id" class="ui-field">
                        <option value="">Todos los semestres</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}" @selected((string) request('semestre_id') === (string) $semestre->id)>{{ $semestre->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="ui-btn-primary flex-1">@svg('heroicon-o-magnifying-glass', 'h-4 w-4') Buscar</button>
                    @if(request()->filled('nombre') || request()->filled('semestre_id'))
                        <a href="{{ route('admin.informes-finales.index') }}" class="ui-btn-secondary px-3" aria-label="Limpiar filtros">@svg('heroicon-o-x-mark', 'h-5 w-5')</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Documentos registrados"
                    :description="$informes->total().' informes coinciden con la consulta actual.'"
                    icon="heroicon-o-folder-open"
                >
                    <x-slot name="actions"><span class="ui-badge-info">{{ $informes->total() }} resultados</span></x-slot>
                </x-ui.section-heading>
            </div>

            @if($informes->isEmpty())
                <div class="p-5 sm:p-6">
                    <x-ui.empty-state
                        title="No se encontraron informes"
                        :description="request()->filled('nombre') || request()->filled('semestre_id') ? 'Prueba con otro criterio o limpia los filtros.' : 'Aún no se han registrado informes finales.'"
                        icon="heroicon-o-document-magnifying-glass"
                    >
                        @if(request()->filled('nombre') || request()->filled('semestre_id'))
                            <x-slot name="actions"><a href="{{ route('admin.informes-finales.index') }}" class="ui-btn-primary">Limpiar filtros</a></x-slot>
                        @endif
                    </x-ui.empty-state>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <caption class="sr-only">Informes finales registrados</caption>
                        <thead>
                            <tr>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Semestre</th>
                                <th scope="col">Entrega</th>
                                <th scope="col">Archivo</th>
                                <th scope="col" class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($informes as $informe)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td>
                                        <p class="font-semibold text-gray-900">{{ $informe->alumno->nombre_completo }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">Código {{ $informe->alumno->codigo_matricula }}</p>
                                    </td>
                                    <td><span class="ui-badge-info">{{ $informe->semestre?->nombre ?? 'Sin semestre' }}</span></td>
                                    <td>
                                        <time datetime="{{ $informe->fecha_subida->toIso8601String() }}" class="font-medium text-gray-700">{{ $informe->fecha_subida->format('d/m/Y') }}</time>
                                        <p class="mt-0.5 text-xs text-gray-500">{{ $informe->fecha_subida->format('H:i') }}</p>
                                    </td>
                                    <td>
                                        <p class="max-w-56 truncate font-medium text-gray-700" title="{{ $informe->nombre_original }}">{{ $informe->nombre_original }}</p>
                                        <p class="mt-0.5 text-xs text-gray-500">{{ $informe->tamanio_formateado }}</p>
                                    </td>
                                    <td>
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.informes-finales.download', $informe) }}" class="ui-btn-secondary px-3" aria-label="Descargar informe de {{ $informe->alumno->nombre_completo }}">
                                                @svg('heroicon-o-arrow-down-tray', 'h-4 w-4') <span class="hidden xl:inline">Descargar</span>
                                            </a>
                                            <form method="POST" action="{{ route('admin.informes-finales.destroy', $informe) }}" @submit="if (!confirm('¿Eliminar este informe? Esta acción no se puede deshacer.')) $event.preventDefault()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ui-btn-ghost px-2.5 text-red-700 hover:bg-red-50 hover:text-red-800" aria-label="Eliminar informe de {{ $informe->alumno->nombre_completo }}">@svg('heroicon-o-trash', 'h-5 w-5')</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 text-sm text-gray-600 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p>Mostrando <strong class="text-gray-900">{{ $informes->firstItem() }}–{{ $informes->lastItem() }}</strong> de <strong class="text-gray-900">{{ $informes->total() }}</strong></p>
                    {{ $informes->onEachSide(1)->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
