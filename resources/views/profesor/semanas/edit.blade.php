<x-app-layout :title="'Editar semana '.$semana->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Planificación académica" :title="'Editar semana '.$semana->numero" :description="'Aula '.$semana->aula->numero.' · '.($semana->aula->semestre?->nombre ?? 'Sin semestre')" icon="heroicon-o-pencil-square">
            <x-slot name="actions"><a href="{{ route('profesor.semanas.show', $semana) }}" class="ui-btn-secondary">@svg('heroicon-o-eye', 'h-4 w-4') Ver semana</a></x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-3xl">
        <x-ui.form-errors />
        <form action="{{ route('profesor.semanas.update', $semana) }}" method="POST" class="ui-card overflow-hidden">
            @csrf
            @method('PUT')
            <div class="ui-card-header"><x-ui.section-heading title="Información de la semana" :description="$semana->actividades->count().' actividades asociadas.'" icon="heroicon-o-calendar" /></div>
            <div class="ui-card-body space-y-5">
                @if($semana->actividades->isNotEmpty())
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">Cambiar el número no altera las actividades, pero sí su ubicación dentro de la planificación.</div>
                @endif
                <div>
                    <label for="numero" class="ui-label">Número de semana <span class="text-red-600" aria-hidden="true">*</span></label>
                    <input id="numero" name="numero" type="number" min="1" value="{{ old('numero', $semana->numero) }}" class="ui-field" required>
                </div>
                <div>
                    <label for="nombre" class="ui-label">Nombre descriptivo <span class="text-xs font-normal text-gray-500">(opcional)</span></label>
                    <input id="nombre" name="nombre" type="text" maxlength="255" value="{{ old('nombre', $semana->nombre) }}" class="ui-field" placeholder="Ej. Desarrollo de la propuesta">
                </div>
            </div>
            <div class="flex flex-col-reverse gap-2 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:justify-end">
                <a href="{{ route('profesor.semanas.show', $semana) }}" class="ui-btn-secondary">Cancelar</a>
                <button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Guardar cambios</button>
            </div>
        </form>
    </div>
</x-app-layout>
