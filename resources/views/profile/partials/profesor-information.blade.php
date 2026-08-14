<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    {{-- ================== CUENTA ================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <x-input-label for="email" value="Correo institucional" />
            <input type="hidden" name="email" value="{{ $user->email }}">
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100" :value="$user->email"
                          disabled />
        </div>

    </div>

    {{-- ================== PROFESOR ================== --}}
    @if(auth()->user()->profesor)
        <div class="pt-4 border-t border-gray-200">
            <h3 class="text-md font-semibold text-blue-700 mb-3">
                Información del Profesor
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <x-input-label value="Código Docente" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->profesor->codigo_profesor"
                                  disabled />
                </div>

                <div>
                    <x-input-label value="Nombres" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->profesor->nombres"
                                  disabled />
                </div>

                <div>
                    <x-input-label value="Apellido paterno" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->profesor->apellido_paterno"
                                  disabled />
                </div>

                <div>
                    <x-input-label value="Apellido materno" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->profesor->apellido_materno"
                                  disabled />
                </div>

                {{-- CAMPO TELÉFONO --}}
                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" required
                                  :value="old('telefono', auth()->user()->profesor->telefono)" />

                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

            </div>
        </div>
    @endif

    {{-- ================== BOTÓN ================== --}}
    <div class="flex items-center gap-4 pt-4">
        <x-primary-button>
            Guardar cambios
        </x-primary-button>

        @if (session('status') === 'profesor-updated')
            <p class="text-sm text-green-600">
                ✓ Información actualizada correctamente.
            </p>
        @endif

        @if (session('error'))
            <p class="text-sm text-red-600">
                {{ session('error') }}
            </p>
        @endif
    </div>
</form>
