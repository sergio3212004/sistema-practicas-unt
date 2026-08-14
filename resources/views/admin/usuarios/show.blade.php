<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Encabezado -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 rounded-2xl shadow-lg p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">
                            Detalles del Usuario
                        </h1>
                        <p class="text-blue-100 text-sm">
                            Información completa del usuario registrado en el sistema
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            @svg('heroicon-o-user-circle', 'w-12 h-12 text-white')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón volver -->
        <div class="mb-6">
            <a href="{{ route('admin.usuarios.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-800 text-sm font-medium rounded-lg shadow-sm border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:shadow-md transition-all">
                @svg('heroicon-o-arrow-left', 'w-5 h-5')
                Volver al listado
            </a>
        </div>

        <!-- Card: Datos del Usuario -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <div class="bg-blue-600 p-2 rounded-lg">
                    @svg('heroicon-o-key', 'w-6 h-6 text-white')
                </div>
                <h2 class="text-xl font-bold text-gray-800">Datos de Acceso</h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-600">Correo institucional</p>
                    <p class="text-gray-900 font-medium">{{ $usuario->email }}</p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-600">Rol del usuario</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        bg-blue-100 text-blue-800 capitalize">
                        {{ $usuario->rol->nombre }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Card: Perfil -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8">
            <div class="p-6 border-b border-gray-200 flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-lg">
                    @svg('heroicon-o-identification', 'w-6 h-6 text-white')
                </div>
                <h2 class="text-xl font-bold text-gray-800">
                    Información del Perfil
                    <span class="text-sm text-gray-500 font-medium">
                        ({{ ucfirst($usuario->rol->nombre) }})
                    </span>
                </h2>
            </div>

            <div class="p-6 space-y-4 text-sm">

                @if ($usuario->rol->nombre === 'administrador')
                    @include('admin.usuarios.partials.show-administrador')

                @elseif ($usuario->rol->nombre === 'alumno')
                    @include('admin.usuarios.partials.show-alumno')

                @elseif ($usuario->rol->nombre === 'empresa')
                    @include('admin.usuarios.partials.show-empresa')

                @elseif ($usuario->rol->nombre === 'profesor')
                    @include('admin.usuarios.partials.show-profesor')

                @else
                    <p class="text-gray-600">Este rol no tiene un perfil asociado.</p>
                @endif

            </div>
        </div>

        <!-- Acciones -->
        <div class="flex flex-col sm:flex-row justify-end gap-4">
            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow hover:bg-indigo-700 transition">
                @svg('heroicon-o-pencil-square', 'w-5 h-5')
                Editar
            </a>

            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                  method="POST"
                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                @csrf
                @method('DELETE')
                <button
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white font-semibold rounded-xl shadow hover:bg-red-700 transition">
                    @svg('heroicon-o-trash', 'w-5 h-5')
                    Eliminar
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
