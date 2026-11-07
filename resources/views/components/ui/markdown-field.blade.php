@props(['name', 'label', 'value' => '', 'rows' => 8])
<div>
    <label for="{{ $name }}" class="ui-label">{{ $label }}</label>
    <p id="{{ $name }}-help" class="mb-2 text-sm text-gray-500">Markdown: # para títulos, **texto** para negrita y - para listas.</p>
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" maxlength="50000" class="ui-field font-mono" aria-describedby="{{ $name }}-help" @error($name) aria-invalid="true" @enderror>{{ old($name, $value) }}</textarea>
    @error($name)<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
