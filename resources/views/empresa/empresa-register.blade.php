<x-guest-layout title="Registro de empresa" subtitle="Consulta tu RUC y crea las credenciales de acceso">
    <div
        x-data="companyRegistration({
            lookupUrl: @js(route('empresa.ruc.lookup')),
            csrfToken: @js(csrf_token()),
            lookupReady: @js(old('nombre') !== null),
            initial: {
                ruc: @js(old('ruc', '')),
                nombre: @js(old('nombre', '')),
                razon_social_id: @js(old('razon_social_id', '')),
                departamento: @js(old('departamento', '')),
                provincia: @js(old('provincia', '')),
                distrito: @js(old('distrito', '')),
                direccion: @js(old('direccion', '')),
            },
        })"
    >
        <form method="POST" action="{{ route('empresa.register') }}" class="space-y-8">
            @csrf

            <section class="space-y-4">
                <div>
                    <p class="ui-eyebrow">Paso 1</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-950">Consulta de empresa</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        Ingresa el RUC de 11 dígitos para obtener los datos registrados en SUNAT.
                    </p>
                </div>

                <div>
                    <x-input-label for="ruc" value="RUC *" />

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <x-text-input
                            id="ruc"
                            name="ruc"
                            type="text"
                            x-model="ruc"
                            x-on:input="handleRucInput"
                            inputmode="numeric"
                            required
                            maxlength="11"
                            pattern="[0-9]{11}"
                            placeholder="11 dígitos"
                            class="block w-full px-4 py-3"
                        />

                        <button
                            type="button"
                            x-on:click="lookupRuc"
                            x-bind:disabled="lookupState === 'loading'"
                            class="ui-btn-primary shrink-0 px-5 py-3"
                        >
                            <svg
                                x-show="lookupState === 'loading'"
                                class="h-5 w-5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                                aria-hidden="true"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                            </svg>
                            <span x-text="lookupState === 'loading' ? 'Consultando…' : 'Consultar RUC'">Consultar RUC</span>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('ruc')" />

                    <div
                        x-show="lookupMessage"
                        x-cloak
                        class="mt-3 rounded-xl border px-4 py-3 text-sm leading-6"
                        x-bind:class="statusClasses"
                        role="status"
                        aria-live="polite"
                    >
                        <p x-text="lookupMessage"></p>
                    </div>
                </div>
            </section>

            <section x-show="detailsVisible" x-cloak class="space-y-6 border-t pt-8">
                <div>
                    <p class="ui-eyebrow">Datos de SUNAT</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-950">Información de la empresa</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        Los datos encontrados están protegidos. Si falta información, completa los campos habilitados.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="nombre" value="Nombre o razón social *" />
                        <x-text-input
                            id="nombre"
                            name="nombre"
                            type="text"
                            x-model="company.nombre"
                            x-bind:readonly="isReadonly('nombre')"
                            x-bind:class="fieldClasses('nombre')"
                            required
                        />
                        <x-input-error :messages="$errors->get('nombre')" />
                    </div>

                    <div>
                        <x-input-label for="razon_social_id" value="Tipo de persona jurídica *" />
                        <input type="hidden" name="razon_social_id" x-model="company.razon_social_id">
                        <select
                            id="razon_social_id"
                            x-model="company.razon_social_id"
                            x-bind:disabled="isReadonly('razon_social_id')"
                            x-bind:class="fieldClasses('razon_social_id')"
                            class="ui-field block w-full"
                            required
                        >
                            <option value="">Seleccione el tipo de empresa</option>
                            @foreach($razonesSociales as $razon)
                                <option value="{{ $razon->id }}">{{ $razon->acronimo }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('razon_social_id')" />
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <x-input-label for="departamento" value="Departamento" />
                            <x-text-input
                                id="departamento"
                                name="departamento"
                                type="text"
                                x-model="company.departamento"
                                x-bind:readonly="isReadonly('departamento')"
                                x-bind:class="fieldClasses('departamento')"
                            />
                            <x-input-error :messages="$errors->get('departamento')" />
                        </div>

                        <div>
                            <x-input-label for="provincia" value="Provincia" />
                            <x-text-input
                                id="provincia"
                                name="provincia"
                                type="text"
                                x-model="company.provincia"
                                x-bind:readonly="isReadonly('provincia')"
                                x-bind:class="fieldClasses('provincia')"
                            />
                            <x-input-error :messages="$errors->get('provincia')" />
                        </div>

                        <div>
                            <x-input-label for="distrito" value="Distrito" />
                            <x-text-input
                                id="distrito"
                                name="distrito"
                                type="text"
                                x-model="company.distrito"
                                x-bind:readonly="isReadonly('distrito')"
                                x-bind:class="fieldClasses('distrito')"
                            />
                            <x-input-error :messages="$errors->get('distrito')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="direccion" value="Domicilio fiscal" />
                        <x-text-input
                            id="direccion"
                            name="direccion"
                            type="text"
                            x-model="company.direccion"
                            x-bind:readonly="isReadonly('direccion')"
                            x-bind:class="fieldClasses('direccion')"
                        />
                        <x-input-error :messages="$errors->get('direccion')" />
                    </div>

                    <div x-show="company.estado || company.condicion" class="flex flex-wrap gap-2">
                        <span x-show="company.estado" class="ui-badge-info">
                            Estado: <span x-text="company.estado"></span>
                        </span>
                        <span x-show="company.condicion" class="ui-badge-info">
                            Condición: <span x-text="company.condicion"></span>
                        </span>
                    </div>
                </div>
            </section>

            <section class="space-y-6 border-t pt-8">
                <div>
                    <p class="ui-eyebrow">Paso 2</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-950">Credenciales y contacto</h3>
                </div>

                <div>
                    <x-input-label for="register-email" value="Correo electrónico *" />
                    <x-text-input
                        id="register-email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autocomplete="email"
                        class="block w-full px-4 py-3"
                    />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="register-password" value="Contraseña *" />
                    <x-password-input
                        id="register-password"
                        name="password"
                        required
                        autocomplete="new-password"
                        class="block w-full px-4 py-3"
                    />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Confirmar contraseña *" />
                    <x-password-input
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="block w-full px-4 py-3"
                    />
                </div>

                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input
                        id="telefono"
                        name="telefono"
                        type="text"
                        :value="old('telefono')"
                        inputmode="numeric"
                        maxlength="9"
                        pattern="[0-9]{9}"
                        placeholder="9 dígitos"
                        class="block w-full px-4 py-3"
                    />
                    <x-input-error :messages="$errors->get('telefono')" />
                </div>
            </section>

            <div class="pt-2">
                <button
                    type="submit"
                    x-bind:disabled="! registrationEnabled"
                    class="ui-btn-primary w-full py-3"
                >
                    Registrar empresa
                </button>
                <p x-show="! registrationEnabled" class="mt-2 text-center text-xs text-gray-500">
                    Consulta el RUC para habilitar el registro.
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
