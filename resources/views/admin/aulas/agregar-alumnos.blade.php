<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">

        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Agregar alumnos al Aula N° {{ $aula->numero }}
        </h1>

        <a href="{{ route('admin.aulas.show', $aula->id) }}"
           class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
            ← Volver
        </a>

        @if (session('success'))
            <div class="p-3 mb-4 text-green-800 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($alumnos->count() === 0)

            <p class="text-gray-600">No hay alumnos disponibles para asignar.</p>

        @else

            <form action="{{ route('admin.aulas.asignar-alumnos', $aula->id) }}" method="POST">
                @csrf

                <table class="min-w-full bg-white border rounded-lg shadow mb-4">
                    <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2"></th>
                        <th class="px-4 py-2 text-left text-gray-700">Código</th>
                        <th class="px-4 py-2 text-left text-gray-700">Nombre Completo</th>
                        <th class="px-4 py-2 text-left text-gray-700">Teléfono</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($alumnos as $alumno)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">
                                <input type="checkbox" name="alumnos[]" value="{{ $alumno->id }}">
                            </td>
                            <td class="px-4 py-2">{{ $alumno->codigo_matricula }}</td>
                            <td class="px-4 py-2">{{ $alumno->nombre_completo }}</td>
                            <td class="px-4 py-2">{{ $alumno->telefono }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @error('alumnos')
                <p class="text-sm text-red-600 mb-2">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 shadow">
                    Asignar seleccionados
                </button>

            </form>

        @endif

    </div>
</x-app-layout>
