<x-app-layout title="Nuevo Formato 12">
    <x-slot name="header"><x-ui.page-header eyebrow="Seguimiento de prácticas" title="Nuevo Formato 12" description="Registra el nivel de avance y los responsables de práctica de un aula activa." icon="heroicon-o-document-plus"><x-slot name="actions"><a href="{{ route('profesor.formato-doce.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver al historial</a></x-slot></x-ui.page-header></x-slot>
    <div class="ui-page">
        <x-ui.form-errors />
        @if($aulas->isEmpty())
            <x-ui.empty-state title="No hay aulas activas disponibles" description="Necesitas un aula del semestre activo para registrar el Formato 12." icon="heroicon-o-academic-cap" />
        @else
            <form action="{{ route('profesor.formato-doce.store') }}" method="POST" id="formatoForm" class="space-y-6">@csrf
                <section class="ui-card overflow-hidden">
                    <div class="ui-card-header"><x-ui.section-heading title="Contexto del monitoreo" description="Selecciona el aula cuyos estudiantes serán evaluados." icon="heroicon-o-academic-cap" /></div>
                    <div class="ui-card-body grid gap-5 sm:grid-cols-3">
                        <div><label for="fecha_monitoreo_visible" class="ui-label">Fecha</label><input id="fecha_monitoreo_visible" type="text" value="{{ now()->format('d/m/Y') }}" class="ui-field" readonly></div>
                        <div><label for="docente_monitoreo_visible" class="ui-label">Docente responsable</label><input id="docente_monitoreo_visible" type="text" value="{{ $nombreProfesor }}" class="ui-field" readonly></div>
                        <div><label for="aula_id" class="ui-label">Aula <span class="text-red-600" aria-hidden="true">*</span></label><select id="aula_id" name="aula_id" class="ui-field" required><option value="">Selecciona un aula</option>@foreach($aulas as $aula)<option value="{{ $aula->id }}" @selected(old('aula_id') == $aula->id)>Aula {{ $aula->numero }} · {{ $aula->semestre?->nombre ?? 'Sin semestre' }} · {{ $aula->alumnos->count() }} estudiantes</option>@endforeach</select></div>
                    </div>
                </section>

                <section class="ui-card overflow-hidden">
                    <div class="ui-card-header"><x-ui.section-heading title="Seguimiento de estudiantes" description="Completa el nivel, sede, responsable y avance de cada practicante." icon="heroicon-o-user-group"><x-slot name="actions"><span id="student-count" class="ui-badge-info">Selecciona un aula</span></x-slot></x-ui.section-heading></div>
                    <div id="students-status" class="p-5 sm:p-6"><x-ui.empty-state title="Selecciona un aula" description="Los estudiantes se cargarán automáticamente para completar el monitoreo." icon="heroicon-o-user-group" /></div>
                    <div id="students-table" class="hidden overflow-x-auto"><table class="ui-table"><caption class="sr-only">Estudiantes incluidos en el Formato 12</caption><thead><tr><th scope="col">Estudiante</th><th scope="col">Nivel</th><th scope="col">Sede</th><th scope="col">Responsable</th><th scope="col">Contacto</th><th scope="col">Avance</th><th scope="col">Observaciones</th></tr></thead><tbody id="alumnosTableBody"></tbody></table></div>
                </section>

                <section class="ui-card overflow-hidden">
                    <div class="ui-card-header"><x-ui.section-heading title="Firma del docente" description="Dibuja o carga una imagen legible de tu firma." icon="heroicon-o-pencil-square" /></div>
                    <div class="ui-card-body max-w-xl">
                        <p id="firma-instrucciones" class="ui-label">Firma <span class="text-red-600" aria-hidden="true">*</span></p>
                        <div class="overflow-hidden rounded-xl border border-gray-300 bg-white"><canvas id="signaturePad" width="600" height="220" tabindex="0" class="block w-full touch-none cursor-crosshair" role="img" aria-label="Área de firma del docente" aria-describedby="firma-instrucciones"></canvas></div>
                        <div class="mt-4"><label for="firmaArchivo" class="ui-label">Cargar imagen como alternativa</label><input id="firmaArchivo" type="file" accept="image/png,image/jpeg" class="block w-full text-sm text-gray-700" data-signature-upload data-canvas="signaturePad" data-output="firmaData" data-status="firma-estado"><p id="firma-estado" class="mt-2 text-sm text-gray-600" role="status" aria-live="polite"></p></div>
                        <button type="button" id="clearSignature" data-signature-clear data-status="firma-estado" class="ui-btn-secondary mt-4">Limpiar firma</button>
                        <input type="hidden" name="firma_coordinador" id="firmaData" required>
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end"><a href="{{ route('profesor.formato-doce.index') }}" class="ui-btn-secondary">Cancelar</a><button id="submit-format" type="submit" class="ui-btn-primary" disabled>@svg('heroicon-o-check', 'h-4 w-4') Guardar Formato 12</button></div>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('formatoForm');
                if (!form) return;
                const classroom = document.getElementById('aula_id');
                const status = document.getElementById('students-status');
                const table = document.getElementById('students-table');
                const body = document.getElementById('alumnosTableBody');
                const count = document.getElementById('student-count');
                const submit = document.getElementById('submit-format');
                const canvas = document.getElementById('signaturePad');
                const context = canvas.getContext('2d');
                let drawing = false;
                context.strokeStyle = '#1e1a17'; context.lineWidth = 2; context.lineCap = 'round';
                const point = event => { const rect = canvas.getBoundingClientRect(); const source = event.touches?.[0] ?? event; return { x: (source.clientX - rect.left) * canvas.width / rect.width, y: (source.clientY - rect.top) * canvas.height / rect.height }; };
                const start = event => { event.preventDefault(); drawing = true; const current = point(event); context.beginPath(); context.moveTo(current.x, current.y); };
                const draw = event => { if (!drawing) return; event.preventDefault(); const current = point(event); context.lineTo(current.x, current.y); context.stroke(); };
                const stop = () => { drawing = false; };
                ['mousedown', 'touchstart'].forEach(name => canvas.addEventListener(name, start));
                ['mousemove', 'touchmove'].forEach(name => canvas.addEventListener(name, draw));
                ['mouseup', 'mouseleave', 'touchend'].forEach(name => canvas.addEventListener(name, stop));
                document.getElementById('clearSignature').addEventListener('click', () => context.clearRect(0, 0, canvas.width, canvas.height));

                const field = (name, placeholder, type = 'input') => type === 'textarea'
                    ? `<textarea name="${name}" rows="2" class="ui-field min-w-48" placeholder="${placeholder}"></textarea>`
                    : `<input name="${name}" type="text" class="ui-field min-w-44" placeholder="${placeholder}" required>`;
                classroom.addEventListener('change', async () => {
                    body.innerHTML = ''; table.classList.add('hidden'); status.classList.remove('hidden'); submit.disabled = true;
                    if (!classroom.value) { status.innerHTML = '<p class="text-center text-sm text-gray-600">Selecciona un aula para cargar sus estudiantes.</p>'; count.textContent = 'Selecciona un aula'; return; }
                    status.innerHTML = '<p class="text-center text-sm font-semibold text-blue-800" role="status">Cargando estudiantes…</p>';
                    try {
                        const response = await fetch(`{{ url('/profesor/formato-doce/aula') }}/${classroom.value}/alumnos`, { headers: { Accept: 'application/json' } });
                        if (!response.ok) throw new Error('No se pudo cargar el aula.');
                        const students = await response.json();
                        count.textContent = `${students.length} estudiantes`;
                        if (!students.length) { status.innerHTML = '<p class="text-center text-sm text-gray-600">Esta aula no tiene estudiantes asignados.</p>'; return; }
                        body.innerHTML = students.map((student, index) => `<tr><td><input type="hidden" name="alumnos[${index}][alumno_id]" value="${student.id}"><p class="min-w-52 font-semibold text-gray-900">${student.nombre_completo}</p><p class="text-xs text-gray-500">${student.codigo_matricula}</p></td><td><select name="alumnos[${index}][nivel]" class="ui-field min-w-36" required><option value="">Selecciona</option><option value="inicial">Inicial</option><option value="intermedio">Intermedio</option><option value="avanzado">Avanzado</option></select></td><td>${field(`alumnos[${index}][sede_practica]`, 'Sede')}</td><td>${field(`alumnos[${index}][responsable]`, 'Responsable')}</td><td>${field(`alumnos[${index}][contacto_responsable]`, 'Correo o teléfono')}</td><td><div class="min-w-36 space-y-2"><label class="flex items-center gap-2 text-sm"><input type="radio" name="alumnos[${index}][al_dia]" value="1" required> Al día</label><label class="flex items-center gap-2 text-sm"><input type="radio" name="alumnos[${index}][al_dia]" value="0" required> Con retraso</label></div></td><td>${field(`alumnos[${index}][observaciones]`, 'Observaciones', 'textarea')}</td></tr>`).join('');
                        status.classList.add('hidden'); table.classList.remove('hidden'); submit.disabled = false;
                    } catch (error) { count.textContent = 'Error'; status.innerHTML = `<p class="text-center text-sm text-red-700">${error.message} Inténtalo nuevamente.</p>`; }
                });
                form.addEventListener('submit', event => {
                    const pixels = context.getImageData(0, 0, canvas.width, canvas.height).data;
                    if (!pixels.some((value, index) => index % 4 !== 3 && value !== 0)) { event.preventDefault(); document.getElementById('firma-estado').textContent = 'Añade tu firma antes de guardar.'; canvas.focus(); return; }
                    document.getElementById('firmaData').value = canvas.toDataURL('image/png');
                });
                if (classroom.value) classroom.dispatchEvent(new Event('change'));
            });
        </script>
    @endpush
</x-app-layout>
