<x-app-layout>
<x-slot name="header"><h1 class="text-2xl font-bold">Entrega: {{ $actividad->titulo }}</h1></x-slot>
<div class="max-w-4xl mx-auto p-6 space-y-4">
<p>{{ $actividad->descripcion }}</p>
@foreach($errors->all() as $error)<p class="text-red-600">{{ $error }}</p>@endforeach
<form x-data="{ insert(before, after = '') { const field = this.$refs.summary; const start = field.selectionStart; const end = field.selectionEnd; field.setRangeText(before + field.value.slice(start, end) + after, start, end, 'select'); field.focus(); } }" method="POST" enctype="multipart/form-data" action="{{ isset($entrega) ? route('alumno.entregas.update', $entrega) : route('alumno.entregas.store', $actividad) }}" class="space-y-4">
@csrf
@isset($entrega) @method('PUT') @endisset
<label class="block">Archivo (PDF, Word, ZIP o RAR; máximo 10 MB)<input class="block" type="file" name="archivo" required accept=".pdf,.doc,.docx,.zip,.rar"></label>
<label class="block" for="resumen">Resumen de la entrega (Markdown)</label>
<p class="text-sm text-gray-600">Usa # para títulos, **texto** para negrita y - para listas.</p>
<div class="flex gap-2" role="toolbar" aria-label="Formato Markdown">
<button type="button" class="ui-btn-secondary" @click="insert('## ')">Título</button>
<button type="button" class="ui-btn-secondary" @click="insert('**', '**')">Negrita</button>
<button type="button" class="ui-btn-secondary" @click="insert('- ')">Lista</button>
<button type="button" class="ui-btn-secondary" @click="insert('[', '](https://)')">Enlace</button>
</div><textarea x-ref="summary" id="resumen" name="resumen" rows="14" maxlength="50000" class="w-full rounded border-gray-300 font-mono">{{ old('resumen', $entrega->resumen ?? '') }}</textarea>
<button class="ui-btn-primary" type="submit">Guardar entrega</button>
</form></div></x-app-layout>
