@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-start gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800']) }} role="status" aria-atomic="true">
        @svg('heroicon-o-check-circle', 'mt-0.5 h-5 w-5 shrink-0')
        <span>{{ $status }}</span>
    </div>
@endif
