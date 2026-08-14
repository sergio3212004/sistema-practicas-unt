<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">

        <h2 class="mb-6 text-2xl font-bold text-gray-800">Editar Aula</h2>

        <form action="{{ route('admin.aulas.update', $aula) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Número del aula --}}
            <div class="mb-5">
                <label class="block mb-1 font-semibold text-gray-700">Número del Aula</label>
                <input type="number" name="numero"
                       class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200"
                       value="{{ old('numero', $aula->numero) }}" required>

                @error('numero')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Semestre --}}
            <div class="mb-5">
                <label class="block mb-1 font-semibold text-gray-700">Semestre</label>
                <select name="semestre_id"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200"
                        required>
                    <option value="">Seleccione un semestre</option>

                    @foreach ($semestres as $semestre)
                        <option value="{{ $semestre->id }}"
                            {{ $semestre->id == old('semestre_id', $aula->semestre_id) ? 'selected' : '' }}>
                            {{ $semestre->nombre }}
                        </option>
                    @endforeach
                </select>

                @error('semestre_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Profesor --}}
            <div class="mb-6">
                <label class="block mb-1 font-semibold text-gray-700">Profesor</label>
                <select name="profesor_id"
                        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-200">
                    <option value="">Sin profesor asignado</option>

                    @foreach ($profesores as $profesor)
                        <option value="{{ $profesor->id }}"
                            {{ $profesor->id == old('profesor_id', $aula->profesor_id) ? 'selected' : '' }}>
                            {{ $profesor->nombres }} {{ $profesor->apellido_paterno }}
                        </option>
                    @endforeach
                </select>

                @error('profesor_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="mt-6 p-4 bg-gray-100 rounded-lg flex items-center gap-3">
                <button class="px-5 py-2 text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">
                    Actualizar Aula
                </button>

                <a href="{{ route('admin.aulas.index') }}"
                   class="px-5 py-2 text-gray-700 bg-gray-300 rounded-lg hover:bg-gray-400">
                    Cancelar
                </a>
            </div>
        </form>

    </div>
</x-app-layout>
