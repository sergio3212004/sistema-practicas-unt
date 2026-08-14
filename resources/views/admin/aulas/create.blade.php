<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-xl mt-10 mb-16">

        <!-- Título -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Crear Aula</h1>
            <a href="{{ route('admin.aulas.index') }}"
               class="text-indigo-600 hover:text-indigo-900 text-sm">
                &larr; Volver al listado
            </a>
        </div>

        <!-- Formulario -->
        <form action="{{ route('admin.aulas.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Semestre -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Semestre</label>
                <select name="semestre_id"
                        class="mt-1 w-full max-w-sm p-2 border border-gray-300 rounded-md shadow-sm mx-auto block"
                        required>
                    <option value="">Seleccione un semestre</option>
                    @foreach ($semestres as $semestre)
                        <option value="{{ $semestre->id }}">
                            {{ $semestre->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('semestre_id')
                <p class="text-sm text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profesor -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Profesor</label>
                <select name="profesor_id"
                        class="mt-1 w-full max-w-sm p-2 border border-gray-300 rounded-md shadow-sm mx-auto block">
                    <option value="">Sin profesor asignado</option>
                    @foreach ($profesores as $profesor)
                        <option value="{{ $profesor->id }}">
                            {{ $profesor->nombres }} {{ $profesor->apellido_paterno }}
                        </option>
                    @endforeach
                </select>
                @error('profesor_id')
                <p class="text-sm text-red-600 text-center">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-center gap-4 pt-4">
                <button
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                    Guardar
                </button>

                <a href="{{ route('admin.aulas.index') }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</x-app-layout>
