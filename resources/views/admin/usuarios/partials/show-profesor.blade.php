<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <p class="font-semibold text-gray-600">Código Profesor</p>
        <p>{{ $usuario->profesor->codigo_profesor }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Teléfono</p>
        <p>{{ $usuario->profesor->telefono ?? '—' }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Nombres</p>
        <p>{{ $usuario->profesor->nombres }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Apellidos</p>
        <p>
            {{ $usuario->profesor->apellido_paterno }}
            {{ $usuario->profesor->apellido_materno }}
        </p>
    </div>
</div>
