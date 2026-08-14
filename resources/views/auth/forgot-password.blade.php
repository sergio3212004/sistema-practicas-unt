<x-guest-layout title="Recuperar contraseña" subtitle="Restablecimiento de acceso">

    <div class="mb-6 text-sm text-gray-600 leading-relaxed">
        ¿Olvidaste tu contraseña? No hay problema.
        Ingresa tu correo electrónico institucional y te enviaremos un enlace
        para que puedas crear una nueva contraseña.
    </div>

    <!-- Estado de sesión -->
    <x-auth-session-status
        class="mb-6 text-sm text-green-600 font-medium"
        :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Correo electrónico -->
        <div>
            <x-input-label
                for="email"
                value="Correo electrónico"
                class="text-gray-700 font-semibold"
            />

            <x-text-input
                id="email"
                class="block mt-2 w-full rounded-xl"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="correo@ejemplo.com"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Botón -->
        <div class="flex justify-end">
            <x-primary-button class="w-full justify-center">
                Enviar enlace de recuperación
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
