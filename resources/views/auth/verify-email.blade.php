<x-guest-layout title="Verificar correo electrónico" subtitle="Protege tu cuenta confirmando tu dirección de correo">
    <div class="mb-4 text-sm text-gray-600">
        Antes de continuar, verifica tu dirección mediante el enlace que enviamos a tu correo. Si no lo recibiste, puedes solicitar uno nuevo.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-700" role="status" aria-atomic="true">
            Enviamos un nuevo enlace de verificación a la dirección registrada.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Reenviar correo de verificación
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>
