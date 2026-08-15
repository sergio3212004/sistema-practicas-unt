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

<input
    @disabled($disabled)
    @if($hasError) aria-invalid="true" @endif
    @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
    {{ $attributes->except('aria-describedby')->merge(['class' => 'ui-field']) }}
>
