@props(['value'])

@if($attributes->has('for'))
    <label {{ $attributes->merge(['class' => 'ui-label']) }}>
        {{ $value ?? $slot }}
    </label>
@else
    <span {{ $attributes->merge(['class' => 'ui-label']) }}>
        {{ $value ?? $slot }}
    </span>
@endif
