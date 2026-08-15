<x-app-layout :title="'Ficha · '.$fichaRegistro->alumno->nombre_completo">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Documentación de prácticas" title="Ficha de registro" :description="$fichaRegistro->alumno->nombre_completo.' · '.$fichaRegistro->alumno->codigo_matricula" icon="heroicon-o-document-text">
            <x-slot name="actions"><a href="{{ route('profesor.aulas.show', $fichaRegistro->alumno->aula) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al aula</a>@if($fichaRegistro->aceptado === true)<span class="ui-badge-success">Ficha aceptada</span>@elseif($fichaRegistro->aceptado === false)<span class="ui-badge-danger">Ficha rechazada</span>@else<span class="ui-badge-warning">Pendiente de revisión</span>@endif</x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">

            <!-- Contenedor principal con estilo formal -->
            <div class="ui-card overflow-hidden">

                <!-- Encabezado oficial de la universidad -->
                <div class="bg-blue-900 px-8 py-8">
                    <div class="text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm">
                                @svg('heroicon-o-academic-cap', 'w-12 h-12 text-blue-800')
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-white mb-2">
                            FACULTAD DE CIENCIAS FÍSICAS Y MATEMÁTICAS
                        </p>
                        <p class="text-xl font-semibold text-blue-100 mb-2">
                            PROGRAMA DE INFORMÁTICA
                        </p>
                        <p class="text-lg font-medium text-blue-200 mb-1">
                            MONITOREO DE PRÁCTICAS PRE PROFESIONALES
                        </p>
                        <div class="inline-block bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-bold text-sm mt-3 shadow-sm">
                            FORMATO 01: FICHA DE REGISTRO
                        </div>
                    </div>
                </div>

                <div class="p-8">

                    <!-- Sección 1: ESTUDIANTE -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-blue-900 px-6 py-3">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-user', 'w-5 h-5 mr-2')
                                1. ESTUDIANTE
                            </h2>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="mb-4">
                                <p class="block text-sm font-semibold text-gray-700 mb-2">
                                    Apellidos y Nombres
                                </p>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                    {{ $fichaRegistro->alumno->nombre_completo }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nro. Matrícula
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->alumno->codigo_matricula }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Ciclo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->ciclo }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Semestre
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->semestre->nombre }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Celular
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-phone', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->alumno->telefono }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Electrónico
                                    </p>
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
                        <div class="bg-blue-900 px-6 py-3">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-building-office', 'w-5 h-5 mr-2')
                                2. EMPRESA O INSTITUCIÓN
                            </h2>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Razón Social
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                        {{ $fichaRegistro->razon_social }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        RUC
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->ruc }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Gerente General
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_gerente }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jefe de RRHH
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_jefe_rrhh }}
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="block text-sm font-semibold text-gray-700 mb-2">
                                    Dirección
                                </p>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-map-pin', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $fichaRegistro->direccion }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Fijo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_fijo ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Teléfono Móvil
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_movil ?? 'No especificado' }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo Empresa
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                        {{ $fichaRegistro->correo_empresa ?? 'No especificado' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Departamento
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->departamento }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Provincia
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->provincia }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Distrito
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->distrito }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 3: CARACTERÍSTICAS DE LA PRÁCTICA -->
                    <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-blue-900 px-6 py-3">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2')
                                3. CARACTERÍSTICAS DE LA PRÁCTICA
                            </h2>
                        </div>

                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fecha de Inicio
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->fecha_inicio->format('d/m/Y') }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Fecha de Término
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                        @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                        {{ $fichaRegistro->fecha_termino->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Días y Horarios en Tabla -->
                            <div class="mb-4">
                                <p class="block text-sm font-semibold text-gray-700 mb-2">Días y Horarios</p>

                                <table class="w-full border-collapse">
                                    <caption class="sr-only">Días y horarios de práctica</caption>
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
                                                {{ $fichaRegistro->horarios->firstWhere('dia_semana', $dia)?->hora_inicio ?? '____' }}
                                            </td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <td class="border border-blue-300 p-2 text-center font-semibold">A:</td>
                                        @for ($dia = 1; $dia <= 6; $dia++)
                                            <td class="border border-blue-300 p-2 text-center">
                                                {{ $fichaRegistro->horarios->firstWhere('dia_semana', $dia)?->hora_fin ?? '____' }}
                                            </td>
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="mb-4">
                                <p class="block text-sm font-semibold text-gray-700 mb-2">
                                    Descripción de la Práctica
                                </p>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 min-h-[100px]">
                                    {{ $fichaRegistro->descripcion }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Área de Prácticas
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->area_practicas }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Cargo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->cargo }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jefe Directo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->nombre_jefe_directo }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Celular de Jefe Directo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                        {{ $fichaRegistro->telefono_jefe_directo }}
                                    </div>
                                </div>
                                <div>
                                    <p class="block text-sm font-semibold text-gray-700 mb-2">
                                        Correo de Jefe Directo
                                    </p>
                                    <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                        {{ $fichaRegistro->correo_jefe_directo }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección 4: FIRMAS -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-blue-900 px-6 py-3">
                            <h2 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2')
                                4. FIRMAS Y APROBACIONES
                            </h2>
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
                        <a href="{{ route('profesor.aulas.show', $fichaRegistro->alumno->aula) }}" class="ui-btn-secondary">
                            @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform')
                            Volver al inicio
                        </a>

                        <div class="flex gap-3">
                            <!-- Botón de eliminar (solo si no está aceptado) -->
                            @if($fichaRegistro->aceptado === null)
                            <form method="POST"
                                  action="{{ route('profesor.fichas.rechazar', $fichaRegistro) }}"
                                  onsubmit="return confirm('¿Rechazar esta ficha de registro?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="ui-btn-danger">
                                    Rechazar Ficha
                                </button>

                            </form>

                            @endif

                            @if($fichaRegistro->aceptado === null)
                            <form method="POST"
                                  action="{{ route('profesor.fichas.aceptar', $fichaRegistro) }}"
                                  onsubmit="return confirm('¿Aceptar esta ficha de registro?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="ui-btn-primary">
                                    Aceptar ficha
                                </button>

                            </form>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

            <!-- Información adicional -->
            @if($fichaRegistro->aceptado === null)
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


</x-app-layout>
