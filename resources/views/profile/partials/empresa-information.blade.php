<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    {{-- ================== CUENTA ================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <x-input-label for="email" value="Correo electrónico" />
            <input type="hidden" name="email" value="{{ $user->email }}">
            <x-text-input id="email" type="email" class="mt-1 block w-full bg-gray-100" :value="$user->email"
                          disabled />
        </div>

    </div>

    {{-- ================== EMPRESA ================== --}}
    @if(auth()->user()->empresa)
        <div class="pt-4 border-t border-gray-200">
            <h3 class="text-md font-semibold text-blue-700 mb-3">
                Información de la Empresa
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <x-input-label value="RUC" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->empresa->ruc" disabled />
                </div>

                <div>
                    <x-input-label value="Razón Social / Nombre" />
                    <x-text-input class="mt-1 block w-full bg-gray-100" :value="auth()->user()->empresa->nombre" disabled />
                </div>

                {{-- CAMPO TELÉFONO --}}
                <div>
                    <x-input-label for="telefono" value="Teléfono de contacto" />
                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" required
                                  :value="old('telefono', auth()->user()->empresa->telefono)" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                {{-- DEPARTAMENTO --}}
                <div>
                    <x-input-label for="departamento" value="Departamento" />
                    <x-text-input id="departamento" name="departamento" type="text" class="mt-1 block w-full"
                                  :value="old('departamento', auth()->user()->empresa->departamento)" />
                    <x-input-error :messages="$errors->get('departamento')" class="mt-2" />
                </div>

                {{-- PROVINCIA --}}
                <div>
                    <x-input-label for="provincia" value="Provincia" />
                    <x-text-input id="provincia" name="provincia" type="text" class="mt-1 block w-full"
                                  :value="old('provincia', auth()->user()->empresa->provincia)" />
                    <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
                </div>

                {{-- DISTRITO --}}
                <div>
                    <x-input-label for="distrito" value="Distrito" />
                    <x-text-input id="distrito" name="distrito" type="text" class="mt-1 block w-full"
                                  :value="old('distrito', auth()->user()->empresa->distrito)" />
                    <x-input-error :messages="$errors->get('distrito')" class="mt-2" />
                </div>

                {{-- DIRECCIÓN (Full width) --}}
                <div class="md:col-span-2">
                    <x-input-label for="direccion" value="Dirección fiscal" />
                    <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full"
                                  :value="old('direccion', auth()->user()->empresa->direccion)" />
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

            </div>
        </div>
    @endif

    {{-- ================== BOTÓN ================== --}}
    <div class="flex items-center gap-4 pt-4">
        <x-primary-button>
            Guardar cambios
        </x-primary-button>

        @if (session('status') === 'empresa-updated')
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
