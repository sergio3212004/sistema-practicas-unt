<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-document-plus', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Nueva Ficha de Registro
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Completa el formulario para registrar tu práctica pre profesional</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Contenedor principal -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200">

                <!-- Encabezado oficial -->
                <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-8 py-8">
                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-xl">
                                @svg('heroicon-o-academic-cap', 'w-12 h-12 text-blue-800')
                            </div>
                        </div>
                        <h1 class="text-2xl font-bold text-white mb-2">
                            FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS
                        </h1>
                        <h2 class="text-xl font-semibold text-blue-100 mb-2">
                            PROGRAMA DE INFORMÁTICA
                        </h2>
                        <h3 class="text-lg font-medium text-blue-200 mb-1">
                            MONITOREO DE PRÁCTICAS PRE PROFESIONALES
                        </h3>
                        <div class="inline-block bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-bold text-sm mt-3 shadow-lg">
                            FORMATO 01: FICHA DE REGISTRO
                        </div>
                    </div>
                </div>

                <div class="p-8">

                    <!-- Alerta de errores -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-red-600')
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-red-800 mb-2">Por favor, corrija los siguientes errores:</h4>
                                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('alumno.ficha-registro.store') }}" id="formFicha">
                        @csrf

                        <!-- Sección 1: ESTUDIANTE -->
                        <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-user', 'w-5 h-5 mr-2')
                                    1. ESTUDIANTE
                                </h3>
                            </div>

                            <div class="p-6 bg-blue-50">
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Apellidos y Nombres
                                    </label>
                                    <input type="text"
                                           value="{{ $alumno->nombre_completo }}"
                                           disabled
                                           class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700 font-medium">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nro. Matrícula
                                        </label>
                                        <input type="text"
                                               value="{{ $alumno->codigo_matricula }}"
                                               disabled
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Ciclo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number"
                                               name="ciclo"
                                               min="1"
                                               max="10"
                                               value="{{ old('ciclo') }}"
                                               required
                                               placeholder="Ej: 8"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Semestre
                                        </label>
                                        <input type="text"
                                               value="{{ $semestreActual->nombre }}"
                                               disabled
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                        <input type="hidden" name="semestre_id" value="{{ $semestreActual->id }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Teléfono Celular
                                        </label>
                                        <input type="text"
                                               value="{{ $alumno->telefono }}"
                                               disabled
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Correo Electrónico
                                        </label>
                                        <input type="email"
                                               value="{{ $alumno->user->email }}"
                                               disabled
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 2: EMPRESA O INSTITUCIÓN -->
                        <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-building-office', 'w-5 h-5 mr-2')
                                    2. EMPRESA O INSTITUCIÓN
                                </h3>
                            </div>

                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nombre de la Empresa <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="nombre_empresa"
                                               value="{{ old('nombre_empresa') }}"
                                               placeholder="Ejemplo: Empresa Comercial"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Razón Social <span class="text-red-500">*</span>
                                        </label>
                                        <select name="razon_social_id"
                                                required
                                                class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                            <option value="">Seleccione</option>
                                            @foreach($razonesSociales as $razon)
                                                <option value="{{ $razon->id }}" {{ old('razon_social_id') == $razon->id ? 'selected' : '' }}>
                                                    {{ $razon->acronimo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Electrónico de la Empresa <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email"
                                           name="correo_empresa"
                                           id="correo_empresa"
                                           placeholder="empresa@ejemplo.com"
                                           value="{{ old('correo_empresa') }}"
                                           required
                                           class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('correo_empresa') border-red-500 @enderror">
                                    @error('correo_empresa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            RUC <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="ruc"
                                               maxlength="11"
                                               pattern="[0-9]{11}"
                                               placeholder="10258369871"
                                               value="{{ old('ruc') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('ruc') border-red-500 @enderror">
                                        @error('ruc')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Gerente General <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="nombre_gerente"
                                               value="{{ old('nombre_gerente') }}"
                                               placeholder="Nombre completo"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jefe de RRHH <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="nombre_jefe_rrhh"
                                           value="{{ old('nombre_jefe_rrhh') }}"
                                           placeholder="Nombre completo del jefe de RRHH"
                                           required
                                           class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Dirección <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="direccion"
                                           value="{{ old('direccion') }}"
                                           placeholder="Dirección completa de la empresa"
                                           required
                                           class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Teléfono Fijo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="telefono_fijo"
                                               value="{{ old('telefono_fijo') }}"
                                               placeholder="044-123456"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Teléfono Celular <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="telefono_movil"
                                               value="{{ old('telefono_movil') }}"
                                               placeholder="912345678"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                    <!-- Departamento fijo -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Departamento <span class="text-red-500">*</span>
                                        </label>

                                        <select disabled
                                                class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 cursor-not-allowed">
                                            <option value="La Libertad">La Libertad</option>
                                        </select>

                                        <!-- Campo oculto para no romper backend -->
                                        <input type="hidden" name="departamento" value="La Libertad">
                                    </div>

                                    <!-- Provincia -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Provincia <span class="text-red-500">*</span>
                                        </label>
                                        <select name="provincia"
                                                id="provincia"
                                                required
                                                class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>

                                    <!-- Distrito -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Distrito <span class="text-red-500">*</span>
                                        </label>
                                        <select name="distrito"
                                                id="distrito"
                                                required
                                                disabled
                                                class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100">
                                            <option value="">Seleccione</option>
                                        </select>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Sección 3: CARACTERÍSTICAS DE LA PRÁCTICA -->
                        <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2')
                                    3. CARACTERÍSTICAS DE LA PRÁCTICA
                                </h3>
                            </div>

                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Fecha de Inicio <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date"
                                               name="fecha_inicio"
                                               value="{{ old('fecha_inicio') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Fecha de Término <span class="text-red-500">*</span>
                                        </label>
                                        <input type="date"
                                               name="fecha_termino"
                                               value="{{ old('fecha_termino') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>

                                <!-- Horarios -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Días y Horario <span class="text-red-500">*</span>
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg p-4 overflow-x-auto">
                                        <table class="min-w-full">
                                            <thead class="bg-blue-800">
                                            <tr>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Lunes</th>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Martes</th>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Miércoles</th>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Jueves</th>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Viernes</th>
                                                <th class="border border-blue-200 px-3 py-3 text-xs font-bold text-white uppercase">Sábado</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @for($dia = 1; $dia <= 6; $dia++)
                                                    <td class="border border-blue-200 px-3 py-3 bg-blue-50">
                                                        <div class="flex items-center mb-3">
                                                            <input type="checkbox"
                                                                   id="dia_{{ $dia }}"
                                                                   onchange="toggleHorario({{ $dia }})"
                                                                   class="w-4 h-4 text-blue-800 border-gray-300 rounded focus:ring-blue-500 mr-2">
                                                            <label for="dia_{{ $dia }}" class="text-xs font-medium text-gray-700">Activar</label>
                                                        </div>
                                                        <div id="horario_{{ $dia }}" class="hidden space-y-2">
                                                            <div>
                                                                <label class="block text-xs font-semibold text-gray-700 mb-1">De:</label>
                                                                <input type="time"
                                                                       name="horarios[{{ $dia }}][hora_inicio]"
                                                                       class="w-full px-2 py-2 text-xs border-2 border-blue-200 rounded focus:ring-2 focus:ring-blue-500">
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-semibold text-gray-700 mb-1">A:</label>
                                                                <input type="time"
                                                                       name="horarios[{{ $dia }}][hora_fin]"
                                                                       class="w-full px-2 py-2 text-xs border-2 border-blue-200 rounded focus:ring-2 focus:ring-blue-500">
                                                            </div>
                                                            <input type="hidden"
                                                                   name="horarios[{{ $dia }}][dia_semana]"
                                                                   value="{{ $dia }}">
                                                        </div>
                                                    </td>
                                                @endfor
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Descripción de la Práctica <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="descripcion"
                                              rows="4"
                                              required
                                              placeholder="Describa brevemente las actividades y funciones que realizará el practicante"
                                              class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('descripcion') }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Área de Prácticas <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="area_practicas"
                                               placeholder="Ej. Desarrollo de Software"
                                               value="{{ old('area_practicas') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Cargo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="cargo"
                                               placeholder="Ej. Practicante de Desarrollo"
                                               value="{{ old('cargo') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Jefe Directo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="nombre_jefe_directo"
                                               value="{{ old('nombre_jefe_directo') }}"
                                               placeholder="Nombre completo"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Celular de Jefe Directo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text"
                                               name="telefono_jefe_directo"
                                               value="{{ old('telefono_jefe_directo') }}"
                                               required
                                               placeholder="912345678"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Correo de Jefe Directo <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email"
                                               name="correo_jefe_directo"
                                               placeholder="jefe@ejemplo.com"
                                               value="{{ old('correo_jefe_directo') }}"
                                               required
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección 4: FIRMAS -->
                        <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2')
                                    4. FIRMAS Y APROBACIONES
                                </h3>
                            </div>

                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <!-- VB Empresa -->
                                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center">
                                        <p class="text-sm font-bold text-gray-800 mb-4 uppercase">
                                            VB° de la Empresa
                                        </p>
                                        <div class="h-24 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center mb-3">
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-10 h-10 text-gray-400 mx-auto mb-1')
                                                <span class="text-gray-400 text-xs block">Pendiente</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-medium">
                                            Representante Legal<br/>
                                            <span class="text-gray-500">(Firma y Sello)</span>
                                        </p>
                                    </div>

                                    <!-- Firma Practicante -->
                                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center">
                                        <p class="text-sm font-bold text-gray-800 mb-4 uppercase">
                                            Firma del Practicante <span class="text-red-500">*</span>
                                        </p>
                                        <canvas id="canvasFirma"
                                                class="border-2 border-blue-300 rounded-lg cursor-crosshair mx-auto bg-white shadow-sm"
                                                width="220"
                                                height="96">
                                        </canvas>
                                        <input type="hidden" name="firma_practicante" id="firmaPracticante">
                                        <button type="button"
                                                onclick="limpiarFirma()"
                                                class="mt-3 inline-flex items-center px-4 py-2 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition-all">
                                            @svg('heroicon-o-arrow-path', 'w-4 h-4 mr-1')
                                            Limpiar firma
                                        </button>
                                    </div>

                                    <!-- VB Programa -->
                                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center">
                                        <p class="text-sm font-bold text-gray-800 mb-4 uppercase">
                                            VB° del Programa
                                        </p>
                                        <div class="h-24 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center mb-3">
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-10 h-10 text-gray-400 mx-auto mb-1')
                                                <span class="text-gray-400 text-xs block">Pendiente</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-medium">
                                            Coordinador de Prácticas<br/>
                                            <span class="text-gray-500">(Firma y Sello)</span>
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 bg-blue-100 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-information-circle', 'w-5 h-5 text-blue-700')
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex flex-wrap justify-between items-center gap-4 pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('alumno.ficha.index') }}"
                               class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm group">
                                @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform')
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-800 to-blue-900 border-2 border-blue-800 rounded-xl text-white font-semibold hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                                @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2 group-hover:rotate-12 transition-transform')
                                Guardar Ficha de Registro
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @svg('heroicon-o-light-bulb', 'w-6 h-6 text-blue-600')
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-blue-800 mb-2">Consejos para completar el formulario</h4>
                        <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                            <li>Asegúrate de tener toda la información de la empresa antes de comenzar</li>
                            <li>Los campos marcados con <span class="text-red-500">*</span> son obligatorios</li>
                            <li>Verifica que los correos electrónicos sean correctos para recibir las firmas digitales</li>
                            <li>Una vez enviada, tu ficha será revisada por el coordinador académico</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            // ==========================================
            // CANVAS PARA FIRMA
            // ==========================================
            const canvas = document.getElementById('canvasFirma');
            const ctx = canvas.getContext('2d');
            let dibujando = false;

            // Eventos de mouse
            canvas.addEventListener('mousedown', iniciarDibujo);
            canvas.addEventListener('mousemove', dibujar);
            canvas.addEventListener('mouseup', detenerDibujo);
            canvas.addEventListener('mouseout', detenerDibujo);

            // Eventos táctiles para dispositivos móviles
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                const mouseEvent = new MouseEvent('mousedown', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            });

            canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent('mousemove', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            });

            canvas.addEventListener('touchend', (e) => {
                e.preventDefault();
                const mouseEvent = new MouseEvent('mouseup', {});
                canvas.dispatchEvent(mouseEvent);
            });

            function iniciarDibujo(e) {
                dibujando = true;
                const rect = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
            }

            function dibujar(e) {
                if (!dibujando) return;
                const rect = canvas.getBoundingClientRect();
                ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
                ctx.strokeStyle = '#000000'; // Azul oscuro
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.stroke();
            }

            function detenerDibujo() {
                dibujando = false;
            }

            function limpiarFirma() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('firmaPracticante').value = '';
            }

            // ==========================================
            // TOGGLE DE HORARIOS
            // ==========================================
            function toggleHorario(dia) {
                const checkbox = document.getElementById('dia_' + dia);
                const horarioDiv = document.getElementById('horario_' + dia);
                const inputs = horarioDiv.querySelectorAll('input[type="time"]');

                if (checkbox.checked) {
                    horarioDiv.classList.remove('hidden');
                    inputs.forEach(input => input.required = true);
                } else {
                    horarioDiv.classList.add('hidden');
                    inputs.forEach(input => {
                        input.required = false;
                        input.value = '';
                    });
                }
            }

            // ==========================================
            // VALIDACIÓN DEL FORMULARIO
            // ==========================================
            document.getElementById('formFicha').addEventListener('submit', function(e) {
                // Guardar firma en base64
                const firmaData = canvas.toDataURL('image/png');
                document.getElementById('firmaPracticante').value = firmaData;

                // Validar que haya firma
                const ctx = canvas.getContext('2d');
                const pixelBuffer = new Uint32Array(
                    ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
                );
                const hayFirma = pixelBuffer.some(color => color !== 0);

                if (!hayFirma) {
                    e.preventDefault();
                    alert('Por favor, firma en el recuadro correspondiente antes de enviar el formulario.');
                    return false;
                }

                // Validar que al menos un horario esté seleccionado
                const horariosActivos = Array.from({length: 6}, (_, i) => i + 1)
                    .filter(dia => document.getElementById('dia_' + dia).checked);

                if (horariosActivos.length === 0) {
                    e.preventDefault();
                    alert('Debes seleccionar al menos un día de práctica con su horario correspondiente.');
                    return false;
                }

                // Remover horarios no seleccionados del formulario
                for (let dia = 1; dia <= 6; dia++) {
                    if (!document.getElementById('dia_' + dia).checked) {
                        const inputs = document.querySelectorAll(`[name^="horarios[${dia}]"]`);
                        inputs.forEach(input => input.remove());
                    }
                }

                // Mostrar loading
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Guardando...';
            });

            // ==========================================
            // CARGA DE UBIGEO
            // ==========================================
            document.addEventListener('DOMContentLoaded', async function () {

            const provinciaSelect = document.getElementById("provincia");
            const distritoSelect = document.getElementById("distrito");

            let ubigeo = [];

            try {
            ubigeo = await fetch("{{ asset('ubigeo.json') }}")
            .then(res => res.json());
        } catch (error) {
            console.error("Error cargando ubigeo.json:", error);
            return;
        }

            // Buscar La Libertad
            const laLibertad = ubigeo.find(d => d.nombre === "La Libertad");

            if (!laLibertad) {
            console.error("No se encontró La Libertad en ubigeo.json");
            return;
        }

            // Cargar provincias automáticamente
            laLibertad.provincias.forEach(prov => {
            const option = document.createElement("option");
            option.value = prov.nombre;
            option.textContent = prov.nombre;
            provinciaSelect.appendChild(option);
        });

            // Cambio de provincia
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
            distritoSelect.classList.remove('bg-gray-100');
        });

        });


        </script>
    @endpush

</x-app-layout>
