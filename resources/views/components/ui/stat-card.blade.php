@props([
    'label',
    'value',
    'description' => null,
    'icon' => 'heroicon-o-chart-bar',
    'tone' => 'primary',
])

@php
    $tones = [
        'primary' => ['bar' => 'bg-blue-700', 'icon' => 'border-blue-100 bg-blue-50 text-blue-700'],
        'success' => ['bar' => 'bg-green-600', 'icon' => 'border-green-100 bg-green-50 text-green-700'],
        'warning' => ['bar' => 'bg-gold-500', 'icon' => 'border-gold-100 bg-gold-50 text-gold-800'],
        'danger' => ['bar' => 'bg-red-600', 'icon' => 'border-red-100 bg-red-50 text-red-700'],
        'neutral' => ['bar' => 'bg-gray-500', 'icon' => 'border-gray-200 bg-gray-100 text-gray-700'],
    ];
    $styles = $tones[$tone] ?? $tones['primary'];
@endphp

<article {{ $attributes->merge(['class' => 'ui-card relative overflow-hidden p-5']) }}>
    <span class="absolute inset-x-0 top-0 h-1 {{ $styles['bar'] }}" aria-hidden="true"></span>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-600">{{ $label }}</p>
            <p class="mt-2 truncate text-3xl font-bold tracking-tight text-gray-950">{{ $value }}</p>
            @if($description)
                <p class="mt-1 text-xs leading-5 text-gray-500">{{ $description }}</p>
            @endif
        </div>
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border {{ $styles['icon'] }}" aria-hidden="true">
            @svg($icon, 'h-5 w-5')
        </span>
    </div>
</article>
