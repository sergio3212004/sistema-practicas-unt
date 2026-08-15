<x-app-layout :title="'Editar · '.($usuario->nombre ?: $usuario->email)">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración"
            title="Editar usuario"
            :description="'Actualiza la cuenta y el perfil de '.$usuario->email.'.'"
            icon="heroicon-o-pencil-square"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.usuarios.show', $usuario) }}" class="ui-btn-secondary">@svg('heroicon-o-eye', 'h-4 w-4') Ver usuario</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-5xl">
        <x-ui.form-errors />

        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <section class="ui-card overflow-hidden">
                <div class="ui-card-header">
                    <x-ui.section-heading
                        title="Cuenta y permisos"
                        description="El correo identifica la cuenta. Cambiar el rol también cambia el tipo de perfil asociado."
                        icon="heroicon-o-key"
                    />
                </div>
                <div class="ui-card-body grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="email" class="ui-label">Correo electrónico <span class="text-red-500" aria-hidden="true">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email', $usuario->email) }}" autocomplete="email" class="ui-field" required>
                    </div>
                    <div>
                        <label for="rol_id" class="ui-label">Rol del usuario <span class="text-red-500" aria-hidden="true">*</span></label>
                        <select id="rol_id" name="rol_id" class="ui-field" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id }}" data-rol-nombre="{{ $rol->nombre }}" @selected(old('rol_id', $usuario->rol_id) == $rol->id)>{{ ucfirst($rol->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section id="perfil-data" class="ui-card overflow-hidden" aria-labelledby="perfil-titulo">
                <div class="ui-card-header">
                    <x-ui.section-heading
                        title="Información del perfil"
                        description="Editando los datos correspondientes al rol seleccionado."
                        icon="heroicon-o-identification"
                    >
                        <x-slot name="actions"><span id="rol-name-display" class="ui-badge-info"></span></x-slot>
                    </x-ui.section-heading>
                </div>
                <div class="ui-card-body">
                    <x-administrador-form :admin="$usuario->administrador" />
                    <x-alumno-form :alumno="$usuario->alumno" />
                    <x-empresa-form :empresa="$usuario->empresa" :razonesSociales="$razonesSociales" />
                    <x-profesor-form :profesor="$usuario->profesor" />
                </div>
            </section>

            <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.usuarios.show', $usuario) }}" class="ui-btn-secondary">Cancelar</a>
                <button type="submit" class="ui-btn-primary">@svg('heroicon-o-check', 'h-4 w-4') Guardar cambios</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                document.getElementById('resumen-errores')?.focus();

                const roleSelect = document.getElementById('rol_id');
                const roleLabel = document.getElementById('rol-name-display');
                const profileForms = [...document.querySelectorAll("#perfil-data [id$='-fields'], #perfil-data [id$='-data']")];

                const syncRoleFields = () => {
                    const role = roleSelect.options[roleSelect.selectedIndex]?.dataset.rolNombre?.trim().toLowerCase();
                    roleLabel.textContent = role ? role.charAt(0).toUpperCase() + role.slice(1) : 'Sin rol';
                    profileForms.forEach(form => form.classList.toggle('hidden', ![`${role}-fields`, `${role}-data`].includes(form.id)));
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
                    'department' => old('departamento', $usuario->empresa?->departamento),
                    'province' => old('provincia', $usuario->empresa?->provincia),
                    'district' => old('distrito', $usuario->empresa?->distrito),
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
