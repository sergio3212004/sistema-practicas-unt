<x-app-layout :title="'Nueva semana · Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Planificación académica" :title="'Nueva semana · Aula '.$aula->numero" :description="($aula->semestre?->nombre ?? 'Sin semestre').' · organiza el siguiente bloque de trabajo.'" icon="heroicon-o-calendar-days">
            <x-slot name="actions"><a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula</a></x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-4xl">
        <x-ui.form-errors />
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
            <form action="{{ route('profesor.semanas.store', $aula) }}" method="POST" class="ui-card overflow-hidden">
                @csrf
                <div class="ui-card-header"><x-ui.section-heading title="Datos de la semana" description="El número debe ser único dentro del aula." icon="heroicon-o-pencil-square" /></div>
                <div class="ui-card-body space-y-5">
                    <div>
                        <label for="numero" class="ui-label">Número de semana <span class="text-red-600" aria-hidden="true">*</span></label>
                        <input id="numero" name="numero" type="number" min="1" max="15" value="{{ old('numero', $siguienteNumero) }}" class="ui-field" required aria-describedby="numero-ayuda">
                        <p id="numero-ayuda" class="mt-2 text-xs text-gray-500">Siguiente número sugerido: {{ $siguienteNumero }}.</p>
                    </div>
                    <div>
                        <label for="nombre" class="ui-label">Nombre descriptivo <span class="text-xs font-normal text-gray-500">(opcional)</span></label>
                        <input id="nombre" name="nombre" type="text" maxlength="255" value="{{ old('nombre') }}" class="ui-field" placeholder="Ej. Desarrollo de la propuesta">
                    </div>
                </div>
                <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('profesor.aulas.show', $aula) }}" class="ui-btn-secondary">Cancelar</a>
                    <button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Crear semana</button>
                </div>
            </form>

            <aside class="ui-card self-start">
                <div class="ui-card-header"><x-ui.section-heading title="Contexto" icon="heroicon-o-information-circle" /></div>
                <dl class="ui-card-body space-y-4 text-sm">
                    <div><dt class="text-gray-500">Aula</dt><dd class="mt-1 font-semibold text-gray-900">Aula {{ $aula->numero }}</dd></div>
                    <div><dt class="text-gray-500">Semestre</dt><dd class="mt-1 font-semibold text-gray-900">{{ $aula->semestre?->nombre ?? 'Sin asignar' }}</dd></div>
                    <div><dt class="text-gray-500">Semanas existentes</dt><dd class="mt-1 font-semibold text-gray-900">{{ $aula->semanas->count() }}</dd></div>
                </dl>
            </aside>
        </div>
    </div>
</x-app-layout>
