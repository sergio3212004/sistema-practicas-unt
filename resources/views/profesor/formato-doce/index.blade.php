<x-app-layout title="Formato 12">
    <x-slot name="header"><x-ui.page-header eyebrow="Seguimiento de prácticas" title="Formato 12" description="Registra y consulta el monitoreo consolidado de tus aulas activas." icon="heroicon-o-clipboard-document-check"><x-slot name="actions"><a href="{{ route('profesor.formato-doce.create') }}" class="ui-btn-primary">@svg('heroicon-o-plus', 'h-4 w-4') Nuevo formato</a></x-slot></x-ui.page-header></x-slot>
    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Historial de monitoreos" :description="$formatos->total().' formatos registrados.'" icon="heroicon-o-clock" /></div>
            @if($formatos->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="Aún no hay Formatos 12" description="Registra el primer monitoreo consolidado de un aula activa." icon="heroicon-o-document-plus"><x-slot name="actions"><a href="{{ route('profesor.formato-doce.create') }}" class="ui-btn-primary">Crear formato</a></x-slot></x-ui.empty-state></div>
            @else
                <div class="overflow-x-auto"><table class="ui-table"><caption class="sr-only">Formatos 12 registrados</caption><thead><tr><th scope="col">Fecha</th><th scope="col">Aula</th><th scope="col">Semestre</th><th scope="col">Estudiantes</th><th scope="col" class="text-right">Acciones</th></tr></thead><tbody>
                    @foreach($formatos as $formato)<tr><td><time datetime="{{ $formato->created_at->toIso8601String() }}" class="font-semibold text-gray-900">{{ $formato->created_at->format('d/m/Y H:i') }}</time></td><td><span class="font-medium text-gray-800">Aula {{ $formato->aula->numero }}</span></td><td><span class="ui-badge-info">{{ $formato->aula->semestre?->nombre ?? 'Sin semestre' }}</span></td><td>{{ $formato->formatosDoceAlumnos->count() }} estudiantes</td><td><div class="flex justify-end gap-2"><a href="{{ route('profesor.formato-doce.show', $formato) }}" class="ui-btn-secondary px-3">Ver detalle</a><form action="{{ route('profesor.formato-doce.destroy', $formato) }}" method="POST" onsubmit="return confirm('¿Eliminar este formato? Esta acción no se puede deshacer.');">@csrf @method('DELETE')<button type="submit" class="ui-btn-ghost px-2.5 text-red-700" aria-label="Eliminar Formato 12 del {{ $formato->created_at->format('d/m/Y') }}">@svg('heroicon-o-trash', 'h-5 w-5')</button></form></div></td></tr>@endforeach
                </tbody></table></div><div class="border-t border-gray-200 bg-gray-50 px-5 py-4">{{ $formatos->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
