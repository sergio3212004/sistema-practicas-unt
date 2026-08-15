@props([
    'title',
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between']) }}>
    <div class="flex min-w-0 items-start gap-3">
        @if($icon)
            <span class="ui-icon-box h-10 w-10" aria-hidden="true">
                @svg($icon, 'h-5 w-5')
            </span>
        @endif

        <div class="min-w-0">
            <h2 class="text-lg font-bold text-gray-950">{{ $title }}</h2>
            @if($description)
                <p class="mt-1 max-w-3xl text-sm leading-6 text-gray-600">{{ $description }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
