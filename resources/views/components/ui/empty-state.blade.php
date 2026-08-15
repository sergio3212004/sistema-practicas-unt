@props([
    'title',
    'description',
    'icon' => 'heroicon-o-inbox',
])

<div {{ $attributes->merge(['class' => 'ui-empty']) }}>
    <span class="ui-icon-box h-14 w-14" aria-hidden="true">
        @svg($icon, 'h-7 w-7')
    </span>
    <h2 class="mt-5 text-lg font-bold text-gray-950">{{ $title }}</h2>
    <p class="mt-2 max-w-lg text-sm leading-6 text-gray-600">{{ $description }}</p>
    @isset($actions)
        <div class="mt-6 flex flex-wrap justify-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
