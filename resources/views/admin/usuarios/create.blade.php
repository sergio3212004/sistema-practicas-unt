<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Encabezado -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-800 to-blue-900 rounded-2xl shadow-lg p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">
                            Crear Nuevo Usuario
                        </h1>
                        <p class="text-blue-100 text-sm">
                            Complete el formulario para registrar un nuevo usuario en el sistema
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="mb-6">
            <a href="{{ route('admin.usuarios.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-800 text-sm font-medium rounded-lg shadow-sm border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Listado
            </a>
        </div>

        <!-- Formulario Principal -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            <form action="{{ route('admin.usuarios.store') }}" method="POST" class="p-8">
                @csrf

                <!-- Mensajes de Error -->
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-lg p-5 shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-red-800 font-semibold mb-2">Se encontraron los siguientes errores:</h3>
                                <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Sección: Datos de Acceso -->
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-600 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Datos de Acceso</h2>
                        </div>

                        <div class="space-y-5">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Institucional
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           placeholder="ejemplo@unitru.edu.pe"
                                           class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                </div>
                            </div>

                            <!-- Contraseñas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Contraseña
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </div>
                                        <input type="password"
                                               name="password"
                                               required
                                               placeholder="••••••••"
                                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Confirmar Contraseña
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <input type="password"
                                               name="password_confirmation"
                                               required
                                               placeholder="••••••••"
                                               class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    </div>
                                </div>
                            </div>

                            <!-- Rol -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rol del Usuario
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <select name="rol_id"
                                            id="rol_id"
                                            required
                                            class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                        <option value="">Seleccione un Rol</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}"
                                                    data-rol-nombre="{{ $rol->nombre }}"
                                                {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                                {{ ucfirst($rol->nombre) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">
                                    Seleccione el rol que determinará los permisos del usuario
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Datos Específicos del Rol -->
                <div id="perfil-data" class="hidden mb-8">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 shadow-sm">
                        <div class="flex items-center mb-6">
                            <div class="bg-indigo-600 rounded-lg p-2 mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Información del Perfil</h2>
                        </div>

                        <x-alumno-form />
                        <x-administrador-form />
                        <x-empresa-form :usuario="$usuario ?? null" :razonesSociales="$razonesSociales"/>
                        <x-profesor-form />
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Crear Usuario
                    </button>

                    <a href="{{ route('admin.usuarios.index') }}"
                       class="sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-4 bg-white text-gray-700 font-semibold rounded-xl shadow border border-gray-300 hover:bg-gray-50 hover:shadow-md transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

        <!-- Información Adicional -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        <span class="font-semibold">Nota:</span> Los campos marcados con <span class="text-red-500">*</span> son obligatorios.
                        Asegúrese de completar toda la información antes de enviar el formulario.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", async () => {

        /* ============================================================
           1) CONTROL DINÁMICO DE FORMULARIOS SEGÚN ROL
           ============================================================ */

        const rolSelect = document.getElementById("rol_id");
        const perfilData = document.getElementById("perfil-data");

        const formularios = document.querySelectorAll("#perfil-data [id$='-fields'], #perfil-data [id$='-data']");

        const mostrarCamposSegunRol = () => {
            const rolNombre = rolSelect.options[rolSelect.selectedIndex]?.dataset.rolNombre;

            // Oculta todo si no hay rol
            if (!rolNombre) {
                perfilData.classList.add("hidden");
                formularios.forEach(f => f.classList.add("hidden"));
                return;
            }

            perfilData.classList.remove("hidden");

            formularios.forEach(f => {
                const esFormularioDelRol =
                    f.id === `${rolNombre}-fields` || f.id === `${rolNombre}-data`;

                f.classList.toggle("hidden", !esFormularioDelRol);
            });
        };

        rolSelect.addEventListener("change", mostrarCamposSegunRol);
        mostrarCamposSegunRol();



        /* ============================================================
           2) UBIGEO DINÁMICO (Departamento → Provincia → Distrito)
           ============================================================ */

        const departamentoSelect = document.getElementById("departamento");
        const provinciaSelect = document.getElementById("provincia");
        const distritoSelect = document.getElementById("distrito");

        // Si no existe formulario de empresa, parar aquí
        if (!departamentoSelect) return;

        let ubigeo = [];
        try {
            ubigeo = await fetch("{{ asset('ubigeo.json') }}").then(res => res.json());
        } catch (error) {
            console.error("Error cargando ubigeo.json:", error);
            return;
        }

        // Cargar departamentos
        ubigeo.forEach(dep => {
            const option = document.createElement("option");
            option.value = dep.nombre;
            option.textContent = dep.nombre;
            departamentoSelect.appendChild(option);
        });

        // Cambia provincias al seleccionar departamento
        departamentoSelect.addEventListener("change", () => {
            provinciaSelect.innerHTML = '<option value="">Seleccione</option>';
            distritoSelect.innerHTML = '<option value="">Seleccione</option>';
            provinciaSelect.disabled = true;
            distritoSelect.disabled = true;

            const dep = ubigeo.find(d => d.nombre === departamentoSelect.value);
            if (!dep) return;

            dep.provincias.forEach(prov => {
                const option = document.createElement("option");
                option.value = prov.nombre;
                option.textContent = prov.nombre;
                provinciaSelect.appendChild(option);
            });
            provinciaSelect.disabled = false;
        });

        // Cambia distritos al seleccionar provincia
        provinciaSelect.addEventListener("change", () => {
            distritoSelect.innerHTML = '<option value="">Seleccione</option>';
            distritoSelect.disabled = true;

            const dep = ubigeo.find(d => d.nombre === departamentoSelect.value);
            if (!dep) return;

            const prov = dep.provincias.find(p => p.nombre === provinciaSelect.value);
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
