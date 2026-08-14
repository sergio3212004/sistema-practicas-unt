<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-900">ESCUELA PROFESIONAL - PREGRADO</h1>
                        <h2 class="text-2xl font-bold text-blue-700 mt-2">Monitoreo de Prácticas Pre Profesionales</h2>
                    </div>
                    <a href="{{ route('profesor.formato-doce.index') }}"
                       class="text-blue-700 hover:text-blue-900 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Mensajes de error -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-red-700 font-medium">Por favor corrija los siguientes errores:</p>
                            <ul class="mt-2 text-sm text-red-600 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('profesor.formato-doce.store') }}" method="POST" id="formatoForm">
                @csrf

                <!-- Información General -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                FECHA DE MONITOREO:
                            </label>
                            <input type="text"
                                   value="{{ date('d/m/Y') }}"
                                   readonly
                                   class="w-full px-4 py-2 border-b-2 border-gray-400 bg-transparent text-gray-700 font-medium focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                DOCENTE RESPONSABLE DEL MONITOREO:
                            </label>
                            <input type="text"
                                   value="{{ auth()->user()->nombre ?? 'Docente' }}"
                                   readonly
                                   class="w-full px-4 py-2 border-b-2 border-gray-400 bg-transparent text-gray-700 font-medium focus:outline-none">
                        </div>

                        <div>
                            <label for="aula_id" class="block text-sm font-bold text-gray-700 mb-2">
                                CICLO / SEMESTRE: <span class="text-red-500">*</span>
                            </label>
                            <select id="aula_id"
                                    name="aula_id"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium">
                                <option value="">Seleccione un aula</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                        Aula {{ $aula->numero ?? 'N/A' }} - Ciclo {{ $aula->ciclo ?? 'N/A' }} - {{ $aula->semestre->nombre ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Estudiantes -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300" id="alumnosTable">
                            <thead class="bg-blue-900">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">N°</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Código</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Apellidos y Nombres del Estudiante</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Nivel de Práctica</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Sede de Práctica Pre Profesional</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Responsable de la Sede</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Contacto (correo/teléfono)</th>
                                <th class="px-3 py-3 text-center text-xs font-bold text-white uppercase" colspan="2">Nivel de Avance</th>
                                <th class="px-3 py-3 text-left text-xs font-bold text-white uppercase">Observaciones</th>
                            </tr>
                            <tr class="bg-blue-800">
                                <th colspan="7"></th>
                                <th class="px-3 py-2 text-center text-xs font-bold text-white uppercase">Atrasado</th>
                                <th class="px-3 py-2 text-center text-xs font-bold text-white uppercase">Al día</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="alumnosTableBody">
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    Seleccione un aula para cargar los estudiantes
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Firma Digital -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="max-w-md">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            FIRMA DEL DOCENTE RESPONSABLE DEL MONITOREO: <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-gray-400 rounded-lg overflow-hidden bg-white">
                            <canvas id="signaturePad"
                                    width="500"
                                    height="200"
                                    class="cursor-crosshair w-full"></canvas>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <button type="button"
                                    id="clearSignature"
                                    class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                Limpiar Firma
                            </button>
                        </div>
                        <input type="hidden" name="firma_coordinador" id="firmaData" required>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-end gap-4">
                    <a href="{{ route('profesor.formato-doce.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Formato
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signaturePad');
            const ctx = canvas.getContext('2d');
            let isDrawing = false;

            // Configurar canvas para firma
            ctx.strokeStyle = '#000';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';

            // Eventos de firma
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);

            // Eventos táctiles
            canvas.addEventListener('touchstart', handleTouch);
            canvas.addEventListener('touchmove', handleTouch);
            canvas.addEventListener('touchend', stopDrawing);

            function startDrawing(e) {
                isDrawing = true;
                const rect = canvas.getBoundingClientRect();
                ctx.beginPath();
                ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
            }

            function draw(e) {
                if (!isDrawing) return;
                const rect = canvas.getBoundingClientRect();
                ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
                ctx.stroke();
            }

            function stopDrawing() {
                isDrawing = false;
            }

            function handleTouch(e) {
                e.preventDefault();
                const touch = e.touches[0];
                const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' :
                    e.type === 'touchmove' ? 'mousemove' : 'mouseup', {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(mouseEvent);
            }

            document.getElementById('clearSignature').addEventListener('click', function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            // Cargar alumnos cuando se selecciona un aula
            document.getElementById('aula_id').addEventListener('change', function() {
                const aulaId = this.value;
                const tbody = document.getElementById('alumnosTableBody');

                if (!aulaId) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Seleccione un aula para cargar los estudiantes
                            </td>
                        </tr>
                    `;
                    return;
                }

                // Mostrar loading
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex justify-center items-center">
                                <svg class="animate-spin h-8 w-8 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="ml-3">Cargando estudiantes...</span>
                            </div>
                        </td>
                    </tr>
                `;

                fetch(`/profesor/formato-doce/aula/${aulaId}/alumnos`)
                    .then(response => response.json())
                    .then(alumnos => {
                        if (alumnos.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="10" class="px-6 py-8 text-center text-gray-500">
                                        No hay estudiantes registrados en esta aula
                                    </td>
                                </tr>
                            `;
                            return;
                        }

                        tbody.innerHTML = '';
                        alumnos.forEach((alumno, index) => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition duration-150';
                            row.innerHTML = `
                                <td class="px-3 py-3 text-sm text-gray-900 font-medium">${index + 1}</td>
                                <td class="px-3 py-3 text-sm text-gray-900 font-medium">${alumno.codigo_matricula || 'N/A'}</td>
                                <td class="px-3 py-3 text-sm text-gray-900 font-medium">${alumno.nombre_completo}</td>
                                <td class="px-3 py-3">
                                    <input type="hidden" name="alumnos[${index}][alumno_id]" value="${alumno.id}">
                                    <select name="alumnos[${index}][nivel]" required class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccione</option>
                                        <option value="inicial">Inicial</option>
                                        <option value="intermedio">Intermedio</option>
                                        <option value="avanzado">Avanzado</option>
                                    </select>
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text"
                                           name="alumnos[${index}][sede_practica]"
                                           required
                                           class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Sede de práctica">
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text"
                                           name="alumnos[${index}][responsable]"
                                           required
                                           class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Responsable">
                                </td>
                                <td class="px-3 py-3">
                                    <input type="text"
                                           name="alumnos[${index}][contacto_responsable]"
                                           required
                                           class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Email/Teléfono">
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <input type="radio"
                                           name="alumnos[${index}][al_dia]"
                                           value="0"
                                           required
                                           class="w-4 h-4 text-blue-700 focus:ring-blue-500">
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <input type="radio"
                                           name="alumnos[${index}][al_dia]"
                                           value="1"
                                           required
                                           class="w-4 h-4 text-blue-700 focus:ring-blue-500">
                                </td>
                                <td class="px-3 py-3">
                                    <textarea name="alumnos[${index}][observaciones]"
                                              rows="2"
                                              class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Observaciones"></textarea>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-red-500">
                                    Error al cargar los estudiantes. Por favor intente nuevamente.
                                </td>
                            </tr>
                        `;
                    });
            });

            // Validar formulario antes de enviar
            document.getElementById('formatoForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validar que se haya seleccionado un aula
                const aulaId = document.getElementById('aula_id').value;
                if (!aulaId) {
                    alert('Por favor seleccione un aula');
                    return;
                }

                // Validar que hay estudiantes en la tabla
                const tbody = document.getElementById('alumnosTableBody');
                const rows = tbody.querySelectorAll('tr');
                const hasValidRows = Array.from(rows).some(row => row.querySelectorAll('input[type="hidden"]').length > 0);

                if (!hasValidRows) {
                    alert('No hay estudiantes para registrar. Por favor seleccione un aula con estudiantes.');
                    return;
                }

                // Guardar firma
                const firmaData = canvas.toDataURL('image/png');
                document.getElementById('firmaData').value = firmaData;

                // Validar que la firma no esté vacía
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const hasSignature = imageData.data.some(channel => channel !== 0);

                if (!hasSignature) {
                    alert('Por favor firme el documento');
                    return;
                }

                this.submit();
            });
        });
    </script>
</x-app-layout>
