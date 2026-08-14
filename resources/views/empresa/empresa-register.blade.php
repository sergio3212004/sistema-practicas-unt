<x-guest-layout>
    <form method="POST" action="{{ route('empresa.register') }}" class="space-y-8">
        @csrf

        {{-- ===== Datos principales ===== --}}
        <div class="space-y-6">

            {{-- RUC --}}
            <div>
                <x-input-label for="ruc" value="RUC *" />

                <x-text-input
                    id="ruc"
                    name="ruc"
                    type="text"
                    :value="old('ruc')"
                    required
                    maxlength="11"
                    pattern="[0-9]{11}"
                    placeholder="11 dígitos"
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />

                <x-input-error :messages="$errors->get('ruc')" />
            </div>

            {{-- Nombre --}}
            <div>
                <x-input-label for="nombre" value="Nombre de la Empresa *" />

                <x-text-input
                    id="nombre"
                    name="nombre"
                    type="text"
                    :value="old('nombre')"
                    required
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />

                <x-input-error :messages="$errors->get('nombre')" />
            </div>

            {{-- Razón Social --}}
            <div>
                <x-input-label for="razon_social_id" value="Razón Social *" />

                <select
                    id="razon_social_id"
                    name="razon_social_id"
                    required
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">Seleccione una razón social</option>
                    @foreach(\App\Models\RazonSocial::all() as $razon)
                        <option value="{{ $razon->id }}" @selected(old('razon_social_id') == $razon->id)>
                            {{ $razon->acronimo }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('razon_social_id')" />
            </div>
        </div>

        {{-- ===== Credenciales ===== --}}
        <div class="space-y-6 border-t pt-8">

            <div>
                <x-input-label for="register-email" value="Email *" />

                <x-text-input
                    id="register-email"
                    name="email"
                    type="email"
                    :value="old('email')"
                    required
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />

                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="register-password" value="Contraseña *" />

                <x-text-input
                    id="register-password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />

                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />

                <x-text-input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />
            </div>
        </div>

        {{-- ===== Información de contacto ===== --}}
        <div class="space-y-6 border-t pt-8">

            <div>
                <x-input-label for="telefono" value="Teléfono" />

                <x-text-input
                    id="telefono"
                    name="telefono"
                    type="text"
                    :value="old('telefono')"
                    maxlength="9"
                    pattern="[0-9]{9}"
                    placeholder="9 dígitos"
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />

                <x-input-error :messages="$errors->get('telefono')" />
            </div>

            {{-- Ubigeo --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="departamento_display" value="Departamento" />
                    <select id="departamento_display" disabled
                            class="block w-full rounded-xl px-4 py-3 text-sm
                               border-gray-300 bg-gray-100 cursor-not-allowed">
                        <option value="La Libertad">La Libertad</option>
                    </select>
                    {{-- Campo oculto para enviar el valor al servidor --}}
                    <input type="hidden" name="departamento" value="La Libertad">
                </div>

                <div>
                    <x-input-label for="provincia" value="Provincia" />
                    <select id="provincia" name="provincia"
                            class="block w-full rounded-xl px-4 py-3 text-sm
                               border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="distrito" value="Distrito" />
                    <select id="distrito" name="distrito" disabled
                            class="block w-full rounded-xl px-4 py-3 text-sm
                               border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>

            <div>
                <x-input-label for="direccion" value="Dirección" />

                <x-text-input
                    id="direccion"
                    name="direccion"
                    type="text"
                    :value="old('direccion')"
                    class="block w-full rounded-xl px-4 py-3 text-sm
                           border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                />
            </div>
        </div>

        {{-- ===== Acción ===== --}}
        <div class="pt-6">
            <button
                type="submit"
                class="w-full rounded-xl px-6 py-3 text-sm font-semibold text-white
                       bg-gradient-to-r from-blue-700 to-indigo-700
                       hover:from-blue-800 hover:to-indigo-800
                       shadow-lg transition focus:outline-none
                       focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Registrar Empresa
            </button>
        </div>
    </form>


    <script>
        document.addEventListener('DOMContentLoaded', async function() {

            /* ============================================================
               UBIGEO DINÁMICO - La Libertad fijo
               ============================================================ */

            const departamentoSelect = document.getElementById("departamento");
            const provinciaSelect = document.getElementById("provincia");
            const distritoSelect = document.getElementById("distrito");

            let ubigeo = [];
            try {
                ubigeo = await fetch("{{ asset('ubigeo.json') }}").then(res => res.json());
            } catch (error) {
                console.error("Error cargando ubigeo.json:", error);
                return;
            }

            // Buscar directamente el departamento de La Libertad
            const laLibertad = ubigeo.find(d => d.nombre === "La Libertad");

            if (!laLibertad) {
                console.error("No se encontró La Libertad en ubigeo.json");
                return;
            }

            // Cargar provincias de La Libertad automáticamente
            laLibertad.provincias.forEach(prov => {
                const option = document.createElement("option");
                option.value = prov.nombre;
                option.textContent = prov.nombre;
                provinciaSelect.appendChild(option);
            });

            // Cambia distritos al seleccionar provincia
            provinciaSelect.addEventListener("change", () => {
                distritoSelect.innerHTML = '<option value="">Seleccione</option>';
                distritoSelect.disabled = true;

                const prov = laLibertad.provincias.find(p => p.nombre === provinciaSelect.value);
                if (!prov) return;

                prov.distritos.forEach(dist => {
                    const option = document.createElement("option");
                    option.value = dist;
                    option.textContent = dist;
                    distritoSelect.appendChild(option);
                });
                distritoSelect.disabled = false;
            });
        });
    </script>
</x-guest-layout>
