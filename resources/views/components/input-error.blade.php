@props(['messages', 'for' => null])

@if ($messages)
    <ul
        @if($for) id="{{ $for }}-error" @endif
        {{ $attributes->merge(['class' => 'mt-1.5 space-y-1 text-sm font-medium text-red-700']) }}
        role="alert"
    >
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
