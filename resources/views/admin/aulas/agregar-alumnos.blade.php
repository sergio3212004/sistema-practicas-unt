<x-app-layout :title="'Agregar estudiantes · Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración académica"
            :title="'Agregar estudiantes al aula '.$aula->numero"
            description="Selecciona una o varias cuentas disponibles y asígnalas al grupo en una sola operación."
            icon="heroicon-o-user-plus"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aulas.show', $aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">
        <x-ui.form-errors />

        @if($alumnos->isEmpty())
            <x-ui.empty-state
                title="No hay estudiantes disponibles"
                description="Todos los estudiantes ya pertenecen a un aula. Puedes volver al grupo o revisar el directorio de usuarios."
                icon="heroicon-o-user-group"
            >
                <x-slot name="actions">
                    <a href="{{ route('admin.aulas.show', $aula) }}" class="ui-btn-secondary">Volver al aula</a>
                    <a href="{{ route('admin.usuarios.index') }}" class="ui-btn-primary">Revisar usuarios</a>
                </x-slot>
            </x-ui.empty-state>
        @else
            <form
                action="{{ route('admin.aulas.asignar-alumnos', $aula) }}"
                method="POST"
                class="ui-card overflow-hidden"
                x-data="{ selected: @js(old('alumnos', [])) }"
            >
                @csrf

                <div class="ui-card-header">
                    <x-ui.section-heading
                        title="Estudiantes disponibles"
                        :description="$alumnos->count().' cuentas todavía no tienen un aula asignada.'"
                        icon="heroicon-o-users"
                    >
                        <x-slot name="actions">
                            <span class="ui-badge-info"><span x-text="selected.length">0</span> seleccionados</span>
                        </x-slot>
                    </x-ui.section-heading>
                </div>

                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <caption class="sr-only">Estudiantes disponibles para asignar al aula {{ $aula->numero }}</caption>
                        <thead>
                            <tr>
                                <th scope="col" class="w-14">
                                    <input
                                        type="checkbox"
                                        class="rounded border-gray-300 text-blue-700 focus:ring-blue-500"
                                        aria-label="Seleccionar todos los estudiantes"
                                        :checked="selected.length === {{ $alumnos->count() }}"
                                        @change="selected = $event.target.checked ? @js($alumnos->pluck('id')->values()) : []"
                                    >
                                </th>
                                <th scope="col">Estudiante</th>
                                <th scope="col">Código</th>
                                <th scope="col">Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $alumno)
                                <tr class="transition hover:bg-blue-50/40">
                                    <td>
                                        <input
                                            type="checkbox"
                                            name="alumnos[]"
                                            value="{{ $alumno->id }}"
                                            x-model.number="selected"
                                            class="rounded border-gray-300 text-blue-700 focus:ring-blue-500"
                                            aria-label="Seleccionar a {{ $alumno->nombre_completo }}"
                                        >
                                    </td>
                                    <td><span class="font-semibold text-gray-900">{{ $alumno->nombre_completo }}</span></td>
                                    <td>{{ $alumno->codigo_matricula }}</td>
                                    <td>{{ $alumno->telefono ?: 'No registrado' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p class="text-sm text-gray-600">Solo se mostrarán estudiantes que aún no pertenecen a otro grupo.</p>
                    <button type="submit" class="ui-btn-primary" :disabled="selected.length === 0">
                        @svg('heroicon-o-check', 'h-4 w-4') Asignar seleccionados
                    </button>
                </div>
            </form>
        @endif
    </div>
</x-app-layout>
