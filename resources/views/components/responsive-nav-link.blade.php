@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl bg-blue-50 px-4 py-2.5 text-start text-sm font-semibold text-blue-800 transition'
            : 'block w-full rounded-xl px-4 py-2.5 text-start text-sm font-semibold text-gray-600 transition hover:bg-gray-100 hover:text-blue-800';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
