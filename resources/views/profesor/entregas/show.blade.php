<x-app-layout>
    <div class="container mx-auto px-4 py-8">

        <h2 class="text-2xl font-bold mb-4">
            📅 {{ $entrega->titulo }}
        </h2>

        <p class="text-gray-600 mb-6">
            Aula #{{ $entrega->aula->numero }} —
            Fecha límite: {{ $entrega->fecha_fin->format('d/m/Y') }}
        </p>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Alumno</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Entrega</th>
                    <th class="px-4 py-2">Fecha</th>
                    <th class="px-4 py-2">Nota</th>
                    <th class="px-4 py-2">Acción</th>
                </tr>
                </thead>

                <tbody>
                @foreach($entrega->aula->alumnos as $alumno)

                    @php
                        $entregaAlumno = $entrega->entregas_alumnos
                            ->firstWhere('alumno_id', $alumno->id);
                    @endphp

                    <tr class="border-t">
                        <!-- Alumno -->
                        <td class="px-4 py-2 font-medium">
                            {{ $alumno->nombre_completo }}
                        </td>

                        <!-- Estado -->
                        <td class="px-4 py-2">
                            @if($entregaAlumno)
                                <span class="text-green-600 font-semibold">Entregado</span>
                            @else
                                <span class="text-red-600 font-semibold">No entregó</span>
                            @endif
                        </td>

                        <!-- Enlace -->
                        <td class="px-4 py-2">
                            @if($entregaAlumno)
                                <a href="{{ $entregaAlumno->link_entrega }}"
                                   target="_blank"
                                   class="text-blue-600 underline">
                                    Ver entrega
                                </a>
                            @else
                                —
                            @endif
                        </td>

                        <!-- Fecha -->
                        <td class="px-4 py-2 text-gray-500">
                            {{ $entregaAlumno?->fecha_subida?->format('d/m/Y H:i') ?? '—' }}
                        </td>

                        <!-- Nota -->
                        <td class="px-4 py-2">
                            {{ $entregaAlumno?->nota ?? '—' }}
                        </td>

                        <!-- Acción -->
                        <td class="px-4 py-2">
                            @if($entregaAlumno)
                                <a href="{{ route('profesor.entregas.ver-alumno', [$entrega->id, $alumno->id]) }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                    Ver / Calificar
                                </a>
                            @else
                                —
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
