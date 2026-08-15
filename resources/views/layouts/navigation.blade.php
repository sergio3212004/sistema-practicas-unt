<div
    x-cloak
    x-show="navigationOpen"
    x-transition.opacity
    @click="closeNavigation({ restoreFocus: true })"
    class="fixed inset-0 z-40 bg-gray-950/55 backdrop-blur-sm lg:hidden"
    aria-hidden="true"
></div>

<aside
    id="primary-navigation"
    x-cloak
    x-ref="navigationPanel"
    :inert="!navigationVisible()"
    :aria-hidden="(!navigationVisible()).toString()"
    :role="!desktop && navigationOpen ? 'dialog' : null"
    :aria-modal="!desktop && navigationOpen ? 'true' : null"
    @keydown.tab="trapNavigationFocus($event)"
    :class="{
        'translate-x-0': navigationOpen,
        '-translate-x-full': ! navigationOpen,
        'lg:translate-x-0': navigationExpanded,
        'lg:-translate-x-full': ! navigationExpanded,
    }"
    class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-blue-950/40 bg-blue-950 text-white shadow-2xl transition-transform duration-200 ease-out lg:shadow-none"
    aria-label="Menú principal"
>
    <div class="tech-grid relative border-b border-white/10 px-5 py-6">
        <div class="absolute inset-x-0 bottom-0 h-1 bg-gold-500"></div>
        <button
            type="button"
            @click="closeNavigation({ restoreFocus: true })"
            class="absolute right-3 top-3 rounded-lg p-2 text-blue-200 transition hover:bg-white/10 hover:text-white lg:hidden"
            aria-label="Cerrar menú principal"
        >
            @svg('heroicon-o-x-mark', 'h-5 w-5')
        </button>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-4 rounded-xl">
            <span class="theme-logo-surface flex h-[72px] w-[88px] shrink-0 items-center justify-center rounded-xl bg-white p-2 shadow-sm">
                <img
                    src="{{ asset('logo-informatica.png') }}"
                    alt="Escuela de Ingeniería Informática"
                    class="max-h-full max-w-full object-contain"
                >
            </span>
            <span class="min-w-0">
                <span class="block text-[10px] font-bold uppercase tracking-[0.18em] text-gold-400">Universidad Nacional de Trujillo</span>
                <span class="mt-1 block text-sm font-bold leading-5 text-white">Ingeniería Informática</span>
                <span class="mt-0.5 block text-xs text-blue-200">Prácticas preprofesionales</span>
            </span>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-5" aria-label="Secciones del sistema">
        <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-[0.16em] text-blue-300">Espacio de {{ strtolower($layout->roleLabel) }}</p>

        <div class="space-y-1">
            <a
                href="{{ route('dashboard') }}"
                @if($layout->dashboardActive) aria-current="page" @endif
                @class([
                    'group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                    'bg-white text-blue-950 shadow-sm' => $layout->dashboardActive,
                    'text-blue-100 hover:bg-white/10 hover:text-white' => ! $layout->dashboardActive,
                ])
            >
                @if($layout->dashboardActive)
                    <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-gold-500"></span>
                @endif
                <span @class([
                    'flex h-9 w-9 items-center justify-center rounded-lg',
                    'bg-blue-50 text-blue-700' => $layout->dashboardActive,
                    'bg-white/10 text-blue-100 group-hover:bg-white/15' => ! $layout->dashboardActive,
                ])>
                    @svg('heroicon-o-squares-2x2', 'h-5 w-5')
                </span>
                <span>Resumen</span>
            </a>

            @foreach($layout->menuItems as $item)
                <a
                    href="{{ route($item['route']) }}"
                    @if($item['active']) aria-current="page" @endif
                    @class([
                        'group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition',
                        'bg-white text-blue-950 shadow-sm' => $item['active'],
                        'text-blue-100 hover:bg-white/10 hover:text-white' => ! $item['active'],
                    ])
                >
                    @if($item['active'])
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-gold-500"></span>
                    @endif
                    <span @class([
                        'flex h-9 w-9 items-center justify-center rounded-lg',
                        'bg-blue-50 text-blue-700' => $item['active'],
                        'bg-white/10 text-blue-100 group-hover:bg-white/15' => ! $item['active'],
                    ])>
                        @svg($item['icon'], 'h-5 w-5')
                    </span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>

    <div class="border-t border-white/10 bg-blue-950/70 p-4">
        <a
            href="{{ route('profile.edit') }}"
            class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-blue-100 transition hover:bg-white/10 hover:text-white"
        >
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 group-hover:bg-white/15">
                @svg('heroicon-o-user-circle', 'h-5 w-5')
            </span>
            <span>Mi perfil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="group mt-1 flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-semibold text-blue-100 transition hover:bg-red-600/20 hover:text-white"
            >
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 group-hover:bg-red-600/25">
                    @svg('heroicon-o-arrow-left-on-rectangle', 'h-5 w-5')
                </span>
                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>
</aside>
