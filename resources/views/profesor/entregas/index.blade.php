<x-app-layout>
    <div class="container mx-auto px-4 py-8">

        <h2 class="text-2xl font-bold mb-6">📦 Entregas por Semana</h2>

        @forelse($entregas as $entrega)
            @php
                preg_match('/Semana (\d+)/', $entrega->titulo, $match);
                $semana = $match[1] ?? '—';
                $totalAlumnos = $entrega->aula->alumnos->count();
                $entregados = $entrega->entregas_alumnos->count();
            @endphp

            <a href="{{ route('profesor.entregas.show', $entrega) }}"
               class="block bg-white border rounded-lg shadow hover:shadow-lg transition p-4 mb-4">

                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">
                        📅 Semana {{ $semana }}
                    </h3>

                    <span class="text-sm text-gray-600">
                        {{ $entregados }} / {{ $totalAlumnos }} entregados
                    </span>
                </div>

                <p class="text-sm text-gray-600 mt-1">
                    {{ $entrega->titulo }}
                </p>

                <p class="text-sm text-gray-500">
                    ⏰ Límite: {{ $entrega->fecha_fin->format('d/m/Y') }}
                </p>
            </a>
        @empty
            <p class="text-gray-500">
                No hay entregas creadas aún.
            </p>
        @endforelse

    </div>
</x-app-layout>
