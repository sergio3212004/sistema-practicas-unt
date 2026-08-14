<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <p class="font-semibold text-gray-600">Código Matrícula</p>
        <p>{{ $usuario->alumno->codigo_matricula }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Teléfono</p>
        <p>{{ $usuario->alumno->telefono ?? '—' }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Nombres</p>
        <p>{{ $usuario->alumno->nombres }}</p>
    </div>

    <div>
        <p class="font-semibold text-gray-600">Apellidos</p>
        <p>
            {{ $usuario->alumno->apellido_paterno }}
            {{ $usuario->alumno->apellido_materno }}
        </p>
    </div>
</div>
