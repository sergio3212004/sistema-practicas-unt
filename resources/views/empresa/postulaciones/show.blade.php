<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <x-heroicon-o-users class="h-8 w-8 text-indigo-600"/>
                        Postulaciones Recibidas
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Práctica: <span class="font-semibold text-gray-900">{{ $publicacion->nombre }}</span>
                    </p>
                </div>

                <a href="{{ route('empresa.postulaciones.show', $publicacion) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    <x-heroicon-o-arrow-left class="h-5 w-5"/>
                    Volver
                </a>
            </div>

            {{-- Stats Cards --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Total</p>
                            <p class="text-2xl font-bold text-blue-900">{{ $postulaciones->count() }}</p>
                        </div>
                        <x-heroicon-o-document-text class="h-10 w-10 text-blue-400"/>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Aprobadas</p>
                            <p class="text-2xl font-bold text-green-900">{{ $postulaciones->where('aprobado', true)->count() }}</p>
                        </div>
                        <x-heroicon-o-check-circle class="h-10 w-10 text-green-400"/>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-4 border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-yellow-600">Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-900">{{ $postulaciones->whereNull('aprobado')->count() }}</p>
                        </div>
                        <x-heroicon-o-clock class="h-10 w-10 text-yellow-400"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alertas --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <x-heroicon-o-check-circle class="h-5 w-5 text-green-500 mr-3"/>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <x-heroicon-o-information-circle class="h-5 w-5 text-blue-500 mr-3"/>
                    <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <x-heroicon-o-exclamation-triangle class="h-5 w-5 text-yellow-500 mr-3"/>
                    <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
                </div>
            </div>
        @endif

        {{-- Tabla de Postulaciones --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            @if($postulaciones->isEmpty())
                <div class="text-center py-16 px-4">
                    <x-heroicon-o-inbox class="h-16 w-16 text-gray-300 mx-auto mb-4"/>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay postulaciones</h3>
                    <p class="text-gray-500">Aún no se han recibido postulaciones para esta práctica.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-50 to-blue-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Candidato
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Información de Contacto
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Documentación
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($postulaciones as $postulacion)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                {{-- Candidato --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($postulacion->alumno->user->nombre, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $postulacion->alumno->user->nombre }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Postulado {{ $postulacion->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Contacto --}}
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-sm text-gray-700">
                                            <x-heroicon-o-envelope class="h-4 w-4 text-gray-400 mr-2"/>
                                            {{ $postulacion->alumno->user->email }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-700">
                                            <x-heroicon-o-phone class="h-4 w-4 text-gray-400 mr-2"/>
                                            {{ $postulacion->alumno->telefono ?? 'No disponible' }}
                                        </div>
                                    </div>
                                </td>

                                {{-- CV --}}
                                <td class="px-6 py-4 text-center">
                                    @if($postulacion->alumno->cv)
                                        <a href="{{ $postulacion->alumno->cv }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition font-medium text-sm">
                                            <x-heroicon-o-document-text class="h-5 w-5"/>
                                            Ver CV
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">No disponible</span>
                                    @endif
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 text-center">
                                    @if($postulacion->aprobado === true)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                                <x-heroicon-o-check-circle class="h-4 w-4"/>
                                                Aprobado
                                            </span>
                                    @elseif($postulacion->aprobado === false)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                                <x-heroicon-o-x-circle class="h-4 w-4"/>
                                                Rechazado
                                            </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                <x-heroicon-o-clock class="h-4 w-4"/>
                                                Pendiente
                                            </span>
                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4 text-center">
                                    @if(is_null($postulacion->aprobado))
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Aprobar --}}
                                            <form method="POST"
                                                  action="{{ route('empresa.postulaciones.aprobar', $postulacion) }}"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('¿Estás seguro de aprobar esta postulación?')"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm shadow-sm">
                                                    <x-heroicon-o-check class="h-4 w-4"/>
                                                    Aprobar
                                                </button>
                                            </form>

                                            {{-- Rechazar --}}
                                            <form method="POST"
                                                  action="{{ route('empresa.postulaciones.rechazar', $postulacion) }}"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="return confirm('¿Estás seguro de rechazar esta postulación?')"
                                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-sm shadow-sm">
                                                    <x-heroicon-o-x-mark class="h-4 w-4"/>
                                                    Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Procesado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Paginación (si aplica) --}}
        @if($postulaciones->hasPages())
            <div class="mt-6">
                {{ $postulaciones->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
