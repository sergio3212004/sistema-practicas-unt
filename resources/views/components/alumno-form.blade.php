@props(['alumno' => null])

<div id="alumno-fields" class="hidden">
    <div class="space-y-6">

        <!-- Código de Matrícula -->
        <div>
            <label for="codigo_matricula_alumno" class="ui-label">
                Código de Matrícula
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <input type="text"
                       id="codigo_matricula_alumno"
                       name="codigo_matricula_alumno"
                       value="{{ old('codigo_matricula_alumno', $alumno->codigo_matricula ?? '') }}"
                       placeholder="Ej: 2020123456"
                       class="ui-field pl-10">
            </div>
        </div>

        <!-- Datos personales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="nombres_alumno" class="ui-label">
                    Nombres
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="nombres_alumno"
                           name="nombres_alumno"
                           autocomplete="given-name"
                           value="{{ old('nombres_alumno', $alumno->nombres ?? '') }}"
                           placeholder="Nombres completos"
                           class="ui-field pl-10">
                </div>
            </div>

            <div>
                <label for="apellido_paterno_alumno" class="ui-label">
                    Apellido Paterno
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="apellido_paterno_alumno"
                           name="apellido_paterno_alumno"
                           value="{{ old('apellido_paterno_alumno', $alumno->apellido_paterno ?? '') }}"
                           placeholder="Apellido paterno"
                           class="ui-field pl-10">
                </div>
            </div>

            <div>
                <label for="apellido_materno_alumno" class="ui-label">
                    Apellido Materno
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="apellido_materno_alumno"
                           name="apellido_materno_alumno"
                           value="{{ old('apellido_materno_alumno', $alumno->apellido_materno ?? '') }}"
                           placeholder="Apellido materno"
                           class="ui-field pl-10">
                </div>
            </div>

            <div>
                <label for="telefono_alumno" class="ui-label">
                    Teléfono
                    <span class="text-gray-400 text-xs">(opcional)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input type="text"
                           id="telefono_alumno"
                           name="telefono_alumno"
                           inputmode="tel"
                           autocomplete="tel"
                           value="{{ old('telefono_alumno', $alumno->telefono ?? '') }}"
                           placeholder="Ej: 987654321"
                           class="ui-field pl-10">
                </div>
            </div>
        </div>

    </div>
</div>
