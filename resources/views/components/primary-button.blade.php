@props(['type' => 'submit'])

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'ui-btn-primary'
    ]) }}
>
    {{ $slot }}
</button>
