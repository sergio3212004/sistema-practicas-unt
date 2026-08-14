<x-app-layout>
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="mb-6">
            <a href="{{ route('profesor.formato-once.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al listado
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Editar Formato 11 - Conformidad de PPP</h1>
            <p class="text-gray-600 mt-2">Aula {{ $aula->numero }} - {{ $aula->semestre->nombre ?? 'Sin semestre' }}</p>
        </div>

        <form id="formatoOnceForm" action="{{ route('profesor.formato-once.update', $formatoOnce->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tabla de alumnos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Alumnos del Aula</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 180px;">
                                Alumno
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">
                                Sede de Prácticas
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">
                                Ciclo/Nivel
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">
                                Competencias
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">
                                Capacidades
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">
                                Actividades
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 200px;">
                                Producto
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">
                                Conformidad
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 250px;">
                                Comentarios
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($formatoOnce->formatoOnceAlumnos as $index => $registro)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $registro->alumno->nombre_completo }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $registro->alumno->codigo_matricula }}
                                    </div>
                                    <input type="hidden" name="alumnos[{{ $index }}][alumno_id]" value="{{ $registro->alumno->id }}">
                                </td>
                                <td class="px-4 py-4">
                                    <input type="text"
                                           name="alumnos[{{ $index }}][sede_practicas]"
                                           value="{{ $registro->sede_practicas ?? '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                           placeholder="Sede de prácticas">
                                </td>
                                <td class="px-4 py-4" style="min-width: 150px;">
                                    <div class="flex gap-2 items-center">
                                        <input type="number"
                                               name="alumnos[{{ $index }}][ciclo_numero]"
                                               id="ciclo_numero_{{ $index }}"
                                               min="6"
                                               max="10"
                                               value="{{ old("alumnos.$index.ciclo_numero", 6) }}"
                                               required
                                               class="w-16 px-2 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-center"
                                               placeholder="6">
                                        <span class="text-gray-500 font-bold">/</span>
                                        <select name="alumnos[{{ $index }}][nivel]"
                                                id="nivel_{{ $index }}"
                                                required
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="">Nivel</option>
                                            <option value="inicial" {{ old("alumnos.$index.nivel") == 'inicial' ? 'selected' : '' }}>Inicial</option>
                                            <option value="intermedio" {{ old("alumnos.$index.nivel") == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                                            <option value="final" {{ old("alumnos.$index.nivel") == 'final' ? 'selected' : '' }}>Final</option>
                                        </select>
                                    </div>
                                    <!-- Campo oculto que combinará ciclo_numero/nivel -->
                                    <input type="hidden"
                                           name="alumnos[{{ $index }}][ciclo_nivel]"
                                           id="ciclo_nivel_{{ $index }}"
                                           value="{{ old("alumnos.$index.ciclo_nivel", '6/inicial') }}">
                                    @error('alumnos.' . $index . '.ciclo_nivel')
                                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="px-4 py-4">
                                    <textarea name="alumnos[{{ $index }}][competencias]"
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                              placeholder="Competencias...">{{ $registro->competencias }}</textarea>
                                </td>
                                <td class="px-4 py-4">
                                    <textarea name="alumnos[{{ $index }}][capacidades]"
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                              placeholder="Capacidades...">{{ $registro->capacidades }}</textarea>
                                </td>
                                <td class="px-4 py-4">
                                    <textarea name="alumnos[{{ $index }}][actividades]"
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                              placeholder="Actividades...">{{ $registro->actividades }}</textarea>
                                </td>
                                <td class="px-4 py-4">
                                    <input type="text"
                                           name="alumnos[{{ $index }}][producto]"
                                           value="{{ $registro->producto }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                           placeholder="Producto">
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <select name="alumnos[{{ $index }}][conformidad]"
                                            required
                                            class="px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="1" {{ $registro->conformidad ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ !$registro->conformidad ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                                <td class="px-4 py-4">
                                    <textarea name="alumnos[{{ $index }}][comentarios]"
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm"
                                              placeholder="Comentarios adicionales...">{{ $registro->comentarios }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Firma del coordinador -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Firma del Coordinador</h2>
                    <p class="text-sm text-gray-600">Puede mantener la firma actual o dibujar una nueva</p>
                </div>

                <!-- Mostrar firma actual -->
                @if($formatoOnce->firma_coordinador)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Firma actual:</p>
                        <img src="{{ asset('storage/' . $formatoOnce->firma_coordinador) }}"
                             alt="Firma actual"
                             class="max-w-xs border border-gray-300 rounded bg-white p-2">
                        <div class="mt-2">
                            <label class="flex items-center text-sm text-gray-700">
                                <input type="checkbox" id="mantenerFirma" checked class="mr-2">
                                Mantener firma actual (desmarque para crear una nueva)
                            </label>
                        </div>
                    </div>
                @endif

                <div id="nuevaFirmaSection" class="space-y-4" style="{{ $formatoOnce->firma_coordinador ? 'display: none;' : '' }}">
                    <!-- Canvas para la firma -->
                    <div class="border-2 border-gray-300 rounded-lg overflow-hidden bg-white">
                        <canvas id="signatureCanvas" width="600" height="200" class="cursor-crosshair"></canvas>
                    </div>

                    <!-- Controles de la firma -->
                    <div class="flex gap-4 items-center">
                        <button type="button" id="clearSignature"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Limpiar Firma
                        </button>

                        <div class="flex items-center gap-2">
                            <label for="brushSize" class="text-sm font-medium text-gray-700">Grosor del pincel:</label>
                            <input type="range" id="brushSize" min="1" max="10" value="2"
                                   class="w-32 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <span id="brushSizeValue" class="text-sm text-gray-600 font-medium">2px</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="brushColor" class="text-sm font-medium text-gray-700">Color:</label>
                            <input type="color" id="brushColor" value="#000000"
                                   class="w-12 h-10 rounded cursor-pointer border border-gray-300">
                        </div>
                    </div>

                    <div id="signatureError" class="text-red-600 text-sm hidden">
                        Por favor, dibuje su firma antes de enviar el formulario.
                    </div>
                </div>

                <input type="hidden" name="firma_coordinador" id="firmaCoordinadorInput">
            </div>

            <!-- Botones de acción -->
            <div class="flex gap-4 justify-end">
                <a href="{{ route('profesor.formato-once.index') }}"
                   class="px-6 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Actualizar Formato
                </button>
            </div>
        </form>
    </div>

    <script>
        // Variables del canvas
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        const clearButton = document.getElementById('clearSignature');
        const brushSizeInput = document.getElementById('brushSize');
        const brushSizeValue = document.getElementById('brushSizeValue');
        const brushColorInput = document.getElementById('brushColor');
        const firmaInput = document.getElementById('firmaCoordinadorInput');
        const signatureError = document.getElementById('signatureError');
        const form = document.getElementById('formatoOnceForm');
        const mantenerFirmaCheckbox = document.getElementById('mantenerFirma');
        const nuevaFirmaSection = document.getElementById('nuevaFirmaSection');

        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;
        let hasDrawn = false;

        // Configuración inicial del canvas
        ctx.strokeStyle = brushColorInput.value;
        ctx.lineWidth = brushSizeInput.value;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Manejar checkbox de mantener firma
        if (mantenerFirmaCheckbox) {
            mantenerFirmaCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    nuevaFirmaSection.style.display = 'none';
                    hasDrawn = false;
                } else {
                    nuevaFirmaSection.style.display = 'block';
                }
            });
        }

        // Función para obtener las coordenadas correctas
        function getMousePos(canvas, evt) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (evt.clientX - rect.left) * (canvas.width / rect.width),
                y: (evt.clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        // Función para obtener las coordenadas del touch
        function getTouchPos(canvas, evt) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: (evt.touches[0].clientX - rect.left) * (canvas.width / rect.width),
                y: (evt.touches[0].clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        // Iniciar dibujo - Mouse
        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            const pos = getMousePos(canvas, e);
            [lastX, lastY] = [pos.x, pos.y];
            hasDrawn = true;
            signatureError.classList.add('hidden');
        });

        // Dibujar - Mouse
        canvas.addEventListener('mousemove', (e) => {
            if (!isDrawing) return;

            const pos = getMousePos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            [lastX, lastY] = [pos.x, pos.y];
        });

        // Terminar dibujo - Mouse
        canvas.addEventListener('mouseup', () => {
            isDrawing = false;
        });

        canvas.addEventListener('mouseout', () => {
            isDrawing = false;
        });

        // Soporte táctil
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            isDrawing = true;
            const pos = getTouchPos(canvas, e);
            [lastX, lastY] = [pos.x, pos.y];
            hasDrawn = true;
            signatureError.classList.add('hidden');
        });

        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            if (!isDrawing) return;

            const pos = getTouchPos(canvas, e);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            [lastX, lastY] = [pos.x, pos.y];
        });

        canvas.addEventListener('touchend', (e) => {
            e.preventDefault();
            isDrawing = false;
        });

        // Limpiar firma
        clearButton.addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hasDrawn = false;
            firmaInput.value = '';
            signatureError.classList.add('hidden');
        });

        // Cambiar grosor del pincel
        brushSizeInput.addEventListener('input', (e) => {
            ctx.lineWidth = e.target.value;
            brushSizeValue.textContent = e.target.value + 'px';
        });

        // Cambiar color del pincel
        brushColorInput.addEventListener('input', (e) => {
            ctx.strokeStyle = e.target.value;
        });

        // Validar y enviar formulario
        form.addEventListener('submit', (e) => {
            const mantenerFirma = mantenerFirmaCheckbox ? mantenerFirmaCheckbox.checked : false;

            // Si no se mantiene la firma y no se ha dibujado una nueva
            if (!mantenerFirma && !hasDrawn) {
                e.preventDefault();
                signatureError.classList.remove('hidden');
                canvas.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            // Si se dibujó una nueva firma
            if (hasDrawn) {
                const signatureData = canvas.toDataURL('image/png');
                firmaInput.value = signatureData;
            }
            // Si se mantiene la firma, no se envía nada en firmaInput (el backend lo maneja)
        });
    </script>

    <style>
        #signatureCanvas {
            width: 100%;
            height: 200px;
            display: block;
        }
    </style>
</x-app-layout>
