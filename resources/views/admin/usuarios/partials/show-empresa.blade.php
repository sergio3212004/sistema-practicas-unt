<div class="space-y-6">

    <!-- Datos principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="font-semibold text-gray-600">RUC</p>
            <p class="text-gray-900">{{ $usuario->empresa->ruc }}</p>
        </div>

        <div>
            <p class="font-semibold text-gray-600">Nombre Comercial</p>
            <p class="text-gray-900">{{ $usuario->empresa->nombre }}</p>
        </div>

        <div>
            <p class="font-semibold text-gray-600">Razón Social</p>
            <p class="text-gray-900">
                {{ $usuario->empresa->razonSocial->acronimo ?? '—' }}
            </p>
        </div>

        <div>
            <p class="font-semibold text-gray-600">Teléfono</p>
            <p class="text-gray-900">{{ $usuario->empresa->telefono ?? '—' }}</p>
        </div>
    </div>

    <!-- Separador -->
    <div class="border-t border-gray-200 pt-4">
        <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">
            Ubicación de la Empresa
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="font-semibold text-gray-600">Departamento</p>
                <p class="text-gray-900">{{ $usuario->empresa->departamento }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-600">Provincia</p>
                <p class="text-gray-900">{{ $usuario->empresa->provincia }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-600">Distrito</p>
                <p class="text-gray-900">{{ $usuario->empresa->distrito }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-600">Dirección</p>
                <p class="text-gray-900">{{ $usuario->empresa->direccion }}</p>
            </div>
        </div>
    </div>

</div>
