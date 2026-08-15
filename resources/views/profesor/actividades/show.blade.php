<x-app-layout :title="$actividad->titulo">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Evaluación académica" :title="$actividad->titulo" :description="'Semana '.$actividad->semana->numero.' · Aula '.$actividad->aula->numero.' · '.$actividad->tipoActividad->nombre" icon="heroicon-o-clipboard-document-check">
            <x-slot name="actions"><a href="{{ route('profesor.semanas.show', $actividad->semana) }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Volver a la semana</a></x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Indicaciones y plazo" description="Información publicada para los estudiantes." icon="heroicon-o-information-circle" /></div>
            <div class="ui-card-body grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
                <div><h3 class="ui-label">Instrucciones</h3><p class="whitespace-pre-line text-sm leading-7 text-gray-700">{{ $actividad->descripcion ?: 'No se añadieron instrucciones adicionales.' }}</p></div>
                <dl class="rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm">
                    <div><dt class="text-gray-500">Inicio</dt><dd class="mt-1 font-semibold text-gray-900">{{ $actividad->fecha_inicio->format('d/m/Y H:i') }}</dd></div>
                    <div class="mt-4"><dt class="text-gray-500">Fecha límite</dt><dd class="mt-1 font-semibold text-gray-900">{{ $actividad->fecha_limite->format('d/m/Y H:i') }}</dd></div>
                    <div class="mt-4"><dt class="text-gray-500">Estado</dt><dd class="mt-1">@if($actividad->estaActiva())<span class="ui-badge-success">Activa</span>@elseif($actividad->estaVencida())<span class="ui-badge-danger">Vencida</span>@else<span class="ui-badge-warning">Próxima</span>@endif</dd></div>
                </dl>
            </div>
        </section>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header"><x-ui.section-heading title="Entregas de estudiantes" :description="$actividad->entregas->count().' trabajos recibidos.'" icon="heroicon-o-inbox-arrow-down"><x-slot name="actions"><span class="ui-badge-info">{{ $actividad->entregas->whereNotNull('nota')->count() }} calificadas</span></x-slot></x-ui.section-heading></div>
            @if($actividad->entregas->isEmpty())
                <div class="p-5 sm:p-6"><x-ui.empty-state title="Aún no hay entregas" description="Los trabajos aparecerán aquí cuando los estudiantes los envíen." icon="heroicon-o-inbox" /></div>
            @else
                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <caption class="sr-only">Entregas de estudiantes para {{ $actividad->titulo }}</caption>
                        <thead><tr><th scope="col">Estudiante</th><th scope="col">Entrega</th><th scope="col">Estado</th><th scope="col">Nota</th><th scope="col" class="text-right">Acciones</th></tr></thead>
                        <tbody>
                            @foreach($actividad->entregas as $entrega)
                                <tr>
                                    <td><p class="font-semibold text-gray-900">{{ $entrega->alumno->user->nombre }}</p><p class="mt-0.5 text-xs text-gray-500">{{ $entrega->alumno->codigo_matricula }}</p></td>
                                    <td>@if($entrega->fecha_entrega)<time datetime="{{ $entrega->fecha_entrega->toIso8601String() }}" class="font-medium text-gray-700">{{ $entrega->fecha_entrega->format('d/m/Y H:i') }}</time>@if(!$entrega->fueEntregadaATiempo())<p class="mt-1 text-xs font-semibold text-red-700">Fuera de plazo</p>@endif @else<span class="text-gray-500">Sin fecha</span>@endif</td>
                                    <td><span class="{{ $estadosEntregas[$entrega->id]['class'] }} inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">{{ $estadosEntregas[$entrega->id]['text'] }}</span></td>
                                    <td><span class="font-bold text-gray-900">{{ $entrega->estaCalificada() ? number_format($entrega->nota, 1) : '—' }}</span></td>
                                    <td><div class="flex justify-end gap-2">@if($entrega->ruta)<a href="{{ $entrega->actividad->tipoActividad->modo_entrega === 'pdf' ? asset('storage/'.$entrega->ruta) : $entrega->ruta }}" target="_blank" rel="noopener noreferrer" class="ui-btn-secondary px-3">Ver trabajo <span class="sr-only">(se abre en una pestaña nueva)</span></a>@endif<button type="button" class="ui-btn-primary px-3" data-grade-delivery="{{ $entrega->id }}" data-student-name="{{ $entrega->alumno->user->nombre }}" data-grade="{{ $entrega->nota }}" data-observations="{{ $entrega->observaciones }}">{{ $entrega->estaCalificada() ? 'Editar nota' : 'Calificar' }}</button></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="rounded-xl border border-red-200 bg-red-50 p-5"><div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-bold text-red-900">Eliminar actividad</h2><p class="mt-1 text-sm text-red-800">Se eliminarán también todas las entregas asociadas.</p></div><form action="{{ route('profesor.actividades.destroy', $actividad) }}" method="POST" onsubmit="return confirm('¿Eliminar esta actividad y sus entregas? Esta acción no se puede deshacer.');">@csrf @method('DELETE')<button type="submit" class="ui-btn-danger">@svg('heroicon-o-trash', 'h-4 w-4') Eliminar</button></form></div></section>
    </div>

    <div id="modal-calificar" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4" role="dialog" aria-modal="true" aria-labelledby="modal-calificar-titulo" aria-describedby="modal-alumno">
        <div class="ui-card w-full max-w-md overflow-hidden">
            <div class="ui-card-header"><h2 id="modal-calificar-titulo" class="text-lg font-bold text-gray-950">Calificar entrega</h2><p id="modal-alumno" class="mt-1 text-sm text-gray-600"></p></div>
            <form id="form-calificar" method="POST" class="ui-card-body space-y-5">@csrf @method('PATCH')
                <div><label for="modal-nota" class="ui-label">Nota (0–20)</label><input id="modal-nota" type="number" name="nota" min="0" max="20" step="0.1" class="ui-field" required></div>
                <div><label for="modal-observaciones" class="ui-label">Observaciones</label><textarea id="modal-observaciones" name="observaciones" rows="4" class="ui-field"></textarea></div>
                <div class="flex justify-end gap-2"><button type="button" id="cerrar-calificacion" class="ui-btn-secondary">Cancelar</button><button type="submit" class="ui-btn-primary">Guardar calificación</button></div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('modal-calificar');
                const form = document.getElementById('form-calificar');
                const grade = document.getElementById('modal-nota');
                const observations = document.getElementById('modal-observaciones');
                let trigger = null;
                const close = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.classList.remove('overflow-hidden'); trigger?.focus(); };
                document.querySelectorAll('[data-grade-delivery]').forEach(button => button.addEventListener('click', () => {
                    trigger = document.activeElement;
                    form.action = `{{ url('/profesor/entregas') }}/${button.dataset.gradeDelivery}/calificar`;
                    document.getElementById('modal-alumno').textContent = `Estudiante: ${button.dataset.studentName}`;
                    grade.value = button.dataset.grade;
                    observations.value = button.dataset.observations;
                    modal.classList.remove('hidden'); modal.classList.add('flex'); document.body.classList.add('overflow-hidden'); grade.focus();
                }));
                document.getElementById('cerrar-calificacion').addEventListener('click', close);
                modal.addEventListener('click', event => { if (event.target === modal) close(); });
                modal.addEventListener('keydown', e => {
                    if (e.key === 'Escape') { close(); return; }
                    if (e.key !== 'Tab') return;
                    const focusable = [...modal.querySelectorAll('button, input, textarea, [href]')].filter(element => !element.disabled);
                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];
                    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
                    if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
                });
            });
        </script>
    @endpush
</x-app-layout>
