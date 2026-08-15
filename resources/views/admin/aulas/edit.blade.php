<x-app-layout :title="'Editar aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración académica"
            :title="'Editar aula '.$aula->numero"
            description="Actualiza la identificación, el periodo o el docente responsable del grupo."
            icon="heroicon-o-pencil-square"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aulas.show', $aula) }}" class="ui-btn-secondary">
                    @svg('heroicon-o-eye', 'h-4 w-4') Ver aula
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-3xl">
        <x-ui.form-errors />

        <form action="{{ route('admin.aulas.update', $aula) }}" method="POST" class="ui-card overflow-hidden">
            @csrf
            @method('PUT')

            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Datos del aula"
                    description="Los cambios se reflejarán también en el espacio del docente y de sus estudiantes."
                    icon="heroicon-o-adjustments-horizontal"
                />
            </div>

            <div class="ui-card-body grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="numero" class="ui-label">Número del aula <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input
                        id="numero"
                        type="number"
                        name="numero"
                        min="1"
                        value="{{ old('numero', $aula->numero) }}"
                        class="ui-field"
                        required
                        @error('numero') aria-invalid="true" aria-describedby="numero-error" @enderror
                    >
                    @error('numero')<p id="numero-error" class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="semestre_id" class="ui-label">Semestre <span class="text-red-500" aria-hidden="true">*</span></label>
                    <select id="semestre_id" name="semestre_id" class="ui-field" required @error('semestre_id') aria-invalid="true" aria-describedby="semestre-error" @enderror>
                        <option value="">Selecciona un semestre</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}" @selected(old('semestre_id', $aula->semestre_id) == $semestre->id)>{{ $semestre->nombre }}</option>
                        @endforeach
                    </select>
                    @error('semestre_id')<p id="semestre-error" class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="profesor_id" class="ui-label">Docente responsable <span class="font-normal text-gray-500">(opcional)</span></label>
                    <select id="profesor_id" name="profesor_id" class="ui-field" @error('profesor_id') aria-invalid="true" aria-describedby="profesor-error" @enderror>
                        <option value="">Sin docente asignado</option>
                        @foreach($profesores as $profesor)
                            <option value="{{ $profesor->id }}" @selected(old('profesor_id', $aula->profesor_id) == $profesor->id)>
                                {{ $profesor->nombres }} {{ $profesor->apellido_paterno }} · {{ $profesor->codigo_profesor }}
                            </option>
                        @endforeach
                    </select>
                    @error('profesor_id')<p id="profesor-error" class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <a href="{{ route('admin.aulas.show', $aula) }}" class="ui-btn-secondary">Cancelar</a>
                <button type="submit" class="ui-btn-primary">
                    @svg('heroicon-o-check', 'h-4 w-4') Guardar cambios
                </button>
            </div>
        </form>
    </div>

    @if($errors->any())
        @push('scripts')<script>document.getElementById('resumen-errores')?.focus();</script>@endpush
    @endif
</x-app-layout>
