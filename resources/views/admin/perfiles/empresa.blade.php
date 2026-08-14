<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil de Empresa
            </h2>
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Card Principal --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">

                {{-- Header con banner --}}
                <div class="h-32 bg-gradient-to-r from-indigo-600 to-blue-500"></div>

                {{-- Contenido del perfil --}}
                <div class="relative px-6 pb-6">

                    {{-- Avatar/Icono --}}
                    <div class="absolute -top-12 left-6">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg flex items-center justify-center border-4 border-white">
                            @svg('heroicon-o-building-office-2', 'w-12 h-12 text-indigo-600')
                        </div>
                    </div>

                    {{-- Info principal --}}
                    <div class="pt-14">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $empresa->nombre }}</h1>
                                <p class="text-gray-500 flex items-center mt-1">
                                    @svg('heroicon-o-identification', 'w-4 h-4 mr-1')
                                    RUC: {{ $empresa->ruc }}
                                </p>
                            </div>

                            {{-- Estado --}}
                            <div class="flex items-center gap-2">
                                @if($empresa->aprobado)
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        @svg('heroicon-o-check-badge', 'w-4 h-4 mr-1')
                                        Empresa Verificada
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        @svg('heroicon-o-clock', 'w-4 h-4 mr-1')
                                        Pendiente de Aprobación
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid de información --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

                {{-- Información de Contacto --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        @svg('heroicon-o-phone', 'w-5 h-5 mr-2 text-indigo-600')
                        Información de Contacto
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-envelope', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-900 font-medium">{{ $empresa->user->email ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-phone', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Teléfono</p>
                                <p class="text-gray-900 font-medium">{{ $empresa->telefono ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-scale', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Razón Social</p>
                                <p class="text-gray-900 font-medium">{{ $empresa->razonSocial->nombre ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ubicación --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        @svg('heroicon-o-map-pin', 'w-5 h-5 mr-2 text-indigo-600')
                        Ubicación
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-globe-americas', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Departamento</p>
                                <p class="text-gray-900 font-medium">{{ $empresa->departamento ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-map', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Provincia / Distrito</p>
                                <p class="text-gray-900 font-medium">
                                    {{ $empresa->provincia ?? '-' }} / {{ $empresa->distrito ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center">
                                @svg('heroicon-o-home', 'w-5 h-5 text-indigo-600')
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Dirección</p>
                                <p class="text-gray-900 font-medium">{{ $empresa->direccion ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Publicaciones de la empresa --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    @svg('heroicon-o-briefcase', 'w-5 h-5 mr-2 text-indigo-600')
                    Ofertas de Prácticas Publicadas
                    <span class="ml-2 bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $empresa->publicaciones->count() }}
                    </span>
                </h3>

                @if($empresa->publicaciones->count() > 0)
                    <div class="grid gap-4">
                        @foreach($empresa->publicaciones as $pub)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $pub->titulo }}</h4>
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($pub->descripcion, 150) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $pub->created_at->diffForHumans() }}</span>
                                </div>
                                @if($pub->vacantes)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $pub->vacantes }} vacantes
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        @svg('heroicon-o-document-text', 'w-12 h-12 mx-auto text-gray-300 mb-3')
                        <p>Esta empresa aún no ha publicado ofertas de prácticas.</p>
                    </div>
                @endif
            </div>

            {{-- Información del sistema --}}
            <div class="bg-gray-50 rounded-xl p-4 mt-6">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Registrado el {{ $empresa->created_at->format('d/m/Y H:i') }}</span>
                    <span>Última actualización: {{ $empresa->updated_at->diffForHumans() }}</span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
