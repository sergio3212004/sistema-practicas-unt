<x-app-layout :title="'Solicitud · '.$solicitud->nombre">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Vinculación empresarial"
            title="Revisar solicitud"
            :description="'Valida la identidad y los datos de '.$solicitud->nombre.' antes de tomar una decisión.'"
            icon="heroicon-o-document-magnifying-glass"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aprobaciones.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Aprobaciones</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">
        <section class="ui-card overflow-hidden">
            <div class="border-b border-gray-200 bg-blue-950 px-5 py-6 text-white sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/10" aria-hidden="true">@svg('heroicon-o-building-office-2', 'h-7 w-7')</span>
                        <div><h2 class="text-xl font-bold">{{ $solicitud->nombre }}</h2><p class="mt-1 text-sm text-blue-100">RUC {{ $solicitud->ruc }}</p></div>
                    </div>
                    @switch($solicitud->estado)
                        @case('aprobado') <span class="ui-badge-success">@svg('heroicon-o-check-circle', 'h-4 w-4') Aprobada</span> @break
                        @case('rechazado') <span class="ui-badge-danger">@svg('heroicon-o-x-circle', 'h-4 w-4') Rechazada</span> @break
                        @default <span class="ui-badge-warning">@svg('heroicon-o-clock', 'h-4 w-4') Pendiente</span>
                    @endswitch
                </div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-2">
            <section class="ui-card p-5 sm:p-6">
                <x-ui.section-heading title="Datos de la empresa" description="Información legal declarada durante el registro." icon="heroicon-o-building-office" />
                <dl class="mt-6 space-y-4">
                    <div class="flex flex-col gap-1 border-b border-gray-100 pb-4 sm:flex-row sm:justify-between"><dt class="text-sm text-gray-500">RUC</dt><dd class="font-semibold text-gray-900">{{ $solicitud->ruc }}</dd></div>
                    <div class="flex flex-col gap-1 border-b border-gray-100 pb-4 sm:flex-row sm:justify-between"><dt class="text-sm text-gray-500">Nombre comercial</dt><dd class="font-semibold text-gray-900">{{ $solicitud->nombre }}</dd></div>
                    <div class="flex flex-col gap-1 sm:flex-row sm:justify-between"><dt class="text-sm text-gray-500">Razón social</dt><dd class="font-semibold text-gray-900">{{ $solicitud->razonSocial?->nombre ?? 'No especificada' }}</dd></div>
                </dl>
            </section>

            <section class="ui-card p-5 sm:p-6">
                <x-ui.section-heading title="Contacto verificado" description="Canal utilizado para completar la solicitud." icon="heroicon-o-envelope" />
                <dl class="mt-6 space-y-4">
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Correo</dt><dd class="mt-1 break-all font-semibold text-gray-900">{{ $solicitud->email }}</dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Estado del correo</dt><dd class="mt-2"><span class="{{ $solicitud->email_verificado ? 'ui-badge-success' : 'ui-badge-danger' }}">{{ $solicitud->email_verificado ? 'Verificado' : 'No verificado' }}</span></dd></div>
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt><dd class="mt-1 font-semibold text-gray-900">{{ $solicitud->telefono ?: 'No especificado' }}</dd></div>
                </dl>
            </section>
        </div>

        <section class="ui-card p-5 sm:p-6">
            <x-ui.section-heading title="Ubicación declarada" description="Comprueba que el domicilio sea consistente con la información de la empresa." icon="heroicon-o-map-pin" />
            <dl class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach(['Departamento' => $solicitud->departamento, 'Provincia' => $solicitud->provincia, 'Distrito' => $solicitud->distrito, 'Dirección' => $solicitud->direccion] as $label => $value)
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $label }}</dt><dd class="mt-1 font-semibold text-gray-900">{{ $value ?: 'No especificado' }}</dd></div>
                @endforeach
            </dl>
        </section>

        @if($solicitud->estado === 'pendiente')
            <section class="ui-card p-5 sm:p-6" aria-labelledby="decision-titulo">
                <x-ui.section-heading title="Decisión de la solicitud" description="Aprobar crea la cuenta empresarial; rechazar cierra esta solicitud." icon="heroicon-o-check-badge" />

                @if($solicitud->email_verificado)
                    <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
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
                @else
                    <div class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 p-4 text-sm leading-6 text-yellow-800">La empresa debe verificar su correo antes de que puedas aprobar la solicitud.</div>
                @endif
            </section>
        @endif

        <p class="text-center text-xs text-gray-500">Solicitud recibida el {{ $solicitud->created_at->format('d/m/Y · H:i') }}</p>
    </div>
</x-app-layout>
