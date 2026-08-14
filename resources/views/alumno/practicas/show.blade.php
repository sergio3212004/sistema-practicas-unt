<x-app-layout :title="$practica->nombre">
    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <x-heroicon-o-briefcase class="h-8 w-8 text-indigo-600"/>
                    {{ $practica->nombre }}
                </h1>
                <p class="text-gray-500 mt-1">
                    {{ $practica->cargo }}
                </p>
            </div>

            <a href="{{ route('alumno.practicas.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                Volver
            </a>
        </div>

        {{-- Card principal --}}
        <div class="relative mb-10">
            <!-- Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-20"></div>

            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Imagen --}}
                @if($practica->imagen)
                    <img src="{{ asset('storage/' . $practica->imagen) }}" alt="Imagen referencial"
                         class="w-full max-h-96 object-cover">
                @endif

                {{-- Contenido --}}
                <div class="p-8 space-y-6">

                    {{-- Estado y fecha --}}
                    <div class="flex items-center justify-between">
                        <span class="px-4 py-1 text-sm font-semibold rounded-full
                            {{ $practica->estado === 'Cubierta'
                                ? 'bg-red-100 text-red-800'
                                : 'bg-green-100 text-green-800' }}">
                            {{ $practica->estado }}
                        </span>

                        <span class="text-sm text-gray-400">
                            Publicado {{ $practica->created_at->diffForHumans(['parts' => 2]) }}
                        </span>
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            Descripción de la práctica
                        </h2>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $practica->descripcion }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Información de la empresa --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Empresa --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <x-heroicon-o-building-office class="h-6 w-6 text-indigo-600"/>
                    Empresa
                </h3>

                <div class="space-y-2 text-gray-700">
                    <p><strong>Nombre:</strong> {{ $practica->empresa->nombre }}  {{ $practica->empresa->razonSocial->acronimo }}</p>

                    <p>
                        <strong>Ubicación:</strong>
                        {{ $practica->empresa->departamento }},
                        {{ $practica->empresa->provincia }},
                        {{ $practica->empresa->distrito }}
                    </p>
                </div>
            </div>

            {{-- Contacto --}}
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <x-heroicon-o-phone class="h-6 w-6 text-indigo-600"/>
                    Contacto
                </h3>

                <div class="space-y-2 text-gray-700">
                    <p>
                        <strong>Teléfono:</strong>
                        {{ $practica->empresa->telefono ?? 'No disponible' }}
                    </p>

                    <p>
                        <strong>Correo:</strong>
                        {{ $practica->empresa->user->email ?? 'No disponible' }}
                    </p>

                    <p>
                        <strong>Dirección:</strong>
                        {{ $practica->empresa->direccion ?? 'No disponible' }}
                    </p>
                </div>
            </div>

        </div>

        {{-- CTA --}}
        <div class="mt-10 text-center">
            @auth
                @if($alumno)
                    @if($practica->estado === 'Cubierta')
                        {{-- Práctica cubierta --}}
                        <div class="inline-flex items-center gap-2 px-8 py-3 bg-gray-100 text-gray-600 text-lg font-semibold rounded-xl">
                            <x-heroicon-o-x-circle class="h-6 w-6"/>
                            Esta práctica ya está cubierta
                        </div>

                    @elseif(!$alumno->cv)
                        {{-- Sin CV --}}
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 px-8 py-3 bg-yellow-100 text-yellow-800 text-lg font-semibold rounded-xl">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6"/>
                                Debes subir tu CV antes de postular
                            </div>
                            <div>
                                <a href="{{ route('profile.edit') }}"
                                   class="text-indigo-600 hover:text-indigo-800 underline">
                                    Ir a mi perfil para subir CV
                                </a>
                            </div>
                        </div>

                    @elseif($postulacion)
                        {{-- Ya postulado - Mostrar estado --}}
                        @if($postulacion->aprobado === null)
                            {{-- En revisión --}}
                            <div class="inline-flex items-center gap-2 px-8 py-3 bg-blue-100 text-blue-800 text-lg font-semibold rounded-xl">
                                <x-heroicon-o-clock class="h-6 w-6"/>
                                Postulación en revisión
                            </div>
                            <p class="text-gray-600 mt-3">
                                La empresa revisará tu postulación pronto
                            </p>

                        @elseif($postulacion->aprobado === 1)
                            {{-- Aceptada --}}
                            <div class="space-y-4">
                                <div class="inline-flex items-center gap-2 px-8 py-3 bg-green-100 text-green-800 text-lg font-semibold rounded-xl">
                                    <x-heroicon-o-check-circle class="h-6 w-6"/>
                                    ¡Felicitaciones! Tu postulación fue aceptada
                                </div>
                                <p class="text-gray-700 font-medium">
                                    La empresa se pondrá en contacto contigo pronto
                                </p>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 max-w-md mx-auto">
                                    <p class="text-sm text-gray-700">
                                        <strong>Próximos pasos:</strong><br>
                                        Espera el contacto de {{ $practica->empresa->nombre }}
                                        al correo: <strong>{{ $correoAlumno }}</strong>
                                    </p>
                                </div>
                            </div>

                        @else
                            {{-- Rechazada --}}
                            <div class="space-y-4">
                                <div class="inline-flex items-center gap-2 px-8 py-3 bg-red-100 text-red-800 text-lg font-semibold rounded-xl">
                                    <x-heroicon-o-x-circle class="h-6 w-6"/>
                                    Tu postulación no fue seleccionada
                                </div>
                                <p class="text-gray-600">
                                    No te desanimes, sigue buscando otras oportunidades
                                </p>
                                <a href="{{ route('alumno.practicas.index') }}"
                                   class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium">
                                    <x-heroicon-o-magnifying-glass class="h-5 w-5"/>
                                    Ver otras prácticas disponibles
                                </a>
                            </div>
                        @endif

                    @else
                        {{-- Puede postular --}}
                        <form method="POST" action="{{ route('alumno.practicas.postular', $practica) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition transform hover:scale-105">
                                <x-heroicon-o-paper-airplane class="h-6 w-6"/>
                                Postular a esta práctica
                            </button>
                        </form>
                    @endif
                @endif
            @else
                {{-- No autenticado --}}
                <div class="space-y-4">
                    <p class="text-gray-600">
                        Debes iniciar sesión para postular a esta práctica
                    </p>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-lg font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                        Iniciar sesión
                    </a>
                </div>
            @endauth
        </div>

    </div>
</x-app-layout>
