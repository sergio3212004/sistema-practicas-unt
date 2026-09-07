@php
    $requestedWeekId = old('semana_id', request('semana'));
    $selectedWeekId = $semanas->contains(fn ($semana) => (string) $semana->id === (string) $requestedWeekId)
        ? $requestedWeekId
        : $semanas->last()?->id;
    $weekMode = old('semana_mode', $semanas->isEmpty() ? 'new' : 'existing');
@endphp

<x-app-layout :title="'Crear tarea · Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Trabajo del aula" :title="'Crear tarea · Aula '.$aula->numero" :description="($aula->semestre?->nombre ?? 'Sin semestre').' · publica las indicaciones y el plazo en un solo paso.'" icon="heroicon-o-clipboard-document-list">
            <x-slot name="actions">
                <a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">
                    @svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-4xl">
        <x-ui.form-errors />

        <form
            action="{{ route('profesor.actividades.store', $aula) }}"
            method="POST"
            class="ui-card overflow-hidden"
            x-data="{ weekMode: @js($weekMode) }"
        >
            @csrf

            <div class="ui-card-header">
                <x-ui.section-heading title="¿Qué deben realizar?" description="Incluye lo esencial para que tus estudiantes entiendan la tarea sin dudas." icon="heroicon-o-pencil-square" />
            </div>

            <div class="ui-card-body space-y-5">
                <div>
                    <label for="titulo" class="ui-label">Título de la tarea <span class="text-red-600" aria-hidden="true">*</span></label>
                    <input id="titulo" name="titulo" type="text" value="{{ old('titulo') }}" class="ui-field" placeholder="Ej. Informe de actividades de la empresa" autocomplete="off" required autofocus>
                </div>

                <div>
                    <label for="descripcion" class="ui-label">Indicaciones <span class="text-xs font-normal text-gray-500">(opcional)</span></label>
                    <textarea id="descripcion" name="descripcion" rows="5" class="ui-field" placeholder="Describe el objetivo, los pasos y lo que esperas recibir...">{{ old('descripcion') }}</textarea>
                    <p class="mt-1.5 text-xs text-gray-500">Procura indicar el entregable esperado y cualquier criterio importante.</p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="tipo_actividad_id" class="ui-label">Tipo de entrega <span class="text-red-600" aria-hidden="true">*</span></label>
                        <select id="tipo_actividad_id" name="tipo_actividad_id" class="ui-field" required>
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposActividad as $tipo)
                                <option value="{{ $tipo->id }}" @selected(old('tipo_actividad_id') == $tipo->id)>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                        <div class="flex items-start gap-3">
                            <span class="ui-icon-box shrink-0">@svg('heroicon-o-light-bulb', 'h-5 w-5')</span>
                            <div>
                                <p class="text-sm font-semibold text-blue-950">Un formulario, un solo guardado</p>
                                <p class="mt-1 text-xs leading-5 text-blue-800">La organización por semanas se resuelve aquí; no necesitas salir a crearla primero.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 bg-gray-50/70">
                <div class="ui-card-header">
                    <x-ui.section-heading title="Plazo de entrega" description="Precompletamos un plazo de siete días; puedes ajustarlo antes de publicar." icon="heroicon-o-clock" />
                </div>
                <div class="grid gap-5 px-5 pb-6 sm:grid-cols-2 sm:px-6">
                    <div>
                        <label for="fecha_inicio" class="ui-label">Disponible desde <span class="text-red-600" aria-hidden="true">*</span></label>
                        <input id="fecha_inicio" name="fecha_inicio" type="datetime-local" value="{{ old('fecha_inicio', $fechaInicioSugerida) }}" class="ui-field" required>
                    </div>
                    <div>
                        <label for="fecha_limite" class="ui-label">Fecha límite <span class="text-red-600" aria-hidden="true">*</span></label>
                        <input id="fecha_limite" name="fecha_limite" type="datetime-local" value="{{ old('fecha_limite', $fechaLimiteSugerida) }}" class="ui-field" required>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200">
                <div class="ui-card-header">
                    <x-ui.section-heading title="Organización" description="Elige una semana existente o deja que el sistema cree la siguiente al guardar." icon="heroicon-o-calendar-days" />
                </div>

                <div class="px-5 pb-6 sm:px-6">
                    @if($semanas->isEmpty())
                        <input type="hidden" name="semana_mode" value="new">
                        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 sm:p-5">
                            <div class="flex items-start gap-3">
                                <span class="ui-icon-box shrink-0">@svg('heroicon-o-sparkles', 'h-5 w-5')</span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-blue-950">Crearemos automáticamente la semana {{ $siguienteNumero }}</p>
                                    <p class="mt-1 text-sm leading-6 text-blue-800">Esta aula todavía no tiene semanas. Al crear la tarea, ambos elementos quedarán listos en el mismo paso.</p>
                                    <details class="mt-3">
                                        <summary class="cursor-pointer text-sm font-semibold text-blue-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-700">Añadir un nombre a la semana (opcional)</summary>
                                        <div class="mt-3 max-w-lg">
                                            <label for="nueva_semana_nombre" class="ui-label">Nombre de la semana</label>
                                            <input id="nueva_semana_nombre" name="nueva_semana_nombre" type="text" value="{{ old('nueva_semana_nombre') }}" class="ui-field bg-white" placeholder="Ej. Inicio de prácticas">
                                        </div>
                                    </details>
                                </div>
                            </div>
                        </div>
                    @else
                        <fieldset>
                            <legend class="sr-only">Cómo organizar la tarea</legend>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <label
                                    class="cursor-pointer rounded-xl border p-4 transition-colors focus-within:ring-2 focus-within:ring-blue-700 focus-within:ring-offset-2"
                                    :class="weekMode === 'existing' ? 'border-blue-700 bg-blue-50' : 'border-gray-200 bg-white hover:border-gray-300'"
                                >
                                    <span class="flex items-start gap-3">
                                        <input type="radio" name="semana_mode" value="existing" x-model="weekMode" class="mt-1 border-gray-300 text-blue-800 focus:ring-blue-700">
                                        <span><span class="block text-sm font-semibold text-gray-950">Usar una semana existente</span><span class="mt-1 block text-xs leading-5 text-gray-600">Ideal para continuar la planificación actual.</span></span>
                                    </span>
                                </label>
                                <label
                                    class="cursor-pointer rounded-xl border p-4 transition-colors focus-within:ring-2 focus-within:ring-blue-700 focus-within:ring-offset-2"
                                    :class="weekMode === 'new' ? 'border-blue-700 bg-blue-50' : 'border-gray-200 bg-white hover:border-gray-300'"
                                >
                                    <span class="flex items-start gap-3">
                                        <input type="radio" name="semana_mode" value="new" x-model="weekMode" class="mt-1 border-gray-300 text-blue-800 focus:ring-blue-700">
                                        <span><span class="block text-sm font-semibold text-gray-950">Crear la siguiente semana</span><span class="mt-1 block text-xs leading-5 text-gray-600">Se generará la semana {{ $siguienteNumero }} al guardar.</span></span>
                                    </span>
                                </label>
                            </div>

                            <div class="mt-4 max-w-xl" x-show="weekMode === 'existing'" x-cloak>
                                <label for="semana_id" class="ui-label">Semana <span class="text-red-600" aria-hidden="true">*</span></label>
                                <select id="semana_id" name="semana_id" class="ui-field" :disabled="weekMode !== 'existing'" :required="weekMode === 'existing'">
                                    @foreach($semanas as $semana)
                                        <option value="{{ $semana->id }}" @selected((string) $selectedWeekId === (string) $semana->id)>Semana {{ $semana->numero }}{{ $semana->nombre ? ' · '.$semana->nombre : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4 max-w-xl" x-show="weekMode === 'new'" x-cloak>
                                <label for="nueva_semana_nombre" class="ui-label">Nombre de la nueva semana <span class="text-xs font-normal text-gray-500">(opcional)</span></label>
                                <input id="nueva_semana_nombre" name="nueva_semana_nombre" type="text" value="{{ old('nueva_semana_nombre') }}" class="ui-field" placeholder="Ej. Seguimiento intermedio" :disabled="weekMode !== 'new'">
                                <p class="mt-1.5 text-xs text-gray-500">El número {{ $siguienteNumero }} se asignará automáticamente.</p>
                            </div>
                        </fieldset>
                    @endif
                </div>
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <p class="text-xs text-gray-500">Podrás revisar las entregas desde la planificación del aula.</p>
                <div class="flex flex-col-reverse gap-2 sm:flex-row">
                    <a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">Cancelar</a>
                    <button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Crear tarea</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
