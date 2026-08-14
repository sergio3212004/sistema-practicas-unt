<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Vinculación empresarial"
            title="Aprobación de empresas"
            description="Verifica los datos de las organizaciones antes de habilitar su acceso."
            icon="heroicon-o-check-badge"
        />
    </x-slot>

    <div class="ui-page">
        @if($solicitudesPendientes->isEmpty())
            <x-ui.empty-state title="No hay solicitudes pendientes" description="Todas las solicitudes de registro han sido revisadas." icon="heroicon-o-check-circle" />
        @else
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600"><strong class="text-gray-900">{{ $solicitudesPendientes->total() }}</strong> solicitudes requieren revisión</p>
                <span class="ui-badge-warning">Pendientes</span>
            </div>

            <div class="grid gap-5 xl:grid-cols-2">
                @foreach($solicitudesPendientes as $solicitud)
                    <article class="ui-card overflow-hidden">
                        <div class="ui-card-header">
                            <div class="flex items-center gap-3">
                                <span class="ui-icon-box">@svg('heroicon-o-building-office-2', 'h-5 w-5')</span>
                                <div>
                                    <a href="{{ route('admin.perfil.solicitud', $solicitud) }}" class="flex items-center gap-1 font-bold text-gray-950 hover:text-blue-800">
                                        {{ $solicitud->nombre }} @svg('heroicon-o-arrow-top-right-on-square', 'h-3.5 w-3.5')
                                    </a>
                                    <p class="mt-0.5 text-xs text-gray-500">RUC {{ $solicitud->ruc }} · {{ $solicitud->razonSocial->acronimo ?? 'Sin razón social' }}</p>
                                </div>
                            </div>
                            <time class="text-xs text-gray-500" datetime="{{ $solicitud->created_at->toIso8601String() }}">{{ $solicitud->created_at->format('d/m/Y · H:i') }}</time>
                        </div>
                        <div class="p-5 sm:p-6">
                            <dl class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Correo verificado</dt>
                                    <dd class="mt-1 break-all text-sm font-semibold text-gray-900">{{ $solicitud->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $solicitud->telefono ?? 'No registrado' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Ubicación</dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ collect([$solicitud->distrito, $solicitud->provincia, $solicitud->departamento])->filter()->implode(', ') ?: 'No especificada' }}</dd>
                                </div>
                            </dl>
                            <div class="mt-6 flex flex-col gap-2 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
                                <form action="{{ route('admin.aprobaciones.rechazar', $solicitud) }}" method="POST" @submit="if (!confirm('¿Confirmas el rechazo de esta solicitud?')) $event.preventDefault()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ui-btn-danger w-full sm:w-auto">@svg('heroicon-o-x-mark', 'h-4 w-4') Rechazar</button>
                                </form>
                                <form action="{{ route('admin.aprobaciones.aprobar', $solicitud) }}" method="POST" @submit="if (!confirm('¿Confirmas la aprobación y creación de la cuenta empresarial?')) $event.preventDefault()">
                                    @csrf
                                    <button type="submit" class="ui-btn-primary w-full sm:w-auto">@svg('heroicon-o-check', 'h-4 w-4') Aprobar empresa</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div>{{ $solicitudesPendientes->onEachSide(1)->links() }}</div>
        @endif
    </div>
</x-app-layout>
