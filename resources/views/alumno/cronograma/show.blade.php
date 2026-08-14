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
                    <p class="text-sm text-gray-500 mt-0.5">Vista detallada de tu cronograma</p>
                </div>
            </div>
            @if(!$cronograma->firma_profesor)
                <form action="{{ route('alumno.cronograma.destroy', $cronograma) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('¿Estás seguro de eliminar este cronograma? Esta acción no se puede deshacer.')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-all">
                        @svg('heroicon-o-trash', 'w-4 h-4 mr-1') Eliminar Cronograma
                    </button>
                </form>
            @endif
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
                        <div class="flex flex-col items-center mt-4 space-y-4">
                            <div class="inline-block bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-bold text-sm shadow-lg">
                                FORMATO 02: PLAN DE PRÁCTICAS
                            </div>

                            <!-- Estado global de firmas -->
                            @if($cronograma->estaFirmadoCompleto())
                                <div class="inline-flex items-center px-5 py-2.5 bg-green-100 rounded-full border border-green-300">
                                    @svg('heroicon-o-check-circle', 'w-5 h-5 text-green-600 mr-2')
                                    <span class="font-semibold text-green-800">Cronograma Completado y Firmado</span>
                                </div>
                            @else
                                <div class="inline-flex items-center px-5 py-2.5 bg-yellow-100 rounded-full border border-yellow-300">
                                    @svg('heroicon-o-clock', 'w-5 h-5 text-yellow-600 mr-2')
                                    <span class="font-semibold text-yellow-800">Firmas Pendientes</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-8">


                    <!-- 1. ESTUDIANTE -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-user', 'w-5 h-5 mr-2') 1. ESTUDIANTE
                            </h3>
                        </div>
                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Apellidos y Nombre</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->alumno->nombre_completo }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nro. Matrícula</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->alumno->codigo_matricula }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ciclo</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->ciclo }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Año y Semestre</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->semestre->nombre ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. EMPRESA -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-building-office', 'w-5 h-5 mr-2') 2. EMPRESA O INSTITUCIÓN
                            </h3>
                        </div>
                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Razón Social</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->razon_social }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">RUC</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->ruc }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->direccion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CARACTERÍSTICAS -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2') 3. CARACTERÍSTICAS DE LA PRÁCTICA
                            </h3>
                        </div>
                        <div class="p-6 bg-blue-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Inicio</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->fecha_inicio->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Término</label>
                                    <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->fecha_termino->format('d/m/Y') }}</p>
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
                                                    $horario = $cronograma->fichaRegistro->horarios->firstWhere('dia_semana', $dia);
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
                                                    $horario = $cronograma->fichaRegistro->horarios->firstWhere('dia_semana', $dia);
                                                @endphp
                                                {{ $horario ? $horario->hora_fin : '____' }}
                                            </td>
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Área de Prácticas</label>
                                <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $cronograma->fichaRegistro->area_practicas }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. ACTIVIDADES -->
                    <div class="border-2 border-blue-200 rounded-xl overflow-hidden mb-8">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-list-bullet', 'w-5 h-5 mr-2') 4. ACTIVIDADES PRINCIPALES
                            </h3>
                        </div>
                        <div class="p-6 bg-blue-50">
                            @foreach($cronograma->actividades as $index => $actividad)
                                <div class="mb-6 p-4 border-2 border-blue-200 rounded-lg bg-white">
                                    <h4 class="font-semibold text-gray-800 mb-3">Actividad {{ $index + 1 }}</h4>
                                    <div class="mb-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                                        <p class="px-4 py-3 bg-white border-2 border-blue-200 rounded-lg">{{ $actividad->actividad }}</p>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full border border-blue-200 text-sm">
                                            <thead class="bg-blue-800 text-white">
                                            <tr>
                                                @for($i = 1; $i <= 4; $i++)
                                                    <th class="border border-blue-200 px-2 py-2" colspan="4">Mes {{ $i }}</th>
                                                @endfor
                                            </tr>
                                            <tr>
                                                @for($i = 1; $i <= 16; $i++)
                                                    <th class="border border-blue-200 px-2 py-1 bg-blue-100 text-gray-800">S{{ ($i - 1) % 4 + 1 }}</th>
                                                @endfor
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @for($mes = 1; $mes <= 4; $mes++)
                                                    @for($sem = 1; $sem <= 4; $sem++)
                                                        <td class="border border-blue-200 px-2 py-2 text-center">
                                                            @if($actividad->{"m{$mes}_s{$sem}"})
                                                                <span class="text-green-600 font-bold">✓</span>
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                    @endfor
                                                @endfor
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Estado de firmas -->

                    <div class="mb-8 bg-blue-50 border-2 border-blue-200 rounded-xl overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2') Estado de Firmas
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Practicante -->
                                <div class="bg-white border-2 border-blue-200 rounded-lg p-4 text-center">
                                    <p class="text-sm font-medium text-gray-800 mb-2">Firma del Practicante</p>
                                    @if($cronograma->firma_practicante)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($cronograma->firma_practicante) }}" alt="Firma Practicante" class="mx-auto h-16 object-contain">
                                    @else
                                        <span class="text-gray-500 text-xs">Pendiente</span>
                                    @endif
                                </div>

                                <!-- Jefe Directo -->
                                <div class="bg-white border-2 border-blue-200 rounded-lg p-4 text-center">
                                    <p class="text-sm font-medium text-gray-800 mb-2">VB° Jefe Directo</p>
                                    @if($cronograma->firma_jefe_directo)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($cronograma->firma_jefe_directo) }}" alt="Firma Jefe" class="mx-auto h-16 object-contain">
                                    @else
                                        <span class="text-yellow-600 text-xs">Esperando firma</span>
                                    @endif
                                </div>

                                <!-- Profesor Supervisor -->
                                <div class="bg-white border-2 border-blue-200 rounded-lg p-4 text-center">
                                    <p class="text-sm font-medium text-gray-800 mb-2">VB° Profesor Supervisor</p>
                                    @if($cronograma->firma_profesor)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($cronograma->firma_profesor) }}" alt="Firma Profesor" class="mx-auto h-16 object-contain">
                                    @else
                                        <span class="text-yellow-600 text-xs">Esperando firma</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones finales -->
                    <div class="flex flex-wrap justify-between items-center gap-4 pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('alumno.ficha.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm group">
                            @svg('heroicon-o-arrow-left', 'w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform')
                            Volver
                        </a>
                        <a href="{{ route('alumno.cronograma.download-pdf', $cronograma->id) }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-800 to-blue-900 text-white font-semibold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                            @svg('heroicon-o-arrow-down-tray', 'w-5 h-5 mr-2')
                            Descargar PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
