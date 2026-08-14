<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma de Ficha de Registro</title>

    <!-- Tailwind CSS -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos personalizados -->
    <style>
        .signature-canvas {
            border: 2px dashed #9ca3af;
            border-radius: 0.5rem;
            background-color: #f3f4f6;
            cursor: crosshair;
        }
    </style>
</head>
<body class="bg-gray-50">

<!-- Header Personalizado -->
<div class="bg-white shadow-sm border-b">
    <div class="max-w-6xl mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-pencil-square', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Firma de Ficha de Registro
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Formato 01: Ficha de Registro de Prácticas Pre Profesionales</p>
                </div>
            </div>

            <div>
                    <span class="inline-flex items-center px-4 py-2
                        {{ $firmaToken->tipo === 'empresa'
                            ? 'bg-blue-500 text-white'
                            : 'bg-purple-500 text-white' }}
                        text-sm font-semibold rounded-full shadow-lg">
                        @svg('heroicon-o-user-circle', 'w-5 h-5 mr-2')
                        {{ $firmaToken->tipo === 'empresa' ? 'Representante Empresa' : 'Jefe Directo' }}
                    </span>
            </div>
        </div>
    </div>
</div>

<!-- Contenido Principal -->
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

                <!-- Saludo personalizado -->
                <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6">
                    <p class="text-gray-800 text-lg leading-relaxed">
                        @if($firmaToken->tipo === 'empresa')
                            Estimado/a <strong>{{ $firmaToken->ficha->nombre_gerente }}</strong>, Representante Legal de la empresa
                            <strong>{{ $firmaToken->ficha->razon_social }}</strong>,
                        @else
                            Estimado/a Jefe/a Directo(a)
                            <strong>{{ $firmaToken->ficha->nombre_jefe_directo }}</strong>,
                        @endif
                    </p>
                    <p class="mt-2 text-gray-700">
                        Agradecemos su valiosa colaboración en el proceso formativo de nuestro estudiante. Por favor,
                        revise los datos proporcionados y firme digitalmente esta ficha de registro para validar su participación.
                    </p>
                </div>

                <!-- SECCIÓN: DATOS DEL ESTUDIANTE -->
                <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            @svg('heroicon-o-user', 'w-5 h-5 mr-2')
                            1. ESTUDIANTE
                        </h3>
                    </div>
                    <div class="p-6 bg-blue-50">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Apellidos y Nombres</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                {{ $firmaToken->ficha->alumno->nombre_completo }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nro. Matrícula</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->alumno->codigo_matricula }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ciclo</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->ciclo }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Año y Semestre</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->semestre->nombre }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Móvil</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-envelope', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $firmaToken->ficha->alumno->telefono }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-envelope', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $firmaToken->ficha->alumno->user->email }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- SECCIÓN: EMPRESA O INSTITUCIÓN -->
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
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Razón Social</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 font-medium">
                                    {{ $firmaToken->ficha->razon_social }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">RUC</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->ruc }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Gerente General</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->nombre_gerente }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jefe de RRHH</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->nombre_jefe_rrhh }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                @svg('heroicon-o-map-pin', 'w-5 h-5 text-blue-800 mr-2')
                                {{ $firmaToken->ficha->direccion }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Fijo</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->telefono_fijo ?? 'No especificado' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Móvil</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->telefono_movil ?? 'No especificado' }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Empresa</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                    {{ $firmaToken->ficha->correo_empresa ?? 'No especificado' }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Departamento</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->departamento }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Provincia</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->provincia }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Distrito</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                    {{ $firmaToken->ficha->distrito }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN: CARACTERÍSTICAS DE LA PRÁCTICA -->
                <div class="mb-8 border-2 border-blue-200 rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            @svg('heroicon-o-clipboard-document-list', 'w-5 h-5 mr-2')
                            3. CARACTERÍSTICAS DE LA PRÁCTICA
                        </h3>
                    </div>
                    <div class="p-6 bg-blue-50">
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
                                                    $horario = $firmaToken->ficha->horarios->firstWhere('dia_semana', $dia);
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
                                                    $horario = $firmaToken->ficha->horarios->firstWhere('dia_semana', $dia);
                                                @endphp
                                                {{ $horario ? $horario->hora_fin : '____' }}
                                            </td>
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>

                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Inicio</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $firmaToken->ficha->fecha_inicio->format('d/m/Y') }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Término</label>
                                <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 flex items-center">
                                    @svg('heroicon-o-calendar', 'w-5 h-5 text-blue-800 mr-2')
                                    {{ $firmaToken->ficha->fecha_termino->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Área de Prácticas</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                {{ $firmaToken->ficha->area_practicas }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cargo</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                {{ $firmaToken->ficha->cargo }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jefe Directo</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800">
                                {{ $firmaToken->ficha->nombre_jefe_directo }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Correo del Jefe Directo</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 text-sm">
                                {{ $firmaToken->ficha->correo_jefe_directo }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción de la Práctica</label>
                            <div class="bg-white border-2 border-blue-200 rounded-lg px-4 py-3 text-gray-800 min-h-[80px]">
                                {{ $firmaToken->ficha->descripcion }}
                            </div>
                        </div>


                    </div>
                </div>

                <!-- SECCIÓN: FIRMA DIGITAL -->
                <div class="border-2 border-blue-200 rounded-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-6 py-3">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            @svg('heroicon-o-pencil-square', 'w-5 h-5 mr-2')
                            4. FIRMA DIGITAL
                        </h3>
                    </div>
                    <div class="p-6 bg-blue-50">
                        <form method="POST" action="{{ route('firmas.ficha-registro.store', $firmaToken->token) }}" class="max-w-2xl mx-auto">
                            @csrf

                            <canvas id="canvasFirma"
                                    class="signature-canvas mx-auto block w-full max-w-md"
                                    width="360"
                                    height="140"></canvas>

                            <input type="hidden" name="firma" id="firma">

                            <div class="text-center mt-4">
                                <button type="button"
                                        onclick="limpiarFirma()"
                                        class="text-sm text-blue-600 hover:underline font-medium">
                                    Limpiar firma
                                </button>
                            </div>

                            <button type="submit"
                                    class="mt-6 w-full bg-gradient-to-r from-blue-800 to-blue-900 text-white py-3 rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
                                Confirmar y Enviar Firma
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    const canvas = document.getElementById('canvasFirma');
    const ctx = canvas.getContext('2d');
    let dibujando = false;

    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000000';

    function pos(e) {
        const r = canvas.getBoundingClientRect();
        return {
            x: e.clientX - r.left,
            y: e.clientY - r.top
        };
    }

    canvas.addEventListener('mousedown', e => {
        dibujando = true;
        const p = pos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    });

    canvas.addEventListener('mousemove', e => {
        if (!dibujando) return;
        const p = pos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
    });

    canvas.addEventListener('mouseup', () => dibujando = false);
    canvas.addEventListener('mouseleave', () => dibujando = false);

    // Soporte táctil (opcional)
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousedown', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    });

    canvas.addEventListener('touchmove', e => {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent('mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    });

    canvas.addEventListener('touchend', e => {
        e.preventDefault();
        const mouseEvent = new MouseEvent('mouseup', {});
        canvas.dispatchEvent(mouseEvent);
    });

    function limpiarFirma() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById('firma').value = '';
    }

    document.querySelector('form').addEventListener('submit', e => {
        const data = ctx.getImageData(0,0,canvas.width,canvas.height).data;
        if (![...data].some(v => v !== 0)) {
            e.preventDefault();
            alert('Debe firmar antes de continuar.');
            return;
        }
        document.getElementById('firma').value = canvas.toDataURL('image/png');
    });
</script>

</body>
</html>
