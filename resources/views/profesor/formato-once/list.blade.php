<x-app-layout :title="'Formato 11 · Aula '.$aula->numero">
    <x-slot name="header"><x-ui.page-header eyebrow="Documentación académica" :title="'Formato 11 · Aula '.$aula->numero" :description="$aula->semestre?->nombre ?? 'Sin semestre'" icon="heroicon-o-document-text"><x-slot name="actions"><a href="{{ route('profesor.formato-once.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Aulas</a><a href="{{ route('profesor.formato-once.create', $aula) }}" class="ui-btn-primary">@svg('heroicon-o-plus', 'h-4 w-4') Nuevo formato</a></x-slot></x-ui.page-header></x-slot>
    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Historial de formatos" :description="$aula->formatosOnce->count().' registros encontrados.'" icon="heroicon-o-clock" /></div>
            @if($aula->formatosOnce->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="Aún no hay formatos" description="Registra la primera evaluación de conformidad para esta aula." icon="heroicon-o-document-plus"><x-slot name="actions"><a href="{{ route('profesor.formato-once.create', $aula) }}" class="ui-btn-primary">Crear formato</a></x-slot></x-ui.empty-state></div>
            @else
                <div class="overflow-x-auto"><table class="ui-table"><caption class="sr-only">Formatos 11 del aula {{ $aula->numero }}</caption><thead><tr><th scope="col">Fecha</th><th scope="col">Estudiantes</th><th scope="col">Estado</th><th scope="col" class="text-right">Acciones</th></tr></thead><tbody>
                    @foreach($aula->formatosOnce as $formato)<tr><td><time datetime="{{ $formato->created_at->toIso8601String() }}" class="font-semibold text-gray-900">{{ $formato->created_at->format('d/m/Y H:i') }}</time></td><td>{{ $formato->formatoOnceAlumnos->count() }} estudiantes</td><td><span class="ui-badge-success">Completado</span></td><td><div class="flex justify-end gap-2"><a href="{{ route('profesor.formato-once.show', $formato) }}" class="ui-btn-secondary px-3">Ver</a><a href="{{ route('profesor.formato-once.edit', $formato) }}" class="ui-btn-secondary px-3">Editar</a><a href="{{ route('profesor.formato-once.pdf', $formato) }}" class="ui-btn-secondary px-3">PDF</a><form action="{{ route('profesor.formato-once.destroy', $formato) }}" method="POST" onsubmit="return confirm('¿Eliminar este formato? Esta acción no se puede deshacer.');">@csrf @method('DELETE')<button type="submit" class="ui-btn-ghost px-2.5 text-red-700" aria-label="Eliminar formato del {{ $formato->created_at->format('d/m/Y') }}">@svg('heroicon-o-trash', 'h-5 w-5')</button></form></div></td></tr>@endforeach
                </tbody></table></div>
            @endif
        </section>
    </div>
</x-app-layout>
