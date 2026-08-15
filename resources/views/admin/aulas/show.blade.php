<x-app-layout :title="'Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración académica"
            :title="'Aula '.$aula->numero"
            description="Consulta la configuración del grupo y administra sus estudiantes."
            icon="heroicon-o-academic-cap"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aulas.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Aulas</a>
                <a href="{{ route('admin.aulas.edit', $aula) }}" class="ui-btn-primary">@svg('heroicon-o-pencil-square', 'h-4 w-4') Editar aula</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat-card label="Semestre" :value="$aula->semestre?->nombre ?? 'Sin asignar'" description="Periodo académico" icon="heroicon-o-calendar-days" />
            <x-ui.stat-card label="Docente" :value="$aula->profesor?->nombres ?? 'Pendiente'" :description="$aula->profesor?->codigo_profesor ? 'Código '.$aula->profesor->codigo_profesor : 'Asigna un responsable'" icon="heroicon-o-user-circle" :tone="$aula->profesor ? 'success' : 'warning'" />
            <x-ui.stat-card label="Estudiantes" :value="$aula->alumnos->count()" description="Actualmente inscritos" icon="heroicon-o-user-group" />
        </div>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Estudiantes inscritos"
                    :description="$aula->alumnos->count().' estudiantes pertenecen actualmente a este grupo.'"
                    icon="heroicon-o-users"
                >
                    <x-slot name="actions">
                        <a href="{{ route('admin.aulas.agregar-alumnos', $aula) }}" class="ui-btn-primary">
                            @svg('heroicon-o-user-plus', 'h-4 w-4') Agregar estudiantes
                        </a>
                    </x-slot>
                </x-ui.section-heading>
            </div>

            @if($aula->alumnos->isEmpty())
                <div class="p-5 sm:p-6">
                    <x-ui.empty-state
                        title="El aula todavía no tiene estudiantes"
                        description="Agrega estudiantes disponibles para que puedan acceder a las semanas y actividades de este grupo."
                        icon="heroicon-o-user-plus"
                    >
                        <x-slot name="actions"><a href="{{ route('admin.aulas.agregar-alumnos', $aula) }}" class="ui-btn-primary">Agregar estudiantes</a></x-slot>
                    </x-ui.empty-state>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <caption class="sr-only">Estudiantes inscritos en el aula {{ $aula->numero }}</caption>
                        <thead>
                            <tr>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Código</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col" class="text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aula->alumnos as $alumno)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td><span class="font-semibold text-gray-900">{{ $alumno->nombre_completo }}</span></td>
                                    <td><span class="font-medium text-gray-700">{{ $alumno->codigo_matricula }}</span></td>
                                    <td>{{ $alumno->telefono ?: 'No registrado' }}</td>
                                    <td>
                                        <form action="{{ route('admin.aulas.quitar-alumno', [$aula, $alumno]) }}" method="POST" class="flex justify-end" @submit="if (!confirm('¿Quitar a este estudiante del aula?')) $event.preventDefault()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn-ghost text-red-700 hover:bg-red-50 hover:text-red-800">
                                                @svg('heroicon-o-user-minus', 'h-4 w-4') Quitar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
