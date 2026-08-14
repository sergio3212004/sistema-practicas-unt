<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Oportunidades"
            title="Prácticas disponibles"
            description="Explora convocatorias de empresas vinculadas y encuentra una oportunidad alineada con tu formación."
            icon="heroicon-o-briefcase"
        />
    </x-slot>

    <div class="ui-page">
        @if($practicas->isEmpty())
            <x-ui.empty-state
                title="No hay convocatorias disponibles"
                description="Las nuevas oportunidades aparecerán aquí cuando una empresa publique una convocatoria activa."
                icon="heroicon-o-briefcase"
            />
        @else
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600"><strong class="text-gray-900">{{ $practicas->count() }}</strong> oportunidades disponibles</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($practicas as $practica)
                    <article class="ui-card flex min-h-full flex-col overflow-hidden transition hover:-translate-y-0.5 hover:border-blue-200 hover:shadow-raised">
                        @if($practica->imagen)
                            <img
                                src="{{ asset('storage/' . $practica->imagen) }}"
                                alt="Imagen de la convocatoria {{ $practica->nombre }}"
                                class="h-40 w-full object-cover"
                            >
                        @endif

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <div class="flex items-start justify-between gap-4">
                                <span class="{{ $practica->estado === 'Cubierta' ? 'ui-badge-danger' : 'ui-badge-success' }}">{{ $practica->estado }}</span>
                                <time class="text-xs text-gray-500" datetime="{{ $practica->created_at->toDateString() }}">{{ $practica->created_at->diffForHumans() }}</time>
                            </div>

                            <p class="mt-5 text-xs font-bold uppercase tracking-[0.14em] text-blue-700">{{ $practica->empresa->nombre ?? 'Empresa vinculada' }}</p>
                            <h2 class="mt-2 text-lg font-bold leading-6 text-gray-950">{{ $practica->cargo }}</h2>
                            <p class="mt-1 text-sm font-medium text-gray-700">{{ $practica->nombre }}</p>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-gray-600">{{ $practica->descripcion }}</p>

                            <div class="mt-auto pt-6">
                                <a href="{{ route('alumno.practicas.show', $practica->id) }}" class="ui-btn-primary w-full">
                                    Ver detalles @svg('heroicon-o-arrow-right', 'h-4 w-4')
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
