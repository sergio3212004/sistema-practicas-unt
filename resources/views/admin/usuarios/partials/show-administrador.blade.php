<dl class="grid gap-4 sm:grid-cols-2">
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Nombres</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->administrador?->nombres ?: 'No registrado' }}</dd></div>
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Apellidos</dt><dd class="mt-1 font-semibold text-gray-900">{{ collect([$usuario->administrador?->apellido_paterno, $usuario->administrador?->apellido_materno])->filter()->implode(' ') ?: 'No registrados' }}</dd></div>
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 sm:col-span-2"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->administrador?->telefono ?: 'No registrado' }}</dd></div>
</dl>
