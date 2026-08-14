<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-document-text', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Ficha de Registro - Vista Completa
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Formato 01: Ficha de Registro de Prácticas Pre Profesionales</p>
                </div>
            </div>

            <!-- Badge de estado -->
            <div>
                @if($fichaRegistro->aceptado)
                    <span class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-full shadow-lg">
                        @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2')
                        Ficha Aceptada
                    </span>
                @elseif(!$fichaRegistro->aceptado)
                    <span class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-full shadow-lg">
                        @svg('heroicon-o-x-circle', 'w-5 h-5 mr-2')
                        Ficha rechazada, comunicate con tu profesor asignado
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 bg-yellow-400 text-gray-900 text-sm font-semibold rounded-full shadow-lg">
                        @svg('heroicon-o-clock', 'w-5 h-5 mr-2')
                        En Proceso de Validación
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Contenedor principal con estilo formal -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-gray-200">

                <!-- Encabezado oficial de la universidad -->
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
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                    {{ $fichaRegistro->alumno->nombre_completo }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nro. Matrícula
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->alumno->codigo_matricula }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Ciclo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->ciclo }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Semestre
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->semestre->nombre }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Celular
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-phone', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->alumno->telefono }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Electrónico
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-envelope', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->alumno->user->email }}
                                    </div>
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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Razón Social
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                        {{ $fichaRegistro->razon_social }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        RUC
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->ruc }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Gerente General
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_gerente }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jefe de RRHH
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_jefe_rrhh }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Dirección
                                </label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-map-pin', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $fichaRegistro->direccion }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Fijo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_fijo ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Móvil
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_movil ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Empresa
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                        {{ $fichaRegistro->correo_empresa ?? 'No especificado' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Departamento
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->departamento }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Provincia
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->provincia }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Distrito
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->distrito }}
                                    </div>
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
                                        Fecha de Inicio
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fecha de Término
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->fecha_termino->format('d/m/Y') }}
                                    </div>
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
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Descripción de la Práctica
                                </label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 min-h-[100px]">
                                    {{ $fichaRegistro->descripcion }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Área de Prácticas
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->area_practicas }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Cargo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->cargo }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jefe Directo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_jefe_directo }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Celular de Jefe Directo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_jefe_directo }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo de Jefe Directo
                                    </label>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                        {{ $fichaRegistro->correo_jefe_directo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: FIRMAS -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2')
                                4. FIRMAS Y APROBACIONES
                            </h3>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Firma Empresa -->
                                <div class="bg-white border-2 border-blue-200 rounded-xl p-6">
                                    <p class="text-sm font-bold text-center text-gray-800 mb-4 uppercase">
                                        VB° de la Empresa
                                    </p>
                                    <div class="h-32 flex items-center justify-center border-b-2 border-gray-400 mb-3">
                                        @if($fichaRegistro->firma_empresa)
                                            <img src="{{ asset('storage/firmas/ficha-registro/' . $fichaRegistro->firma_empresa) }}"
                                                 alt="Firma Empresa" class="max-h-28 mx-auto">
                                        @else
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-12 h-12 text-gray-400 mx-auto mb-2')
                                                <span class="text-gray-400 text-sm block">Pendiente de firma</span>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-xs text-center text-gray-600 font-medium">
                                        Representante Legal<br/>
                                        <span class="text-gray-500">(Firma y Sello)</span>
                                    </p>
                                </div>

                                <!-- Firma Programa -->
                                <div class="bg-white border-2 border-blue-200 rounded-xl p-6">
                                    <p class="text-sm font-bold text-center text-gray-800 mb-4 uppercase">
                                        VB° del Programa
                                    </p>
                                    <div class="h-32 flex items-center justify-center border-b-2 border-gray-400 mb-3">
                                        @if($fichaRegistro->firma_programa)
                                            <img src="{{ asset('storage/firmas/ficha-registro/' . $fichaRegistro->firma_programa) }}"
                                                 alt="Firma Programa" class="max-h-28 mx-auto">
                                        @else
                                            <div class="text-center">
                                                @svg('heroicon-o-clock', 'w-12 h-12 text-gray-400 mx-auto mb-2')
                                                <span class="text-gray-400 text-sm block">Pendiente de firma</span>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-xs text-center text-gray-600 font-medium">
                                        Coordinador de Prácticas<br/>
                                        <span class="text-gray-500">(Firma y Sello)</span>
                                    </p>
                                </div>

                                <!-- Firma Practicante -->
                                <div class="bg-white border-2 border-blue-200 rounded-xl p-6">
                                    <p class="text-sm font-bold text-center text-gray-800 mb-4 uppercase">
                                        Firma del Practicante
                                    </p>
                                    <div class="h-32 flex items-center justify-center border-b-2 border-gray-400 mb-3">
                                        @if($fichaRegistro->firma_practicante)
                                            <img src="{{ asset('storage/firmas/ficha-registro/' . $fichaRegistro->firma_practicante) }}"
                                                 alt="Firma Practicante" class="max-h-28 mx-auto">
                                        @else
                                            <div class="text-center">
                                                @svg('heroicon-o-x-circle', 'w-12 h-12 text-gray-400 mx-auto mb-2')
                                                <span class="text-gray-400 text-sm block">Sin firma</span>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="text-xs text-center text-gray-600 font-medium">
                                        Alumno Practicante<br/>
                                        <span class="text-gray-500">(Firma)</span>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-wrap justify-between items-center gap-4 mt-8 pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('alumno.ficha.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm group">
                            @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform')
                            Volver al inicio
                        </a>

                        <div class="flex gap-3">
                            <!-- Botón de eliminar (solo si no está aceptado) -->
                            @if(!$fichaRegistro->aceptado)
                                <button onclick="confirmarEliminacion()"
                                        class="inline-flex items-center px-6 py-3 bg-red-600 border-2 border-red-600 rounded-xl text-white font-semibold hover:bg-red-700 hover:border-red-700 transition-all duration-200 shadow-lg group">
                                    @svg('heroicon-o-trash', 'w-5 h-5 mr-2 group-hover:scale-110 transition-transform')
                                    Eliminar Ficha
                                </button>

                                <!-- Formulario oculto para eliminación -->
                                <form id="form-eliminar" action="{{ route('alumno.ficha.destroy', $fichaRegistro) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif

                            <!-- Botón de descargar PDF -->
                            <a href="{{ route('alumno.ficha.download-pdf', $fichaRegistro->id) }}"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-800 to-blue-900 border-2 border-blue-800 rounded-xl text-white font-semibold hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                                @svg('heroicon-o-arrow-down-tray', 'w-5 h-5 mr-2 group-hover:translate-y-1 transition-transform')
                                Descargar PDF
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Información adicional -->
            @if(!$fichaRegistro->aceptado)
                <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6 shadow-md">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            @svg('heroicon-o-information-circle', 'w-6 h-6 text-yellow-600')
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-bold text-yellow-800 mb-2">Nota importante</h4>
                            <p class="text-sm text-yellow-700">
                                Esta ficha está en proceso de validación. Una vez que sea aceptada por el coordinador, no podrás eliminarla.
                                Asegúrate de que todos los datos sean correctos antes de la aprobación.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            function confirmarEliminacion() {
                if (confirm('¿Estás seguro de que deseas eliminar esta ficha de registro?\n\nEsta acción no se puede deshacer y perderás toda la información registrada.')) {
                    document.getElementById('form-eliminar').submit();
                }
            }
        </script>
    @endpush

</x-app-layout>
