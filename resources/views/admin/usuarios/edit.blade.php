<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 md:p-10 rounded-xl shadow-2xl my-4 sm:my-8 max-h-[90vh] overflow-y-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Editar Usuario</h1>
        <a href="{{ route('admin.usuarios.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">&larr; Volver al Listado</a>

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Errores -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">¡Ocurrió un error!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Datos de Acceso -->
            <div class="space-y-6 mb-8 p-6 bg-indigo-50 rounded-lg border border-indigo-200">
                <h2 class="text-xl font-semibold text-indigo-700 border-b pb-2">Datos de Acceso</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 p-2 border shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Rol del Usuario</label>
                    <select name="rol_id" id="rol_id"
                            class="mt-1 block w-full rounded-md border-gray-300 p-2 border shadow-sm">
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id }}"
                                    @selected(old('rol_id', $usuario->rol_id) == $rol->id)
                                    data-rol-nombre="{{ $rol->nombre }}">
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Perfil -->
            <div id="perfil-data" class="space-y-6 mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200 hidden">
                <h2 class="text-xl font-semibold text-gray-700 border-b pb-2">
                    Datos del Perfil (<span id="rol-name-display" class="font-bold text-indigo-600"></span>)
                </h2>

                <x-administrador-form :admin="$usuario->administrador" />
                <x-alumno-form :alumno="$usuario->alumno" />
                <x-empresa-form :empresa="$usuario->empresa" :razonesSociales="$razonesSociales" />
                <x-profesor-form :profesor="$usuario->profesor" />

            </div>

            <button type="submit"
                    class="w-full px-4 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-lg">
                Actualizar Usuario
            </button>

        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const rolSelect = document.getElementById("rol_id");
        const perfilData = document.getElementById("perfil-data");

        const alumnoFields = document.getElementById("alumno-fields");
        const adminFields = document.getElementById("administrador-fields");
        const empresaFields = document.getElementById("empresa-data");
        const profesorFields = document.getElementById("profesor-fields");


        const rolNameDisplay = document.getElementById("rol-name-display");

        const departamentoSelect = document.getElementById("departamento");
        const provinciaSelect = document.getElementById("provincia");
        const distritoSelect = document.getElementById("distrito");

        let ubigeo = [];

        try {
            ubigeo = await fetch("{{ asset('ubigeo.json') }}").then(res => res.json());
        } catch (error) {
            console.error("Error cargando ubigeo.json:", error);
        }

        const oldDepartamento = "{{ old('departamento', $usuario->empresa->departamento ?? '') }}";
        const oldProvincia = "{{ old('provincia', $usuario->empresa->provincia ?? '') }}";
        const oldDistrito = "{{ old('distrito', $usuario->empresa->distrito ?? '') }}";

        function cargarDepartamentos() {
            departamentoSelect.innerHTML = '<option value="">Seleccione</option>';
            ubigeo.forEach(dep => {
                const option = document.createElement("option");
                option.value = dep.nombre;
                option.textContent = dep.nombre;
                if (oldDepartamento === dep.nombre) option.selected = true;
                departamentoSelect.appendChild(option);
            });
            if (oldDepartamento) cargarProvincias(oldDepartamento);
        }

        function cargarProvincias(nombreDepartamento) {
            provinciaSelect.innerHTML = '<option value="">Seleccione</option>';
            provinciaSelect.disabled = false;
            const dep = ubigeo.find(d => d.nombre === nombreDepartamento);
            if (!dep) return;
            dep.provincias.forEach(prov => {
                const option = document.createElement("option");
                option.value = prov.nombre;
                option.textContent = prov.nombre;
                if (oldProvincia === prov.nombre) option.selected = true;
                provinciaSelect.appendChild(option);
            });
            if (oldProvincia) cargarDistritos(nombreDepartamento, oldProvincia);
        }

        function cargarDistritos(nombreDepartamento, nombreProvincia) {
            distritoSelect.innerHTML = '<option value="">Seleccione</option>';
            distritoSelect.disabled = false;
            const dep = ubigeo.find(d => d.nombre === nombreDepartamento);
            if (!dep) return;
            const provincia = dep.provincias.find(p => p.nombre === nombreProvincia);
            if (!provincia) return;
            provincia.distritos.forEach(dist => {
                const option = document.createElement("option");
                option.value = dist;
                option.textContent = dist;
                if (oldDistrito === dist) option.selected = true;
                distritoSelect.appendChild(option);
            });
        }

        departamentoSelect?.addEventListener("change", () => {
            cargarProvincias(departamentoSelect.value);
            distritoSelect.innerHTML = '<option value="">Seleccione</option>';
            distritoSelect.disabled = true;
        });

        provinciaSelect?.addEventListener("change", () => {
            cargarDistritos(departamentoSelect.value, provinciaSelect.value);
        });

        function mostrarCamposSegunRol() {
            const selectedOption = rolSelect.options[rolSelect.selectedIndex];
            const rolNombre = selectedOption.dataset.rolNombre?.trim().toLowerCase();

            rolNameDisplay.textContent = rolNombre ?? "";

            perfilData.classList.remove("hidden");

            adminFields.classList.add("hidden");
            alumnoFields.classList.add("hidden");
            empresaFields.classList.add("hidden");
            profesorFields?.classList.add("hidden");


            if (rolNombre === "administrador") adminFields.classList.remove("hidden");
            if (rolNombre === "alumno") alumnoFields.classList.remove("hidden");

            if (rolNombre === "empresa") {
                empresaFields.classList.remove("hidden");
                cargarDepartamentos();
            }

            if (rolNombre === "profesor") profesorFields.classList.remove("hidden");

        }


        rolSelect.addEventListener("change", mostrarCamposSegunRol);
        mostrarCamposSegunRol();
        if (oldDepartamento) cargarDepartamentos();
    });
</script>
