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
</head>
<body class="min-h-screen bg-gray-100">
    <main class="min-h-screen lg:grid lg:grid-cols-[minmax(380px,0.9fr)_minmax(560px,1.1fr)]">
        <section class="tech-grid relative overflow-hidden bg-blue-950 px-6 py-8 text-white sm:px-10 lg:flex lg:min-h-screen lg:flex-col lg:justify-between lg:px-14 lg:py-12">
            <div class="absolute inset-0 bg-cover bg-center opacity-[0.08]" style="background-image: url('{{ asset('images/bg-login.jpg') }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-blue-950/70 via-blue-950/90 to-blue-950"></div>
            <div class="absolute -right-24 top-1/3 h-56 w-56 rotate-45 border border-gold-400/20"></div>
            <div class="absolute bottom-0 left-0 h-1.5 w-full bg-gold-500 lg:h-full lg:w-1.5"></div>

            <div class="relative">
                <div class="flex items-center gap-4">
                    <div class="flex h-[82px] w-[104px] items-center justify-center rounded-xl bg-white p-2.5 shadow-raised">
                        <img
                            src="{{ asset('logo-informatica.png') }}"
                            alt="Logo de la Escuela de Ingeniería Informática"
                            class="max-h-full max-w-full object-contain"
                        >
                    </div>
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-gold-400">Universidad Nacional de Trujillo</p>
                        <p class="mt-1 text-sm font-semibold text-blue-100">Escuela de Ingeniería Informática</p>
                    </div>
                </div>

                <div class="mt-24 hidden max-w-xl lg:block">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-gold-400">Gestión académica digital</p>
                    <h1 class="mt-3 text-3xl font-bold leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                        Prácticas preprofesionales con seguimiento claro y confiable.
                    </h1>
                    <p class="mt-5 max-w-lg text-sm leading-7 text-blue-100 sm:text-base">
                        Un espacio institucional para estudiantes, docentes, empresas y administradores de la Escuela de Ingeniería Informática.
                    </p>
                </div>
            </div>

            <div class="relative mt-10 hidden items-center gap-6 text-xs text-blue-200 lg:flex">
                <span class="flex items-center gap-2">@svg('heroicon-o-shield-check', 'h-4 w-4 text-gold-400') Información protegida</span>
                <span class="flex items-center gap-2">@svg('heroicon-o-command-line', 'h-4 w-4 text-gold-400') Procesos digitalizados</span>
            </div>
        </section>

        <section class="flex min-h-[60vh] items-center justify-center px-4 py-10 sm:px-8 lg:px-12">
            <div class="w-full max-w-xl">
                <div class="mb-7">
                    <p class="ui-eyebrow">Acceso institucional</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl">
                        {{ $heading }}
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        {{ $description }}
                    </p>
                </div>

                <div class="ui-card overflow-hidden">
                    <nav class="grid grid-cols-2 border-b border-gray-200 bg-gray-50" aria-label="Opciones de acceso">
                        <a
                            href="{{ route('login') }}"
                            @class([
                                'relative flex min-h-14 items-center justify-center gap-1.5 px-2 text-xs font-semibold transition sm:gap-2 sm:px-4 sm:text-sm',
                                'bg-white text-blue-800' => $loginActive,
                                'text-gray-600 hover:bg-white hover:text-gray-900' => ! $loginActive,
                            ])
                        >
                            @svg('heroicon-o-arrow-right-end-on-rectangle', 'h-5 w-5')
                            <span class="whitespace-nowrap">Iniciar sesión</span>
                            @if($loginActive)
                                <span class="absolute inset-x-0 bottom-0 h-1 bg-gold-500"></span>
                            @endif
                        </a>
                        <a
                            href="{{ route('empresa.register.form') }}"
                            @class([
                                'relative flex min-h-14 items-center justify-center gap-1.5 px-2 text-xs font-semibold transition sm:gap-2 sm:px-4 sm:text-sm',
                                'bg-white text-blue-800' => $companyActive,
                                'text-gray-600 hover:bg-white hover:text-gray-900' => ! $companyActive,
                            ])
                        >
                            @svg('heroicon-o-building-office-2', 'h-5 w-5')
                            <span class="whitespace-nowrap">Registro empresa</span>
                            @if($companyActive)
                                <span class="absolute inset-x-0 bottom-0 h-1 bg-gold-500"></span>
                            @endif
                        </a>
                    </nav>

                    <div class="p-5 sm:p-7 lg:p-8">
                        {{ $slot }}
                    </div>
                </div>

                <p class="mt-6 text-center text-xs leading-5 text-gray-500">
                    © {{ $currentYear }} Universidad Nacional de Trujillo · Escuela de Ingeniería Informática
                </p>
            </div>
        </section>
    </main>
</body>
</html>
