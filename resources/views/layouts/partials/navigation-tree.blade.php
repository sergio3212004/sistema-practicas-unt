<ul class="space-y-1">
    @foreach($items as $node)
        <li>
            @if(array_key_exists('children', $node))
                <details class="group/nav" @if($node['active'] || $node['label'] === 'Mis aulas') open @endif>
                    <summary class="flex cursor-pointer list-none items-center gap-2 rounded-lg px-3 py-3 text-sm font-semibold text-blue-100 transition hover:bg-white/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-gold-400 [&::-webkit-details-marker]:hidden">
                        <span class="transition-transform group-open/nav:rotate-90" aria-hidden="true">@svg('heroicon-o-chevron-right', 'h-4 w-4')</span>
                        <span>{{ $node['label'] }}</span>
                    </summary>
                    <div class="ml-5 border-l border-blue-300/30 pl-2">
                        @include('layouts.partials.navigation-tree', ['items' => $node['children']])
                        @if(empty($node['children']))<p class="px-3 py-2 text-xs text-blue-200">{{ $node['empty'] ?? 'Sin opciones disponibles.' }}</p>@endif
                    </div>
                </details>
            @else
                <a href="{{ $node['url'] }}" @if($node['active']) aria-current="page" @endif
                   @class(['block rounded-lg px-3 py-2.5 text-sm transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-gold-400', 'bg-white font-semibold text-blue-950' => $node['active'], 'text-blue-100 hover:bg-white/10 hover:text-white' => !$node['active']])>{{ $node['label'] }}</a>
            @endif
        </li>
    @endforeach
</ul>
