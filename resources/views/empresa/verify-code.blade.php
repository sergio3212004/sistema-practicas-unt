<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Verificación de Email</h2>
        <p class="mt-2 text-sm text-gray-600">
            Hemos enviado un código de 6 dígitos a tu correo electrónico.
        </p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('empresa.verify.code') }}">
        @csrf

        <!-- Código de Verificación -->
        <div>
            <x-input-label for="codigo" value="Código de Verificación" />
            <x-text-input
                id="codigo"
                class="block mt-1 w-full text-center text-2xl tracking-widest"
                type="text"
                name="codigo"
                required
                autofocus
                maxlength="6"
                pattern="[0-9]{6}"
                placeholder="000000" />
            <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            <p class="mt-2 text-xs text-gray-500">Ingresa el código de 6 dígitos</p>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Cancelar
            </a>

            <x-primary-button>
                Verificar y Registrar
            </x-primary-button>
        </div>
    </form>

    <!-- Reenviar código -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            ¿No recibiste el código?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800">
                Volver a intentar
            </a>
        </p>
    </div>
</x-guest-layout>
