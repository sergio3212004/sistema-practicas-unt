<button
    type="button"
    x-data="themeToggle"
    @click="toggle()"
    class="ui-btn-ghost shrink-0 px-2.5"
    :aria-label="dark ? 'Activar modo claro' : 'Activar modo oscuro'"
    :title="dark ? 'Activar modo claro' : 'Activar modo oscuro'"
>
    <span x-cloak x-show="! dark" aria-hidden="true">@svg('heroicon-o-moon', 'h-5 w-5')</span>
    <span x-cloak x-show="dark" aria-hidden="true">@svg('heroicon-o-sun', 'h-5 w-5')</span>
    <span class="sr-only" x-text="dark ? 'Activar modo claro' : 'Activar modo oscuro'"></span>
</button>
