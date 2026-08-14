<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Perfil del Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">


            {{-- Información de cuenta --}}
            <div class="p-6 bg-white shadow rounded-2xl border-l-4 border-blue-500">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Cambio de contraseña --}}
            <div class="p-6 bg-white shadow rounded-2xl border-l-4 border-blue-500">
                @include('profile.partials.update-password-form')
            </div>

        </div>
    </div>
</x-app-layout>
