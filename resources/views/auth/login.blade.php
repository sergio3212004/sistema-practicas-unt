<x-guest-layout title="Iniciar Sesión" subtitle="Accede al sistema institucional">

    {{-- Session Status --}}
    <x-auth-session-status class="mb-6" :status="session('status')" />

    {{-- Info Message --}}
    @if (session('info'))
        <div class="mb-6 rounded-xl bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-800">
            {{ session('info') }}
        </div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email --}}
        <div class="space-y-1">
            <x-input-label for="login-email" value="Correo institucional" />

            <x-text-input
                id="login-email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            />

            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Password --}}
        <div class="space-y-1">
            <x-input-label for="login-password" value="Contraseña" />

            <x-text-input
                id="login-password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="block w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="flex items-center gap-2 text-gray-600">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >
                Recordarme
            </label>

            @if (\Illuminate\Support\Facades\Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-blue-600 hover:text-blue-800 font-medium transition"
                >
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="pt-4">
            <x-primary-button class="w-full justify-center">
                Iniciar Sesión
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>

