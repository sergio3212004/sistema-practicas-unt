@props(['disabled' => false])

@php
    $fieldName = $attributes->get('name');
    $fieldId = $attributes->get('id');
    $hasError = is_string($fieldName) && isset($errors) && $errors->has($fieldName);
    $describedBy = trim(implode(' ', array_filter([
        $attributes->get('aria-describedby'),
        $hasError && $fieldId ? $fieldId.'-error' : null,
    ])));
@endphp

<div x-data="{ passwordVisible: false }" class="relative">
    <input
        type="password"
        x-bind:type="passwordVisible ? 'text' : 'password'"
        @disabled($disabled)
        @if($hasError) aria-invalid="true" @endif
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        {{ $attributes->except(['type', 'aria-describedby'])->merge(['class' => 'ui-field pr-12']) }}
    >

    <button
        type="button"
        class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-xl text-gray-500 transition hover:text-blue-700 focus:text-blue-700"
        x-on:click="passwordVisible = ! passwordVisible"
        x-bind:aria-label="passwordVisible ? 'Ocultar contraseña' : 'Mostrar contraseña'"
        x-bind:title="passwordVisible ? 'Ocultar contraseña' : 'Mostrar contraseña'"
        aria-label="Mostrar contraseña"
        title="Mostrar contraseña"
    >
        <span x-show="! passwordVisible" aria-hidden="true">
            @svg('heroicon-o-eye', 'h-5 w-5')
        </span>
        <span x-show="passwordVisible" x-cloak aria-hidden="true">
            @svg('heroicon-o-eye-slash', 'h-5 w-5')
        </span>
    </button>
</div>
