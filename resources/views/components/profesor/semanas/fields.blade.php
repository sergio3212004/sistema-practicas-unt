@props(['numero' => 1, 'nombre' => '', 'planificacion' => ''])
<div>
    <label for="numero" class="ui-label">Número de semana <span class="text-red-600" aria-hidden="true">*</span></label>
    <input id="numero" name="numero" type="number" min="1" value="{{ old('numero', $numero) }}" class="ui-field" required>
    @error('numero')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="nombre" class="ui-label">Nombre descriptivo <span class="text-xs font-normal text-gray-500">(opcional)</span></label>
    <input id="nombre" name="nombre" type="text" maxlength="255" value="{{ old('nombre', $nombre) }}" class="ui-field" placeholder="Ej. Desarrollo de la propuesta">
</div>
<x-ui.markdown-field name="planificacion" label="Planificación del sílabo" :value="$planificacion" />
