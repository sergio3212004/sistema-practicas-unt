<x-app-layout :title="'Empresa · '.$empresa->nombre">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Vinculación empresarial"
            :title="$empresa->nombre"
            :description="'RUC '.$empresa->ruc.' · Perfil institucional de la empresa'"
            icon="heroicon-o-building-office-2"
        >
            <x-slot name="actions">
                <a href="{{ url()->previous() }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">
        <section class="ui-card overflow-hidden">
            <div class="border-b border-gray-200 bg-blue-950 px-5 py-6 text-white sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/10" aria-hidden="true">@svg('heroicon-o-building-office-2', 'h-7 w-7')</span>
                        <div>
                            <h2 class="text-xl font-bold">{{ $empresa->nombre }}</h2>
                            <p class="mt-1 text-sm text-blue-100">{{ $empresa->razonSocial?->nombre ?? 'Razón social no registrada' }}</p>
                        </div>
                    </div>
                    <span class="{{ $empresa->aprobado ? 'ui-badge-success' : 'ui-badge-warning' }}">
                        @svg($empresa->aprobado ? 'heroicon-o-check-badge' : 'heroicon-o-clock', 'h-4 w-4')
                        {{ $empresa->aprobado ? 'Empresa verificada' : 'Pendiente de aprobación' }}
                    </span>
                </div>
            </div>
            <div class="grid gap-5 p-5 sm:grid-cols-3 sm:p-6">
                <div><p class="text-xs font-bold uppercase tracking-wider text-gray-500">RUC</p><p class="mt-1 font-semibold text-gray-900">{{ $empresa->ruc }}</p></div>
                <div><p class="text-xs font-bold uppercase tracking-wider text-gray-500">Publicaciones</p><p class="mt-1 font-semibold text-gray-900">{{ $empresa->publicaciones->count() }} registradas</p></div>
                <div><p class="text-xs font-bold uppercase tracking-wider text-gray-500">Registro</p><time class="mt-1 block font-semibold text-gray-900" datetime="{{ $empresa->created_at->toIso8601String() }}">{{ $empresa->created_at->format('d/m/Y') }}</time></div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="ui-card p-5 sm:p-6">
                <x-ui.section-heading title="Información de contacto" description="Canales registrados para comunicarse con la empresa." icon="heroicon-o-phone" />
                <dl class="mt-6 space-y-4">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Correo</dt><dd class="mt-1 break-all font-semibold text-gray-900">{{ $empresa->user?->email ?? 'No especificado' }}</dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt><dd class="mt-1 font-semibold text-gray-900">{{ $empresa->telefono ?: 'No especificado' }}</dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Razón social</dt><dd class="mt-1 font-semibold text-gray-900">{{ $empresa->razonSocial?->nombre ?? 'No especificada' }}</dd></div>
                </dl>
            </section>

            <section class="ui-card p-5 sm:p-6">
                <x-ui.section-heading title="Ubicación" description="Domicilio declarado por la organización." icon="heroicon-o-map-pin" />
                <dl class="mt-6 space-y-4">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Departamento</dt><dd class="mt-1 font-semibold text-gray-900">{{ $empresa->departamento ?: 'No especificado' }}</dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Provincia / Distrito</dt><dd class="mt-1 font-semibold text-gray-900">{{ collect([$empresa->provincia, $empresa->distrito])->filter()->implode(' / ') ?: 'No especificados' }}</dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Dirección</dt><dd class="mt-1 font-semibold text-gray-900">{{ $empresa->direccion ?: 'No especificada' }}</dd></div>
                </dl>
            </section>
        </div>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Ofertas de prácticas"
                    :description="$empresa->publicaciones->count().' publicaciones creadas por esta empresa.'"
                    icon="heroicon-o-briefcase"
                >
                    <x-slot name="actions"><span class="ui-badge-info">{{ $empresa->publicaciones->count() }} ofertas</span></x-slot>
                </x-ui.section-heading>
            </div>

            @if($empresa->publicaciones->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="Sin publicaciones" description="Esta empresa todavía no ha publicado oportunidades de prácticas." icon="heroicon-o-newspaper" /></div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($empresa->publicaciones as $publicacion)
                        <article class="flex flex-col gap-3 p-5 sm:flex-row sm:items-start sm:justify-between sm:p-6">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-bold text-gray-950">{{ $publicacion->cargo ?: $publicacion->nombre }}</h3>
                                    <span class="{{ $publicacion->estado === 'Cubierta' ? 'ui-badge-danger' : 'ui-badge-success' }}">{{ $publicacion->estado ?: 'Disponible' }}</span>
                                </div>
                                <p class="mt-1 text-sm font-medium text-gray-700">{{ $publicacion->nombre }}</p>
                                <p class="mt-2 max-w-3xl text-sm leading-6 text-gray-600">{{ Str::limit($publicacion->descripcion, 180) }}</p>
                            </div>
                            <time class="shrink-0 text-xs text-gray-500" datetime="{{ $publicacion->created_at->toIso8601String() }}">{{ $publicacion->created_at->diffForHumans(['parts' => 2]) }}</time>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <p class="text-center text-xs text-gray-500">Última actualización: {{ $empresa->updated_at->diffForHumans() }}</p>
    </div>
</x-app-layout>
