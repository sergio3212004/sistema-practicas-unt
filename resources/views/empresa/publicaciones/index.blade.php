<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Vinculación empresarial"
            title="Publicaciones"
            description="Administra las oportunidades de prácticas visibles para los estudiantes."
            icon="heroicon-o-newspaper"
        >
            <x-slot name="actions">
                <a href="{{ route('empresa.publicaciones.create') }}" class="ui-btn-primary">
                    @svg('heroicon-o-plus', 'h-4 w-4') Nueva publicación
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        @if(!$empresa)
            <x-ui.empty-state
                title="No hay una empresa asociada"
                description="Tu cuenta necesita estar vinculada a una empresa para poder gestionar publicaciones."
                icon="heroicon-o-building-office-2"
            />
        @elseif($publicaciones->isEmpty())
            <x-ui.empty-state
                title="Aún no tienes publicaciones"
                description="Publica una oportunidad clara y completa para conectar con estudiantes de Ingeniería Informática."
                icon="heroicon-o-newspaper"
            >
                <x-slot name="actions">
                    <a href="{{ route('empresa.publicaciones.create') }}" class="ui-btn-primary">Crear primera publicación</a>
                </x-slot>
            </x-ui.empty-state>
        @else
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600"><strong class="text-gray-900">{{ $publicaciones->count() }}</strong> publicaciones registradas</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($publicaciones as $publicacion)
                    <article class="ui-card flex min-h-full flex-col overflow-hidden transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-raised">
                        @if($publicacion->imagen)
                            <img
                                src="{{ asset('storage/'.$publicacion->imagen) }}"
                                alt="Imagen de la publicación {{ $publicacion->nombre }}"
                                class="h-40 w-full object-cover"
                            >
                        @endif

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-4">
                                <span class="{{ $publicacion->estado === 'Cubierta' ? 'ui-badge-danger' : 'ui-badge-success' }}">{{ $publicacion->estado ?? 'Disponible' }}</span>
                                <time class="text-xs text-gray-500" datetime="{{ $publicacion->created_at->toDateString() }}">{{ $publicacion->created_at->diffForHumans(['parts' => 2]) }}</time>
                            </div>

                            <p class="mt-5 text-xs font-bold uppercase tracking-[0.14em] text-blue-700">Convocatoria</p>
                            <h2 class="mt-2 text-lg font-bold leading-6 text-gray-950">{{ $publicacion->cargo ?? 'Cargo no especificado' }}</h2>
                            <p class="mt-1 text-sm font-medium text-gray-700">{{ $publicacion->nombre }}</p>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">{{ $publicacion->descripcion }}</p>

                            <div class="mt-auto flex gap-2 border-t border-gray-100 pt-5">
                                <a href="{{ route('empresa.publicaciones.edit', $publicacion) }}" class="ui-btn-secondary flex-1">
                                    @svg('heroicon-o-pencil-square', 'h-4 w-4') Editar
                                </a>
                                <form action="{{ route('empresa.publicaciones.destroy', $publicacion) }}" method="POST" class="flex-1" @submit="if (!confirm('¿Confirmas la eliminación de esta publicación?')) $event.preventDefault()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ui-btn-danger w-full">@svg('heroicon-o-trash', 'h-4 w-4') Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
