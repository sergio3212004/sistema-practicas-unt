<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Actualizar contraseña
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Usa una contraseña larga y difícil de adivinar para proteger tu cuenta.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Contraseña actual" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" @if($errors->updatePassword->has('current_password')) aria-invalid="true" aria-describedby="update_password_current_password-error" @endif />
            <x-input-error for="update_password_current_password" :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva contraseña" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" @if($errors->updatePassword->has('password')) aria-invalid="true" aria-describedby="update_password_password-error" @endif />
            <x-input-error for="update_password_password" :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar nueva contraseña" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" @if($errors->updatePassword->has('password_confirmation')) aria-invalid="true" aria-describedby="update_password_password_confirmation-error" @endif />
            <x-input-error for="update_password_password_confirmation" :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar</x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600" role="status" aria-atomic="true">Guardado.</p>
            @endif
        </div>
    </form>
</section>
