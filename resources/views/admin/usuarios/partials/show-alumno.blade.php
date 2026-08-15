<dl class="grid gap-4 sm:grid-cols-2">
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Código de matrícula</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->alumno?->codigo_matricula ?: 'No registrado' }}</dd></div>
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Teléfono</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->alumno?->telefono ?: 'No registrado' }}</dd></div>
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Nombres</dt><dd class="mt-1 font-semibold text-gray-900">{{ $usuario->alumno?->nombres ?: 'No registrados' }}</dd></div>
    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4"><dt class="text-xs font-bold uppercase tracking-wider text-gray-500">Apellidos</dt><dd class="mt-1 font-semibold text-gray-900">{{ collect([$usuario->alumno?->apellido_paterno, $usuario->alumno?->apellido_materno])->filter()->implode(' ') ?: 'No registrados' }}</dd></div>
</dl>
