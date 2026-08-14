<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $documentTitle }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div
        x-data="navigation"
        @keydown.escape.window="closeNavigation()"
        @resize.window="syncNavigation()"
        class="min-h-screen bg-gray-50"
    >
        @include('layouts.navigation')

        <div
            :class="navigationExpanded ? 'lg:pl-72' : 'lg:pl-0'"
            class="min-h-screen transition-[padding] duration-200 ease-out"
        >
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white/95 backdrop-blur">
                <div class="flex h-16 items-center gap-4 px-4 sm:px-6 lg:px-8">
                    <button
                        type="button"
                        @click="toggleNavigation()"
                        class="ui-btn-ghost -ml-2 px-2.5"
                        :aria-label="navigationVisible() ? 'Cerrar menú principal' : 'Abrir menú principal'"
                        :aria-expanded="navigationVisible()"
                        aria-controls="primary-navigation"
                    >
                        @svg('heroicon-o-bars-3', 'h-6 w-6')
                    </button>

                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-blue-900">Sistema de Prácticas Preprofesionales</p>
                        <p class="hidden truncate text-xs text-gray-500 sm:block">Escuela de Ingeniería Informática · Universidad Nacional de Trujillo</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right md:block">
                            <p class="max-w-52 truncate text-sm font-semibold text-gray-900">{{ $layout->userName }}</p>
                            <p class="text-xs text-gray-500">{{ $layout->roleLabel }}</p>
                        </div>
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-700 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800"
                            aria-label="Abrir perfil de {{ $layout->userName }}"
                        >
                            {{ $layout->initial }}
                        </a>
                    </div>
                </div>
            </header>

            <main class="app-grid min-h-[calc(100vh-4rem)]">
                @isset($header)
                    <div class="border-b border-gray-200 bg-white">
                        <div class="mx-auto max-w-screen-2xl px-4 py-5 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <x-ui.flash />

    @stack('scripts')
</body>
</html>
