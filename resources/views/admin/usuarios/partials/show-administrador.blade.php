<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <p class="font-semibold text-gray-600">Nombres</p>
        <p>{{ $usuario->administrador->nombres }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Apellido Paterno</p>
        <p>{{ $usuario->administrador->apellido_paterno }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Apellido Materno</p>
        <p>{{ $usuario->administrador->apellido_materno }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Teléfono</p>
        <p>{{ $usuario->administrador->telefono ?? '—' }}</p>
    </div>
</div>
