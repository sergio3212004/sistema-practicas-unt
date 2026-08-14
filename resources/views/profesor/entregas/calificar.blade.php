<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">

        <h2 class="text-2xl font-bold mb-4">
            📄 {{ $entrega->titulo }}
        </h2>

        <p class="text-gray-600 mb-6">
            Alumno: <strong>{{ $entregaAlumno->alumno->nombre_completo }}</strong>
        </p>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">

            <div>
                <label class="font-semibold text-sm">Entrega del alumno</label>
                <p>
                    <a href="{{ $entregaAlumno->link_entrega }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        Ver archivo / enlace
                    </a>
                </p>
            </div>

            <div>
                <label class="font-semibold text-sm">Fecha de entrega</label>
                <p class="text-gray-500">
                    {{ $entregaAlumno->fecha_subida->format('d/m/Y H:i') }}
                </p>
            </div>

            <form method="POST"
                  action="{{ route('profesor.entregas.guardar-calificacion', [$entrega->id, $entregaAlumno->alumno_id]) }}"
                  class="space-y-4">
                @csrf

                <div>
                    <label class="font-semibold text-sm">Nota (0–20)</label>
                    <input type="number"
                           name="nota"
                           value="{{ old('nota', $entregaAlumno->nota) }}"
                           min="0"
                           max="20"
                           required
                           class="w-24 border rounded px-2 py-1">
                </div>

                <div>
                    <label class="font-semibold text-sm">Comentario (opcional)</label>
                    <textarea name="comentario_profesor"
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
