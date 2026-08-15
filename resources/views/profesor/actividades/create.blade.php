<x-app-layout :title="'Nueva actividad · Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Planificación académica" :title="'Nueva actividad · Aula '.$aula->numero" :description="($aula->semestre?->nombre ?? 'Sin semestre').' · define instrucciones y plazo de entrega.'" icon="heroicon-o-clipboard-document-list">
            <x-slot name="actions"><a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula</a></x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-4xl">
        <x-ui.form-errors />
        @if($semanas->isEmpty())
            <x-ui.empty-state title="Primero crea una semana" description="Cada actividad debe pertenecer a una semana de planificación." icon="heroicon-o-calendar-days">
                <x-slot name="actions"><a href="{{ route('profesor.semanas.create', $aula) }}" class="ui-btn-primary">Crear semana</a></x-slot>
            </x-ui.empty-state>
        @else
            <form action="{{ route('profesor.actividades.store', $aula) }}" method="POST" class="ui-card overflow-hidden">
                @csrf
                <div class="ui-card-header"><x-ui.section-heading title="Datos de la actividad" description="Comunica con claridad qué se espera y cuándo debe entregarse." icon="heroicon-o-pencil-square" /></div>
                <div class="ui-card-body space-y-5">
                    <div>
                        <label for="titulo" class="ui-label">Título <span class="text-red-600" aria-hidden="true">*</span></label>
                        <input id="titulo" name="titulo" type="text" value="{{ old('titulo') }}" class="ui-field" placeholder="Ej. Análisis de caso práctico" required>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="tipo_actividad_id" class="ui-label">Tipo de actividad <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="tipo_actividad_id" name="tipo_actividad_id" class="ui-field" required>
                                <option value="">Selecciona un tipo</option>
                                @foreach($tiposActividad as $tipo)<option value="{{ $tipo->id }}" @selected(old('tipo_actividad_id') == $tipo->id)>{{ $tipo->nombre }}</option>@endforeach
                            </select>
                        </div>
                        <div>
                            <label for="semana_id" class="ui-label">Semana <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="semana_id" name="semana_id" class="ui-field" required>
                                <option value="">Selecciona una semana</option>
                                @foreach($semanas as $semana)<option value="{{ $semana->id }}" @selected(old('semana_id', request('semana')) == $semana->id)>Semana {{ $semana->numero }}{{ $semana->nombre ? ' · '.$semana->nombre : '' }}</option>@endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div><label for="fecha_inicio" class="ui-label">Inicio <span class="text-red-600" aria-hidden="true">*</span></label><input id="fecha_inicio" name="fecha_inicio" type="datetime-local" value="{{ old('fecha_inicio') }}" class="ui-field" required></div>
                        <div><label for="fecha_limite" class="ui-label">Fecha límite <span class="text-red-600" aria-hidden="true">*</span></label><input id="fecha_limite" name="fecha_limite" type="datetime-local" value="{{ old('fecha_limite') }}" class="ui-field" required></div>
                    </div>
                    <div><label for="descripcion" class="ui-label">Instrucciones <span class="text-xs font-normal text-gray-500">(opcional)</span></label><textarea id="descripcion" name="descripcion" rows="5" class="ui-field" placeholder="Objetivo, pasos y entregables esperados...">{{ old('descripcion') }}</textarea></div>
                </div>
                <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:justify-end"><a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">Cancelar</a><button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Crear actividad</button></div>
            </form>
        @endif
    </div>
</x-app-layout>
