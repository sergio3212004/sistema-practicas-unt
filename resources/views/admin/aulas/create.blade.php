<x-app-layout title="Nueva aula">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración académica"
            title="Crear aula"
            description="Define el periodo y el docente responsable. El número del aula se asignará automáticamente dentro del semestre."
            icon="heroicon-o-academic-cap"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.aulas.index') }}" class="ui-btn-secondary">
                    @svg('heroicon-o-arrow-left', 'h-4 w-4') Volver a aulas
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-5xl">
        <x-ui.form-errors />

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
            <form action="{{ route('admin.aulas.store') }}" method="POST" class="ui-card overflow-hidden">
                @csrf

                <div class="ui-card-header">
                    <x-ui.section-heading
                        title="Configuración del aula"
                        description="El semestre es obligatorio; puedes asignar al docente ahora o hacerlo más adelante."
                        icon="heroicon-o-adjustments-horizontal"
                    />
                </div>

                <div class="ui-card-body space-y-6">
                    <div>
                        <label for="semestre_id" class="ui-label">Semestre <span class="text-red-500" aria-hidden="true">*</span></label>
                        <select
                            id="semestre_id"
                            name="semestre_id"
                            class="ui-field"
                            required
                            @error('semestre_id') aria-invalid="true" aria-describedby="semestre-error" @enderror
                        >
                            <option value="">Selecciona un semestre</option>
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" @selected(old('semestre_id') == $semestre->id)>{{ $semestre->nombre }}</option>
                            @endforeach
                        </select>
                        @error('semestre_id')<p id="semestre-error" class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="profesor_id" class="ui-label">Docente responsable <span class="font-normal text-gray-500">(opcional)</span></label>
                        <select
                            id="profesor_id"
                            name="profesor_id"
                            class="ui-field"
                            @error('profesor_id') aria-invalid="true" aria-describedby="profesor-error" @enderror
                        >
                            <option value="">Asignar más adelante</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" @selected(old('profesor_id') == $profesor->id)>
                                    {{ $profesor->nombres }} {{ $profesor->apellido_paterno }} · {{ $profesor->codigo_profesor }}
                                </option>
                            @endforeach
                        </select>
                        <p class="ui-help">El docente podrá gestionar semanas, actividades y entregas de este grupo.</p>
                        @error('profesor_id')<p id="profesor-error" class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('admin.aulas.index') }}" class="ui-btn-secondary">Cancelar</a>
                    <button type="submit" class="ui-btn-primary">
                        @svg('heroicon-o-check', 'h-4 w-4') Crear aula
                    </button>
                </div>
            </form>

            <aside class="ui-card h-fit p-5" aria-labelledby="siguiente-paso-aula">
                <span class="ui-icon-box">@svg('heroicon-o-light-bulb', 'h-5 w-5')</span>
                <h2 id="siguiente-paso-aula" class="mt-4 font-bold text-gray-950">¿Qué ocurre después?</h2>
                <ol class="mt-3 space-y-3 text-sm leading-6 text-gray-600">
                    <li><strong class="text-gray-900">1.</strong> El sistema asigna el siguiente número disponible.</li>
                    <li><strong class="text-gray-900">2.</strong> Podrás incorporar estudiantes desde el detalle del aula.</li>
                    <li><strong class="text-gray-900">3.</strong> El docente verá el grupo en su espacio académico.</li>
                </ol>
            </aside>
        </div>
    </div>

    @if($errors->any())
        @push('scripts')<script>document.getElementById('resumen-errores')?.focus();</script>@endpush
    @endif
</x-app-layout>
