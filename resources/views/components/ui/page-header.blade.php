@props([
    'eyebrow' => 'Gestión académica',
    'title',
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div class="flex min-w-0 items-start gap-4">
        @if($icon)
            <span class="ui-icon-box mt-0.5 hidden sm:flex">
                @svg($icon, 'h-5 w-5')
            </span>
        @endif
        <div class="min-w-0">
            <p class="ui-eyebrow">{{ $eyebrow }}</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl">{{ $title }}</h1>
            @if($description)
                <p class="mt-1.5 max-w-3xl text-sm leading-6 text-gray-600">{{ $description }}</p>
            @endif
        </div>
    </div>

    @isset($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
