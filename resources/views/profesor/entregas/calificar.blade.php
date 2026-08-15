<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">

        <h1 class="text-2xl font-bold mb-4">
            📄 {{ $entrega->titulo }}
        </h1>

        <p class="text-gray-600 mb-6">
            Alumno: <strong>{{ $entregaAlumno->alumno->nombre_completo }}</strong>
        </p>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">

            <div>
                <p class="font-semibold text-sm">Entrega del alumno</p>
                <p>
                    <a href="{{ $entregaAlumno->link_entrega }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="text-blue-600 underline">
                        Ver archivo o enlace <span class="sr-only">(se abre en una pestaña nueva)</span>
                    </a>
                </p>
            </div>

            <div>
                <p class="font-semibold text-sm">Fecha de entrega</p>
                <p class="text-gray-500">
                    {{ $entregaAlumno->fecha_subida->format('d/m/Y H:i') }}
                </p>
            </div>

            <form method="POST"
                  action="{{ route('profesor.entregas.guardar-calificacion', [$entrega->id, $entregaAlumno->alumno_id]) }}"
                  class="space-y-4">
                @csrf

                <div>
                    <label for="nota" class="font-semibold text-sm">Nota (0–20)</label>
                    <input type="number"
                           id="nota"
                           name="nota"
                           @error('nota') aria-invalid="true" aria-describedby="nota-error" @enderror
                           value="{{ old('nota', $entregaAlumno->nota) }}"
                           min="0"
                           max="20"
                           required
                           class="w-24 border rounded px-2 py-1">
                    @error('nota')<p id="nota-error" class="mt-1 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="comentario_profesor" class="font-semibold text-sm">Comentario (opcional)</label>
                    <textarea id="comentario_profesor"
                              name="comentario_profesor"
                              rows="3"
                              class="w-full border rounded px-2 py-1"
                              placeholder="Comentario para el alumno...">{{ old('comentario_profesor', $entregaAlumno->comentario_profesor) }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                        Guardar calificación
                    </button>

                    <a href="{{ route('profesor.entregas.show', $entrega->id) }}"
                       class="bg-gray-300 px-4 py-2 rounded">
                        Volver
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
