<div class="space-y-6">
    <dl class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">RUC</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->empresa?->ruc ?: 'No registrado' }}</dd></div>
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Nombre comercial</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->empresa?->nombre ?: 'No registrado' }}</dd></div>
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Razón social</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->empresa?->razonSocial?->acronimo ?: 'No registrada' }}</dd></div>
        <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->empresa?->telefono ?: 'No registrado' }}</dd></div>
    </dl>

    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-sm font-bold text-gray-950">Ubicación de la empresa</h3>
        <dl class="mt-4 grid gap-4 sm:grid-cols-2">
            <div><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Departamento</dt><dd class="mt-1 text-gray-900">{{ $usuario->empresa?->departamento ?: 'No registrado' }}</dd></div>
            <div><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Provincia / Distrito</dt><dd class="mt-1 text-gray-900">{{ collect([$usuario->empresa?->provincia, $usuario->empresa?->distrito])->filter()->implode(' / ') ?: 'No registrados' }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Dirección</dt><dd class="mt-1 text-gray-900">{{ $usuario->empresa?->direccion ?: 'No registrada' }}</dd></div>
        </dl>
    </div>
</div>
