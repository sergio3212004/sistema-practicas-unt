<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md">

        {{-- Encabezado --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Aula N° {{ $aula->numero }}
            </h1>

            <a href="{{ route('admin.aulas.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                ← Volver
            </a>
        </div>

        {{-- Información del Aula --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg shadow-sm">
                <h2 class="font-semibold text-blue-700 mb-1">Semestre</h2>
                <p class="text-gray-800">
                    {{ $aula->semestre ? $aula->semestre->nombre : 'No asignado' }}
                </p>
            </div>

            <div class="p-4 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                <h2 class="font-semibold text-green-700 mb-1">Profesor</h2>
                <p class="text-gray-800">
                    {{ $aula->profesor ? $aula->profesor->nombres . ' ' . $aula->profesor->apellido_paterno : 'Sin profesor asignado' }}
                </p>
            </div>

            <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm">
                <h2 class="font-semibold text-indigo-700 mb-1">Número de Aula</h2>
                <p class="text-gray-800 font-bold">
                    {{ $aula->numero }}
                </p>
            </div>

        </div>

        {{-- Alumnos inscritos --}}
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Alumnos Inscritos</h2>

            <a href="{{ route('admin.aulas.agregar-alumnos', $aula->id) }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow">
                + Agregar Alumnos
            </a>
        </div>

        @if ($aula->alumnos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border rounded-lg shadow">
                    <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Código</th>
                        <th class="px-4 py-2 text-left text-gray-700">Nombre Completo</th>
                        <th class="px-4 py-2 text-left text-gray-700">Teléfono</th>
                        <th class="px-4 py-2 text-center text-gray-700">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($aula->alumnos as $alumno)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $alumno->codigo_matricula }}</td>
                            <td class="px-4 py-2">{{ $alumno->nombre_completo }}</td>
                            <td class="px-4 py-2">{{ $alumno->telefono }}</td>

                            <td class="px-4 py-2 text-center">
                                {{-- Botón quitar alumno --}}
                                <form action="{{ route('admin.aulas.quitar-alumno', [$aula->id, $alumno->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas quitar a este alumno del aula?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 shadow-sm">
                                        Quitar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600 text-center py-6">Este aula aún no tiene alumnos inscritos.</p>
        @endif

    </div>
</x-app-layout>
