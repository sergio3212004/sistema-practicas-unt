<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalle de Solicitud
            </h2>
            <a href="{{ route('admin.aprobaciones.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver a Aprobaciones
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Card Principal --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">

                {{-- Header con banner --}}
                <div class="h-24 bg-gradient-to-r from-amber-500 to-orange-500"></div>

                {{-- Contenido --}}
                <div class="relative px-6 pb-6">

                    {{-- Icono --}}
                    <div class="absolute -top-10 left-6">
                        <div class="w-20 h-20 bg-white rounded-xl shadow-lg flex items-center justify-center border-4 border-white">
                            @svg('heroicon-o-document-text', 'w-10 h-10 text-amber-600')
                        </div>
                    </div>

                    {{-- Info principal --}}
                    <div class="pt-12">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $solicitud->nombre }}</h1>
                                <p class="text-gray-500 mt-1">Solicitud de registro de empresa</p>
                            </div>

                            {{-- Estado --}}
                            <div>
                                @switch($solicitud->estado)
                                    @case('pendiente')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            @svg('heroicon-o-clock', 'w-4 h-4 mr-1')
                                            Pendiente
                                        </span>
                                        @break
                                    @case('aprobado')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            @svg('heroicon-o-check-circle', 'w-4 h-4 mr-1')
                                            Aprobado
                                        </span>
                                        @break
                                    @case('rechazado')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            @svg('heroicon-o-x-circle', 'w-4 h-4 mr-1')
                                            Rechazado
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información detallada --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                {{-- Datos de la Empresa --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        @svg('heroicon-o-building-office', 'w-5 h-5 mr-2 text-amber-600')
                        Datos de la Empresa
                    </h3>

                    <dl class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">RUC</dt>
                            <dd class="font-medium text-gray-900">{{ $solicitud->ruc }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">Nombre</dt>
                            <dd class="font-medium text-gray-900">{{ $solicitud->nombre }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">Razón Social</dt>
                            <dd class="font-medium text-gray-900">{{ $solicitud->razonSocial->nombre ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between py-2">
                            <dt class="text-gray-500">Teléfono</dt>
                            <dd class="font-medium text-gray-900">{{ $solicitud->telefono ?? 'No especificado' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Datos de Contacto --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        @svg('heroicon-o-envelope', 'w-5 h-5 mr-2 text-amber-600')
                        Datos de Contacto
                    </h3>

                    <dl class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="font-medium text-gray-900">{{ $solicitud->email }}</dd>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">Email Verificado</dt>
                            <dd>
                                @if($solicitud->email_verificado)
                                    <span class="inline-flex items-center text-green-600">
                                        @svg('heroicon-o-check-circle', 'w-5 h-5 mr-1')
                                        Sí
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-red-600">
                                        @svg('heroicon-o-x-circle', 'w-5 h-5 mr-1')
                                        No
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Ubicación --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    @svg('heroicon-o-map-pin', 'w-5 h-5 mr-2 text-amber-600')
                    Ubicación
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Departamento</p>
                        <p class="font-medium text-gray-900">{{ $solicitud->departamento ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Provincia</p>
                        <p class="font-medium text-gray-900">{{ $solicitud->provincia ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Distrito</p>
                        <p class="font-medium text-gray-900">{{ $solicitud->distrito ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="font-medium text-gray-900">{{ $solicitud->direccion ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Acciones (solo si está pendiente) --}}
            @if($solicitud->estado === 'pendiente' && $solicitud->email_verificado)
                <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones</h3>

                    <div class="flex gap-4">
                        <form action="{{ route('admin.aprobaciones.aprobar', $solicitud->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('¿Aprobar esta solicitud? Se creará la cuenta de usuario.')"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                @svg('heroicon-o-check', 'w-5 h-5 mr-2')
                                Aprobar Solicitud
                            </button>
                        </form>

                        <form action="{{ route('admin.aprobaciones.rechazar', $solicitud->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Rechazar esta solicitud?')"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                @svg('heroicon-o-x-mark', 'w-5 h-5 mr-2')
                                Rechazar Solicitud
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Info del sistema --}}
            <div class="bg-gray-50 rounded-xl p-4 mt-6">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Solicitud creada el {{ $solicitud->created_at->format('d/m/Y H:i') }}</span>
                    <span>Hace {{ $solicitud->created_at->diffForHumans() }}</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
