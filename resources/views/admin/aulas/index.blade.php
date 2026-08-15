<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración académica"
            title="Aulas"
            description="Gestiona los grupos, periodos y docentes responsables."
            icon="heroicon-o-academic-cap"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aulas.create') }}" class="ui-btn-primary">@svg('heroicon-o-plus', 'h-4 w-4') Nueva aula</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        @if($aulas->isEmpty())
            <x-ui.empty-state title="No hay aulas registradas" description="Crea un aula y asígnala a un semestre para iniciar la organización de estudiantes." icon="heroicon-o-academic-cap">
                <x-slot name="actions"><a href="{{ route('admin.aulas.create') }}" class="ui-btn-primary">Crear primera aula</a></x-slot>
            </x-ui.empty-state>
        @else
            <section class="ui-card overflow-hidden">
                <div class="ui-card-header">
                    <div>
                        <h2 class="font-bold text-gray-950">Directorio de aulas</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $aulas->total() }} grupos registrados en el sistema.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <caption class="sr-only">Aulas registradas</caption>
                        <thead>
                            <tr>
                                <th scope="col">Aula</th>
                                <th scope="col">Semestre</th>
                                <th scope="col">Docente responsable</th>
                                <th scope="col" class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aulas as $aula)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td><span class="font-bold text-gray-950">Aula {{ $aula->numero }}</span></td>
                                    <td><span class="ui-badge-info">{{ $aula->semestre->nombre ?? 'Sin asignar' }}</span></td>
                                    <td>
                                        @if($aula->profesor)
                                            <p class="font-semibold text-gray-900">{{ $aula->profesor->nombres }}</p>
                                            <p class="mt-0.5 text-xs text-gray-500">Código {{ $aula->profesor->codigo_profesor }}</p>
                                        @else
                                            <span class="ui-badge-warning">Docente pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.aulas.show', $aula) }}" class="ui-btn-ghost px-2.5" aria-label="Ver aula {{ $aula->numero }}">@svg('heroicon-o-eye', 'h-5 w-5')</a>
                                            <a href="{{ route('admin.aulas.edit', $aula) }}" class="ui-btn-ghost px-2.5" aria-label="Editar aula {{ $aula->numero }}">@svg('heroicon-o-pencil-square', 'h-5 w-5')</a>
                                            <form action="{{ route('admin.aulas.destroy', $aula) }}" method="POST" @submit="if (!confirm('¿Confirmas la eliminación de esta aula?')) $event.preventDefault()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ui-btn-ghost px-2.5 text-red-700 hover:bg-red-50 hover:text-red-800" aria-label="Eliminar aula {{ $aula->numero }}">@svg('heroicon-o-trash', 'h-5 w-5')</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-200 bg-gray-50 px-5 py-4 sm:px-6">{{ $aulas->onEachSide(1)->links() }}</div>
            </section>
        @endif
    </div>
</x-app-layout>
