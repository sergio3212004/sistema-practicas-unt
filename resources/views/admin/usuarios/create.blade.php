<x-app-layout title="Nuevo usuario">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración"
            title="Crear usuario"
            description="Crea las credenciales y completa únicamente los datos correspondientes al rol seleccionado."
            icon="heroicon-o-user-plus"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.usuarios.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver a usuarios</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">
        <x-ui.form-errors />

        <form action="{{ route('admin.usuarios.store') }}" method="POST" aria-describedby="nota-campos-obligatorios">
            @csrf

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_19rem]">
                <div class="space-y-6">
                    <section class="ui-card overflow-hidden" aria-labelledby="datos-acceso-titulo">
                        <div class="ui-card-header">
                            <x-ui.section-heading
                                title="Datos de acceso"
                                description="Estas credenciales permiten iniciar sesión y determinan el espacio de trabajo disponible."
                                icon="heroicon-o-key"
                            />
                        </div>

                        <div class="ui-card-body space-y-6">
                            <div>
                                <label for="email" class="ui-label">Correo electrónico <span class="text-red-500" aria-hidden="true">*</span></label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="usuario@unitru.edu.pe" class="ui-field" required>
                                <p class="ui-help">Se utilizará como identificador único para acceder al sistema.</p>
                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="ui-label">Contraseña <span class="text-red-500" aria-hidden="true">*</span></label>
                                    <x-password-input id="password" name="password" autocomplete="new-password" class="block w-full" required />
                                    <p class="ui-help">Usa al menos 8 caracteres.</p>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="ui-label">Confirmar contraseña <span class="text-red-500" aria-hidden="true">*</span></label>
                                    <x-password-input id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="block w-full" required />
                                </div>
                            </div>

                            <div>
                                <label for="rol_id" class="ui-label">Rol del usuario <span class="text-red-500" aria-hidden="true">*</span></label>
                                <select id="rol_id" name="rol_id" class="ui-field" aria-describedby="rol-ayuda" required>
                                    <option value="">Selecciona un rol</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" data-rol-nombre="{{ $rol->nombre }}" @selected(old('rol_id') == $rol->id)>{{ ucfirst($rol->nombre) }}</option>
                                    @endforeach
                                </select>
                                <p id="rol-ayuda" class="ui-help">Al elegir un rol aparecerán únicamente los campos necesarios para ese perfil.</p>
                            </div>
                        </div>
                    </section>

                    <section id="perfil-data" class="ui-card hidden overflow-hidden" aria-labelledby="perfil-titulo">
                        <div class="ui-card-header">
                            <x-ui.section-heading
                                title="Información del perfil"
                                description="Completa los datos institucionales vinculados a la cuenta."
                                icon="heroicon-o-identification"
                            />
                        </div>
                        <div class="ui-card-body">
                            <x-alumno-form />
                            <x-administrador-form />
                            <x-empresa-form :razonesSociales="$razonesSociales" />
                            <x-profesor-form />
                        </div>
                    </section>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        <a href="{{ route('admin.usuarios.index') }}" class="ui-btn-secondary">Cancelar</a>
                        <button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Crear usuario</button>
                    </div>
                </div>

                <aside class="space-y-4 lg:sticky lg:top-24 lg:self-start">
                    <div class="ui-card p-5">
                        <span class="ui-icon-box">@svg('heroicon-o-shield-check', 'h-5 w-5')</span>
                        <h2 class="mt-4 font-bold text-gray-950">Antes de crear la cuenta</h2>
                        <ul class="mt-3 space-y-3 text-sm leading-6 text-gray-600">
                            <li>Verifica que el correo no pertenezca a otra cuenta.</li>
                            <li>Confirma el rol: determina permisos y datos requeridos.</li>
                            <li>Entrega la contraseña por un canal seguro.</li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                        <p id="nota-campos-obligatorios"><strong>Campos obligatorios:</strong> están identificados con un asterisco rojo.</p>
                    </div>
                </aside>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                document.getElementById('resumen-errores')?.focus();

                const roleSelect = document.getElementById('rol_id');
                const profileSection = document.getElementById('perfil-data');
                const profileForms = [...document.querySelectorAll("#perfil-data [id$='-fields'], #perfil-data [id$='-data']")];

                const syncRoleFields = () => {
                    const role = roleSelect.options[roleSelect.selectedIndex]?.dataset.rolNombre;
                    profileSection.classList.toggle('hidden', !role);
                    profileForms.forEach(form => form.classList.toggle('hidden', !role || ![`${role}-fields`, `${role}-data`].includes(form.id)));
                };

                roleSelect.addEventListener('change', syncRoleFields);
                syncRoleFields();

                const department = document.getElementById('departamento');
                const province = document.getElementById('provincia');
                const district = document.getElementById('distrito');
                if (!department || !province || !district) return;

                let locations = [];
                try {
                    const response = await fetch("{{ asset('ubigeo.json') }}");
                    if (!response.ok) throw new Error('No se pudo cargar el catálogo de ubicaciones.');
                    locations = await response.json();
                } catch (error) {
                    console.error(error);
                    return;
                }

                const previous = @js([
                    'department' => old('departamento'),
                    'province' => old('provincia'),
                    'district' => old('distrito'),
                ]);

                const fill = (select, values, selected = '') => {
                    select.innerHTML = '<option value="">Seleccione</option>';
                    values.forEach(value => select.add(new Option(value, value, false, value === selected)));
                    select.disabled = values.length === 0;
                };
                const syncProvinces = (selected = '') => {
                    const item = locations.find(value => value.nombre === department.value);
                    fill(province, item?.provincias.map(value => value.nombre) ?? [], selected);
                };
                const syncDistricts = (selected = '') => {
                    const item = locations.find(value => value.nombre === department.value);
                    const selectedProvince = item?.provincias.find(value => value.nombre === province.value);
                    fill(district, selectedProvince?.distritos ?? [], selected);
                };

                fill(department, locations.map(value => value.nombre), previous.department);
                if (previous.department) syncProvinces(previous.province);
                if (previous.province) syncDistricts(previous.district);

                department.addEventListener('change', () => { syncProvinces(); fill(district, []); });
                province.addEventListener('change', () => syncDistricts());
            });
        </script>
    @endpush
</x-app-layout>
