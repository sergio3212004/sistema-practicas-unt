<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-clipboard-document-list', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Plan de Prácticas Pre Profesionales
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Completa el cronograma de tu práctica</p>
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
                            FORMATO 02: PLAN DE PRÁCTICAS
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @svg('heroicon-o-exclamation-triangle', 'w-6 h-6 text-red-600')
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-red-800 mb-2">Corrija los siguientes errores:</h4>
                                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form id="formCronograma" action="{{ route('alumno.cronograma.store', $fichaRegistro) }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- 1. ESTUDIANTE -->
                        <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-user', 'w-5 h-5 mr-2') 1. ESTUDIANTE
                                </h3>
                            </div>
                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Apellidos y Nombre</label>
                                        <input type="text" value="{{ $fichaRegistro->alumno->nombre_completo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nro. Matrícula</label>
                                        <input type="text" value="{{ $fichaRegistro->alumno->codigo_matricula }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ciclo</label>
                                        <input type="text" value="{{ $fichaRegistro->ciclo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Año y Semestre</label>
                                        <input type="text" value="{{ $fichaRegistro->semestre->nombre ?? 'N/A' }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Celular</label>
                                        <input type="text" value="{{ $fichaRegistro->alumno->telefono }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                                        <input type="email" value="{{ $fichaRegistro->alumno->user->email }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. EMPRESA -->
                        <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-building-office', 'w-5 h-5 mr-2') 2. EMPRESA O INSTITUCIÓN
                                </h3>
                            </div>
                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Razón Social</label>
                                        <input type="text" value="{{ $fichaRegistro->razon_social->acronimo ?? 'N/A' }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">RUC</label>
                                        <input type="text" value="{{ $fichaRegistro->ruc }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gerente General</label>
                                        <input type="text" value="{{ $fichaRegistro->nombre_gerente }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jefe de RRHH</label>
                                        <input type="text" value="{{ $fichaRegistro->nombre_jefe_rrhh }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                                        <input type="text" value="{{ $fichaRegistro->direccion }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Fijo</label>
                                        <input type="text" value="{{ $fichaRegistro->telefono_fijo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Móvil</label>
                                        <input type="text" value="{{ $fichaRegistro->telefono_movil }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                                        <input type="text" value="{{ $fichaRegistro->departamento }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Provincia</label>
                                        <input type="text" value="{{ $fichaRegistro->provincia }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Distrito</label>
                                        <input type="text" value="{{ $fichaRegistro->distrito }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. CARACTERÍSTICAS DE LA PRÁCTICA -->
                        <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2') 3. CARACTERÍSTICAS DE LA PRÁCTICA
                                </h3>
                            </div>
                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Inicio</label>
                                        <input type="text" value="{{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Término</label>
                                        <input type="text" value="{{ $fichaRegistro->fecha_termino->format('d/m/Y') }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                </div>

                                <!-- Días y Horarios en Tabla -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Días y Horarios</label>

                                    <table class="w-full border-collapse">
                                        <thead>
                                        <tr class="bg-blue-100">
                                            <th class="border border-blue-300 p-2 text-center font-semibold">HORA</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">LUNES</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">MARTES</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">MIÉRCOLES</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">JUEVES</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">VIERNES</th>
                                            <th class="border border-blue-300 p-2 text-center font-semibold">SÁBADO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="border border-blue-300 p-2 text-center font-semibold">De:</td>
                                            @for ($dia = 1; $dia <= 6; $dia++)
                                                <td class="border border-blue-300 p-2 text-center">
                                                    @php
                                                        $horario = $fichaRegistro->horarios->firstWhere('dia_semana', $dia);
                                                    @endphp
                                                    {{ $horario ? $horario->hora_inicio : '____' }}
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td class="border border-blue-300 p-2 text-center font-semibold">A:</td>
                                            @for ($dia = 1; $dia <= 6; $dia++)
                                                <td class="border border-blue-300 p-2 text-center">
                                                    @php
                                                        $horario = $fichaRegistro->horarios->firstWhere('dia_semana', $dia);
                                                    @endphp
                                                    {{ $horario ? $horario->hora_fin : '____' }}
                                                </td>
                                            @endfor
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción de la Práctica</label>
                                    <textarea rows="4"
                                              class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700"
                                              readonly>{{ $fichaRegistro->descripcion }}</textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Área de Prácticas</label>
                                        <input type="text" value="{{ $fichaRegistro->area_practicas }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                                        <input type="text" value="{{ $fichaRegistro->cargo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del Jefe Directo</label>
                                        <input type="text" value="{{ $fichaRegistro->nombre_jefe_directo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Celular del Jefe</label>
                                        <input type="text" value="{{ $fichaRegistro->telefono_jefe_directo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo del Jefe</label>
                                        <input type="email" value="{{ $fichaRegistro->correo_jefe_directo }}"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg bg-gray-100 text-gray-700" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. ACTIVIDADES PRINCIPALES -->
                        <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-list-bullet', 'w-5 h-5 mr-2') 4. ACTIVIDADES PRINCIPALES
                                </h3>
                            </div>
                            <div class="p-6 bg-blue-50">
                                <div id="contenedorActividades">
                                    <div class="actividad-item mb-6 p-4 border-2 border-blue-200 rounded-lg bg-white" data-index="0">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="font-semibold text-gray-800">Actividad 1</h4>
                                            <button type="button" onclick="eliminarActividad(0)"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium hidden">
                                                Eliminar
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                Descripción de la actividad <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="actividades[0][nombre]" rows="2" required
                                                      class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                      placeholder="Describe la actividad a realizar...">{{ old('actividades.0.nombre') }}</textarea>
                                        </div>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full border border-blue-200 text-sm">
                                                <thead class="bg-blue-800 text-white">
                                                <tr>
                                                    <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 1</th>
                                                    <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 2</th>
                                                    <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 3</th>
                                                    <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 4</th>
                                                </tr>
                                                <tr>
                                                    @for($i = 1; $i <= 16; $i++)
                                                        <th class="border border-blue-200 px-2 py-1 bg-blue-100 text-gray-800">
                                                            S{{ ($i - 1) % 4 + 1 }}
                                                        </th>
                                                    @endfor
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    @for($mes = 1; $mes <= 4; $mes++)
                                                        @for($sem = 1; $sem <= 4; $sem++)
                                                            <td class="border border-blue-200 px-2 py-2 text-center">
                                                                <input type="checkbox"
                                                                       name="actividades[0][semanas][]"
                                                                       value="m{{ $mes }}_s{{ $sem }}"
                                                                       class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-blue-300 rounded"
                                                                    {{ in_array("m{$mes}_s{$sem}", old('actividades.0.semanas', [])) ? 'checked' : '' }}>
                                                            </td>
                                                        @endfor
                                                    @endfor
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" onclick="agregarActividad()"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-all">
                                    @svg('heroicon-o-plus', 'w-4 h-4 mr-1') Agregar Actividad
                                </button>
                                <p class="text-xs text-gray-600 mt-2">Máximo 20 actividades</p>
                            </div>
                        </div>

                        <!-- 5. FIRMA DEL PRACTICANTE -->
                        <!-- Sección 5: FIRMAS Y APROBACIONES -->
                        <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                                <h3 class="text-lg font-bold text-white flex items-center">
                                    @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2') 5. FIRMAS Y APROBACIONES
                                </h3>
                            </div>

                            <div class="p-6 bg-blue-50">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <!-- Firma del Practicante -->
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

                                    <!-- VB Jefe Directo -->
                                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center">
                                        <p class="text-sm font-bold text-gray-800 mb-4 uppercase">
                                            VB° del Jefe Directo
                                        </p>
                                        <div class="h-24 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center mb-3">
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-10 h-10 text-gray-400 mx-auto mb-1')
                                                <span class="text-gray-400 text-xs block">Pendiente</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-medium">
                                            {{ $fichaRegistro->nombre_jefe_directo }}<br/>
                                            <span class="text-gray-500">(Firma y Sello)</span>
                                        </p>
                                    </div>

                                    <!-- VB Profesor Supervisor -->
                                    <div class="bg-white border-2 border-blue-200 rounded-xl p-6 text-center">
                                        <p class="text-sm font-bold text-gray-800 mb-4 uppercase">
                                            VB° del Profesor Supervisor
                                        </p>
                                        <div class="h-24 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center mb-3">
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-10 h-10 text-gray-400 mx-auto mb-1')
                                                <span class="text-gray-400 text-xs block">Pendiente</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-600 font-medium">
                                            {{ $fichaRegistro->alumno->aula->profesor->nombre_completo }}<br/>
                                            <span class="text-gray-500">(Firma y Sello)</span>
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 bg-blue-100 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-information-circle', 'w-5 h-5 text-blue-700')
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-xs text-blue-800">
                                                <strong>Nota:</strong> Tras firmar y enviar este cronograma el profesor supervisor revisará tu Cronograma y se enviará un correo electrónico automáticamente a:
                                            </p>
                                            <ul class="list-disc list-inside mt-1 text-xs text-blue-700">
                                                <li><strong>Jefe Directo:</strong> {{ $fichaRegistro->correo_jefe_directo }}</li>
                                            </ul>

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
                                Crear Cronograma y Firmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Consejos -->
            <div class="mt-6 bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6 shadow-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @svg('heroicon-o-light-bulb', 'w-6 h-6 text-blue-600')
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-bold text-blue-800 mb-2">Consejos para completar el cronograma</h4>
                        <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                            <li>Define actividades específicas, medibles y alineadas a tu perfil profesional</li>
                            <li>Asigna semanas realistas según la duración de tu práctica</li>
                            <li>Verifica que hayas completado al menos una semana por actividad</li>
                            <li>No olvides firmar al final: sin firma, el cronograma no será procesado</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let contadorActividades = 1;
            const maxActividades = 20;

            // === Firma digital ===
            const canvas = document.getElementById('canvasFirma');
            const ctx = canvas.getContext('2d');
            let dibujando = false;

            function getMousePos(canvas, evt) {
                const rect = canvas.getBoundingClientRect();
                return {
                    x: evt.clientX - rect.left,
                    y: evt.clientY - rect.top
                };
            }

            canvas.addEventListener('mousedown', (e) => {
                dibujando = true;
                const pos = getMousePos(canvas, e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });

            canvas.addEventListener('mousemove', (e) => {
                if (!dibujando) return;
                const pos = getMousePos(canvas, e);
                ctx.lineTo(pos.x, pos.y);
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';
                ctx.stroke();
            });

            canvas.addEventListener('mouseup', () => dibujando = false);
            canvas.addEventListener('mouseout', () => dibujando = false);

            // Touch para móviles
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
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
                canvas.dispatchEvent(new MouseEvent('mouseup'));
            });

            function limpiarFirma() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('firmaPracticante').value = '';
            }

            // === Gestión de actividades ===
            function agregarActividad() {
                if (contadorActividades >= maxActividades) {
                    alert('Solo puedes agregar hasta 5 actividades.');
                    return;
                }

                const container = document.getElementById('contenedorActividades');
                const index = contadorActividades;
                const html = `
            <div class="actividad-item mb-6 p-4 border-2 border-blue-200 rounded-lg bg-white" data-index="${index}">
                <div class="flex justify-between items-start mb-3">
                    <h4 class="font-semibold text-gray-800">Actividad ${index + 1}</h4>
                    <button type="button" onclick="eliminarActividad(${index})"
                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                        Eliminar
                    </button>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Descripción de la actividad <span class="text-red-500">*</span>
                    </label>
                    <textarea name="actividades[${index}][nombre]" rows="2" required
                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Describe la actividad a realizar..."></textarea>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-blue-200 text-sm">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 1</th>
                                <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 2</th>
                                <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 3</th>
                                <th class="border border-blue-200 px-2 py-2" colspan="4">Mes 4</th>
                            </tr>
                            <tr>
                                ${Array(16).fill().map((_, i) => `<th class="border border-blue-200 px-2 py-1 bg-blue-100 text-gray-800">S${(i % 4) + 1}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                ${Array(4).fill().map((_, mes) =>
                    Array(4).fill().map((_, sem) =>
                        `<td class="border border-blue-200 px-2 py-2 text-center">
                                            <input type="checkbox"
                                                name="actividades[${index}][semanas][]"
                                                value="m${mes + 1}_s${sem + 1}"
                                                class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-blue-300 rounded">
                                        </td>`
                    ).join('')
                ).join('')}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>`;

                container.insertAdjacentHTML('beforeend', html);
                contadorActividades++;
            }

            function eliminarActividad(index) {
                const item = document.querySelector(`[data-index="${index}"]`);
                if (item) {
                    item.remove();
                    contadorActividades--;
                    actualizarNumeracion();
                }
            }

            function actualizarNumeracion() {
                document.querySelectorAll('.actividad-item').forEach((item, idx) => {
                    item.querySelector('h4').textContent = `Actividad ${idx + 1}`;
                });
            }

            // === Validación ===
            document.getElementById('formCronograma').addEventListener('submit', function(e) {
                // Firma
                const firmaData = canvas.toDataURL('image/png');
                document.getElementById('firmaPracticante').value = firmaData;

                const pixelBuffer = new Uint32Array(
                    ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
                );
                const hayFirma = pixelBuffer.some(color => color !== 0);
                if (!hayFirma) {
                    e.preventDefault();
                    alert('Por favor, firma en el recuadro antes de enviar.');
                    return false;
                }

                // Validar al menos una semana por actividad
                const actividades = document.querySelectorAll('.actividad-item');
                let valido = true;
                actividades.forEach((act, idx) => {
                    const checks = act.querySelectorAll('input[type="checkbox"]:checked');
                    if (checks.length === 0) {
                        alert(`La Actividad ${idx + 1} debe tener al menos una semana seleccionada.`);
                        valido = false;
                    }
                });

                if (!valido) {
                    e.preventDefault();
                    return false;
                }

                // Loading
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Enviando...';
            });
        </script>
    @endpush
</x-app-layout>
