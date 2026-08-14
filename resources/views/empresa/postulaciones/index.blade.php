<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Selección de talento"
            title="Postulaciones"
            description="Revisa las candidaturas recibidas en cada una de tus publicaciones."
            icon="heroicon-o-paper-airplane"
        />
    </x-slot>

    <div class="ui-page">
        @if(!$empresa)
            <x-ui.empty-state title="No hay una empresa asociada" description="Tu cuenta necesita estar vinculada a una empresa para revisar postulaciones." icon="heroicon-o-building-office-2" />
        @elseif($publicaciones->isEmpty())
            <x-ui.empty-state title="No hay publicaciones para revisar" description="Crea una oportunidad de prácticas para empezar a recibir candidaturas." icon="heroicon-o-paper-airplane">
                <x-slot name="actions"><a href="{{ route('empresa.publicaciones.create') }}" class="ui-btn-primary">Crear publicación</a></x-slot>
            </x-ui.empty-state>
        @else
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($publicaciones as $publicacion)
                    <article class="ui-card flex min-h-full flex-col overflow-hidden">
                        <div class="border-b border-gray-100 bg-blue-900 px-5 py-4 text-white">
                            <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-gold-400">{{ $publicacion->estado ?? 'Disponible' }}</p>
                            <h2 class="mt-1 text-lg font-bold">{{ $publicacion->cargo ?? 'Cargo no especificado' }}</h2>
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="text-sm font-bold text-gray-950">{{ $publicacion->nombre }}</h3>
                            <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-600">{{ $publicacion->descripcion }}</p>
                            <div class="mt-5 flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                                <span class="text-sm font-medium text-gray-600">Candidaturas recibidas</span>
                                <span class="text-lg font-bold text-blue-800">{{ $publicacion->postulaciones_count }}</span>
                            </div>
                            <div class="mt-auto pt-5">
                                <a href="{{ route('empresa.postulaciones.show', $publicacion) }}" class="ui-btn-primary w-full">Revisar postulaciones @svg('heroicon-o-arrow-right', 'h-4 w-4')</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
