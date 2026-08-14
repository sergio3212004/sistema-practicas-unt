<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">

            {{--<!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif--}}

            <!-- Encabezado con estado -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">PLAN DE PRÁCTICAS PRE-PROFESIONALES</h1>
                        <p class="text-sm mt-1">FORMATO 02: PLAN DE PRÁCTICAS</p>
                    </div>
                    <div class="text-right">
                        @if($cronograma->estaFirmadoCompleto())
                            <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                                ✓ Completado
                            </span>
                        @else
                            <span class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-full text-sm font-semibold">
                                ⏳ Firmas Pendientes
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Estado de Firmas -->
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h3 class="font-semibold text-gray-800 mb-3">Estado de Firmas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Firma Practicante -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_practicante)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    ✓
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Practicante</p>
                                    <p class="text-xs text-gray-600">Firmado</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    ✗
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Practicante</p>
                                    <p class="text-xs text-gray-500">Pendiente</p>
                                </div>
                            @endif
                        </div>

                        <!-- Firma Jefe -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_jefe_directo)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    ✓
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Jefe Directo</p>
                                    <p class="text-xs text-gray-600">Firmado</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    ⏳
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Jefe Directo</p>
                                    <p class="text-xs text-yellow-600">Esperando firma</p>
                                </div>
                            @endif
                        </div>

                        <!-- Firma Profesor -->
                        <div class="flex items-center space-x-3">
                            @if($cronograma->firma_profesor)
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    ✓
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Profesor Supervisor</p>
                                    <p class="text-xs text-gray-600">Firmado</p>
                                </div>
                            @else
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    ⏳
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700">Profesor Supervisor</p>
                                    <p class="text-xs text-yellow-600">Esperando firma</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Calificación -->
                @if($cronograma->calificacion !== null)
                    <div class="px-6 py-4 bg-blue-50 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">Calificación del Plan de Prácticas</h3>
                                <p class="text-sm text-gray-600">Evaluación final del cronograma</p>
                            </div>
                            <div class="text-right">
                                <span class="text-4xl font-bold text-blue-600">{{ number_format($cronograma->calificacion, 1) }}</span>
                                <p class="text-sm text-gray-600">/ 20</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Contenido del cronograma -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
                <!-- 1. ESTUDIANTE -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        1. ESTUDIANTE
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos y Nombre</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->alumno->nombre_completo }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nro. Matrícula</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->alumno->codigo_matricula }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ciclo</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->ciclo }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Año y Semestre</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->semestre->nombre ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2. EMPRESA -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        2. EMPRESA O INSTITUCIÓN
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Razón Social</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->razon_social }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RUC</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->ruc }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->direccion }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 3. CARACTERÍSTICAS -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        3. CARACTERÍSTICAS DE LA PRÁCTICA
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->fecha_inicio->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Término</label>
                            <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                                {{ $cronograma->fichaRegistro->fecha_termino->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Horarios -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Días y Horario</label>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Día</th>
                                    <th class="border border-gray-300 px-4 py-2">Horario</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                @endphp
                                @foreach($cronograma->fichaRegistro->horarios as $horario)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2 font-medium">
                                            {{ $dias[$horario->dia_semana - 1] }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            De {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Área de Prácticas</label>
                        <p class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                            {{ $cronograma->fichaRegistro->area_practicas }}
                        </p>
                    </div>
                </div>

                <!-- 4. ACTIVIDADES PRINCIPALES -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-blue-500 pb-2">
                        4. ACTIVIDADES PRINCIPALES A REALIZARSE EN LA PRÁCTICA
                    </h2>

                    @foreach($cronograma->actividades as $index => $actividad)
                        <div class="mb-6 p-4 border border-gray-300 rounded-lg bg-gray-50">
                            <h3 class="font-semibold text-lg text-gray-700 mb-3">Actividad {{ $index + 1 }}</h3>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <p class="px-3 py-2 bg-white border border-gray-200 rounded-md">
                                    {{ $actividad->actividad }}
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-300 text-sm">
                                    <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 1</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 2</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 3</th>
                                        <th class="border border-gray-300 px-2 py-1" colspan="4">Mes 4</th>
                                    </tr>
                                    <tr>
                                        @for($i = 1; $i <= 4; $i++)
                                            @for($j = 1; $j <= 4; $j++)
                                                <th class="border border-gray-300 px-2 py-1 bg-gray-100">S{{ $j }}</th>
                                            @endfor
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @for($mes = 1; $mes <= 4; $mes++)
                                            @for($semana = 1; $semana <= 4; $semana++)
                                                @php
                                                    $campo = "m{$mes}_s{$semana}";
                                                    $marcado = $actividad->$campo;
                                                @endphp
                                                <td class="border border-gray-300 px-2 py-2 text-center {{ $marcado ? 'bg-green-100' : '' }}">
                                                    @if($marcado)
                                                        <span class="text-green-600 font-bold text-lg">✓</span>
                                                    @else
                                                        <span class="text-gray-300">-</span>
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

                <!-- Sección de Firmas -->
                <div class="border-t-2 border-gray-300 pt-6 mt-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">Firmas</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- VB° Jefe Inmediato -->
                        <div class="text-center">
                            @if($cronograma->firma_jefe_directo)
                                <img src="{{ Storage::url($cronograma->firma_jefe_directo) }}"
                                     alt="Firma Jefe Directo"
                                     class="mx-auto h-24 object-contain mb-2">
                            @else
                                <p class="text-yellow-600 text-sm font-medium mb-2">Pendiente</p>
                            @endif
                            <div class="border-t-2 border-gray-400 my-2"></div>
                            <p class="font-medium text-sm">VB° Jefe Inmediato</p>
                            <p class="text-xs text-gray-600">(Firma y Sello)</p>
                        </div>

                        <!-- Firma del Practicante -->
                        <div class="text-center">
                            @if($cronograma->firma_practicante)
                                <img src="{{ Storage::url($cronograma->firma_practicante) }}"
                                     alt="Firma Practicante"
                                     class="mx-auto h-24 object-contain mb-2">
                            @else
                                <p class="text-yellow-600 text-sm font-medium mb-2">Pendiente</p>
                            @endif
                            <div class="border-t-2 border-gray-400 my-2"></div>
                            <p class="font-medium text-sm">Firma del Practicante</p>
                        </div>

                        <!-- VB° Profesor Supervisor -->
                        <div class="text-center">
                            @if($cronograma->firma_profesor)
                                <img src="{{ Storage::url($cronograma->firma_profesor) }}"
                                     alt="Firma Profesor"
                                     class="mx-auto h-24 object-contain mb-2">
                            @else
                                <p class="text-yellow-600 text-sm font-medium mb-2">Pendiente</p>
                            @endif
                            <div class="border-t-2 border-gray-400 my-2"></div>
                            <p class="font-medium text-sm">VB° Profesor Supervisor</p>
                            <p class="text-xs text-gray-600">(Firma)</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Firma -->
                @if(!$cronograma->firma_profesor)
                    <form id="formFirma"
                          method="POST"
                          action="{{ route('profesor.cronogramas.firmar', $cronograma) }}"
                          class="bg-white shadow rounded-lg p-6 mt-8">

                        @csrf

                        <h3 class="text-lg font-bold mb-4">
                            Firma del Profesor Supervisor
                        </h3>

                        <input type="hidden" name="firma" id="firmaJefe">

                        <div class="border border-gray-400 rounded-md p-2 inline-block">
                            <canvas id="canvasFirma"
                                    width="500"
                                    height="150"
                                    class="bg-white"></canvas>
                        </div>

                        <div class="mt-4 flex gap-4">
                            <button type="button"
                                    onclick="limpiarFirma()"
                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                Limpiar
                            </button>

                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Firmar Cronograma
                            </button>
                        </div>
                    </form>
                @endif

                <!-- Formulario de Calificación -->
                @if($cronograma->estaFirmadoCompleto() && $cronograma->calificacion === null)
                    <form method="POST"
                          action="{{ route('profesor.cronogramas.calificar', $cronograma) }}"
                          class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">

                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-bold text-gray-800 mb-4">
                            Calificar Plan de Prácticas
                        </h3>

                        <p class="text-sm text-gray-600 mb-4">
                            El cronograma está completamente firmado. Ahora puede asignar una calificación.
                        </p>

                        <div class="max-w-xs">
                            <label for="calificacion" class="block text-sm font-medium text-gray-700 mb-2">
                                Calificación (0-20)
                            </label>
                            <input type="number"
                                   name="calificacion"
                                   id="calificacion"
                                   step="0.5"
                                   min="0"
                                   max="20"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ej: 18.5">
                            @error('calificacion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                Registrar Calificación
                            </button>
                        </div>
                    </form>
                @endif

                <!-- Botones de acción -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('profesor.aulas.show', $cronograma->fichaRegistro->alumno->aula) }}"
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
        }
    </style>

    <script>
        const canvas = document.getElementById('canvasFirma');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            let dibujando = false;

            canvas.addEventListener('mousedown', iniciarDibujo);
            canvas.addEventListener('mousemove', dibujar);
            canvas.addEventListener('mouseup', detenerDibujo);
            canvas.addEventListener('mouseout', detenerDibujo);

            canvas.addEventListener('touchstart', e => {
                e.preventDefault();
                const t = e.touches[0];
                canvas.dispatchEvent(new MouseEvent('mousedown', {
                    clientX: t.clientX,
                    clientY: t.clientY
                }));
            });

            canvas.addEventListener('touchmove', e => {
                e.preventDefault();
                const t = e.touches[0];
                canvas.dispatchEvent(new MouseEvent('mousemove', {
                    clientX: t.clientX,
                    clientY: t.clientY
                }));
            });

            canvas.addEventListener('touchend', e => {
                e.preventDefault();
                canvas.dispatchEvent(new MouseEvent('mouseup'));
            });

            function iniciarDibujo(e) {
                dibujando = true;
                const r = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(e.clientX - r.left, e.clientY - r.top);
            }

            function dibujar(e) {
                if (!dibujando) return;
                const r = canvas.getBoundingClientRect();
                ctx.lineTo(e.clientX - r.left, e.clientY - r.top);
                ctx.strokeStyle = '#000';
                ctx.lineWidth = 2;
                ctx.stroke();
            }

            function detenerDibujo() {
                dibujando = false;
            }

            window.limpiarFirma = function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('firmaJefe').value = '';
            }

            document.getElementById('formFirma').addEventListener('submit', function(e) {
                const firmaData = canvas.toDataURL('image/png');
                document.getElementById('firmaJefe').value = firmaData;

                const pixels = new Uint32Array(
                    ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
                );

                const hayFirma = pixels.some(p => p !== 0);
                if (!hayFirma) {
                    e.preventDefault();
                    alert('Debe firmar antes de continuar');
                }
            });
        }
    </script>

</x-app-layout>
