<x-app-layout :title="'Aula '.$aula->numero">
    <x-slot name="header">
        <x-ui.page-header eyebrow="Espacio docente" :title="'Aula '.$aula->numero" :description="($aula->semestre?->nombre ?? 'Sin semestre').' · estudiantes, planificación y documentación en un solo lugar.'" icon="heroicon-o-academic-cap">
            <x-slot name="actions">
                <a href="{{ route('profesor.actividades.create', $aula) }}" class="ui-btn-secondary">@svg('heroicon-o-clipboard-document-list', 'h-4 w-4') Nueva actividad</a>
                <a href="{{ route('profesor.semanas.create', $aula) }}" class="ui-btn-primary">@svg('heroicon-o-plus', 'h-4 w-4') Nueva semana</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page" x-data="{ tab: 'estudiantes', studentSearch: '', studentFilter: '', documentFilter: '' }">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.stat-card label="Estudiantes" :value="$metricas['estudiantes']" description="Matriculados en el aula" icon="heroicon-o-user-group" />
            <x-ui.stat-card label="Semanas" :value="$metricas['semanas']" description="Bloques planificados" icon="heroicon-o-calendar-days" />
            <x-ui.stat-card label="Actividades activas" :value="$metricas['actividadesActivas']" description="Disponibles actualmente" icon="heroicon-o-bolt" tone="success" />
            <x-ui.stat-card label="Actividades" :value="$metricas['actividades']" description="Total del semestre" icon="heroicon-o-clipboard-document-list" />
        </div>

        <section class="ui-card overflow-hidden">
            <div class="overflow-x-auto border-b border-gray-200 px-3 sm:px-5">
                <div class="flex min-w-max gap-1" role="tablist" aria-label="Secciones del aula">
                    <button type="button" role="tab" :aria-selected="(tab === 'estudiantes').toString()" @click="tab = 'estudiantes'" :class="tab === 'estudiantes' ? 'border-blue-800 text-blue-900' : 'border-transparent text-gray-600 hover:text-gray-900'" class="border-b-2 px-4 py-4 text-sm font-semibold">Estudiantes</button>
                    <button type="button" role="tab" :aria-selected="(tab === 'planificacion').toString()" @click="tab = 'planificacion'" :class="tab === 'planificacion' ? 'border-blue-800 text-blue-900' : 'border-transparent text-gray-600 hover:text-gray-900'" class="border-b-2 px-4 py-4 text-sm font-semibold">Planificación</button>
                    <button type="button" role="tab" :aria-selected="(tab === 'documentos').toString()" @click="tab = 'documentos'" :class="tab === 'documentos' ? 'border-blue-800 text-blue-900' : 'border-transparent text-gray-600 hover:text-gray-900'" class="border-b-2 px-4 py-4 text-sm font-semibold">Documentación</button>
                </div>
            </div>

            <div x-show="tab === 'estudiantes'" role="tabpanel">
                <div class="ui-card-header"><x-ui.section-heading title="Estudiantes del aula" :description="$aula->alumnos->count().' estudiantes asignados.'" icon="heroicon-o-user-group" /></div>
                @if($aula->alumnos->isEmpty())
                    <div class="p-5 sm:p-6"><x-ui.empty-state title="No hay estudiantes asignados" description="El administrador debe asignar estudiantes para comenzar el seguimiento." icon="heroicon-o-user-group" /></div>
                @else
                    <div class="border-b border-gray-200 p-5 sm:p-6"><label for="buscar-estudiante" class="ui-label">Buscar estudiante</label><input id="buscar-estudiante" type="search" x-model="studentSearch" class="ui-field max-w-xl" placeholder="Nombre, código o correo"></div>
                    <div class="overflow-x-auto">
                        <table class="ui-table">
                            <caption class="sr-only">Estudiantes del aula {{ $aula->numero }}</caption>
                            <thead><tr><th scope="col">Estudiante</th><th scope="col">Código</th><th scope="col">Contacto</th><th scope="col">Documentación</th></tr></thead>
                            <tbody>
                                @foreach($aula->alumnos as $alumno)
                                    @php($studentSearchText = mb_strtolower($alumno->user->nombre.' '.$alumno->codigo_matricula.' '.$alumno->user->email))
                                    <tr x-show="@js($studentSearchText).includes(studentSearch.toLowerCase())">
                                        <td><p class="font-semibold text-gray-900">{{ $alumno->user->nombre }}</p><p class="mt-0.5 text-xs text-gray-500">{{ $alumno->user->email }}</p></td>
                                        <td><span class="ui-badge-info">{{ $alumno->codigo_matricula }}</span></td>
                                        <td><span class="text-sm text-gray-700">{{ $alumno->telefono ?: 'Sin teléfono' }}</span></td>
                                        <td>
                                            @if($alumno->fichaRegistro)
                                                <a href="{{ route('profesor.fichas.show', $alumno->fichaRegistro) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-800 hover:text-blue-950">Ver ficha @svg('heroicon-o-arrow-right', 'h-4 w-4')</a>
                                            @else<span class="ui-badge-warning">Ficha pendiente</span>@endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div x-show="tab === 'planificacion'" role="tabpanel" x-cloak>
                <div class="ui-card-header"><x-ui.section-heading title="Semanas y actividades" :description="$aula->semanas->count().' semanas planificadas.'" icon="heroicon-o-calendar-days"><x-slot name="actions"><a href="{{ route('profesor.semanas.create', $aula) }}" class="ui-btn-primary">Nueva semana</a></x-slot></x-ui.section-heading></div>
                @if($aula->semanas->isEmpty())
                    <div class="p-5 sm:p-6"><x-ui.empty-state title="Aún no existe una planificación" description="Crea la primera semana y luego añade sus actividades." icon="heroicon-o-calendar-days"><x-slot name="actions"><a href="{{ route('profesor.semanas.create', $aula) }}" class="ui-btn-primary">Crear primera semana</a></x-slot></x-ui.empty-state></div>
                @else
                    <div class="divide-y divide-gray-200">
                        @foreach($aula->semanas as $semana)
                            <article class="p-5 sm:p-6">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div><div class="flex flex-wrap items-center gap-2"><h3 class="font-bold text-gray-950">Semana {{ $semana->numero }}{{ $semana->nombre ? ' · '.$semana->nombre : '' }}</h3><span class="ui-badge-info">{{ $semana->actividades->count() }} actividades</span></div><p class="mt-2 text-sm text-gray-600">Gestiona plazos, entregas y calificaciones de este bloque.</p></div>
                                    <div class="flex flex-wrap gap-2"><a href="{{ route('profesor.actividades.create', ['aula' => $aula, 'semana' => $semana]) }}" class="ui-btn-secondary">Añadir actividad</a><a href="{{ route('profesor.semanas.show', $semana) }}" class="ui-btn-primary">Abrir semana</a></div>
                                </div>
                                @if($semana->actividades->isNotEmpty())
                                    <div class="mt-4 grid gap-3 lg:grid-cols-2">
                                        @foreach($semana->actividades as $actividad)
                                            @php($progreso = $progresoActividades[$actividad->id])
                                            <a href="{{ route('profesor.actividades.show', $actividad) }}" class="rounded-xl border border-gray-200 bg-gray-50 p-4 hover:border-blue-300 hover:bg-blue-50/40">
                                                <div class="flex items-start justify-between gap-3"><div><p class="font-semibold text-gray-900">{{ $actividad->titulo }}</p><p class="mt-1 text-xs text-gray-500">Límite {{ $actividad->fecha_limite->format('d/m/Y H:i') }}</p></div><span class="ui-badge-info">{{ $progreso['entregadas'] }}/{{ $progreso['total'] }}</span></div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>

            <div x-show="tab === 'documentos'" role="tabpanel" x-cloak>
                <div class="ui-card-header"><x-ui.section-heading title="Documentación de prácticas" description="Revisa fichas, cronogramas y monitoreos por estudiante." icon="heroicon-o-folder-open" /></div>
                @if($aula->alumnos->isEmpty())
                    <div class="p-5 sm:p-6"><x-ui.empty-state title="No hay documentación disponible" description="Aparecerá cuando existan estudiantes asignados." icon="heroicon-o-folder-open" /></div>
                @else
                    <div class="grid gap-4 border-b border-gray-200 p-5 sm:grid-cols-2 sm:p-6">
                        <div><label for="filtro-alumno" class="ui-label">Estudiante</label><select id="filtro-alumno" x-model="studentFilter" class="ui-field"><option value="">Todos</option>@foreach($aula->alumnos as $alumno)<option value="{{ $alumno->id }}">{{ $alumno->user->nombre }}</option>@endforeach</select></div>
                        <div><label for="filtro-documento" class="ui-label">Tipo de documento</label><select id="filtro-documento" x-model="documentFilter" class="ui-field"><option value="">Todos</option><option value="ficha">Ficha</option><option value="cronograma">Cronograma</option><option value="monitoreo">Monitoreo</option></select></div>
                    </div>
                    <div class="grid gap-4 p-5 sm:p-6 lg:grid-cols-2">
                        @foreach($aula->alumnos as $alumno)
                            @if($alumno->fichaRegistro)
                                <article x-show="(!studentFilter || studentFilter === '{{ $alumno->id }}') && (!documentFilter || documentFilter === 'ficha')" class="rounded-xl border border-gray-200 p-4"><div class="flex items-start gap-3"><span class="ui-icon-box">@svg('heroicon-o-document-text', 'h-5 w-5')</span><div class="min-w-0 flex-1"><p class="font-bold text-gray-900">Ficha de registro</p><p class="mt-1 truncate text-sm text-gray-600">{{ $alumno->user->nombre }}</p><div class="mt-3 flex items-center justify-between gap-2">@if($alumno->fichaRegistro->aceptado === true)<span class="ui-badge-success">Aprobada</span>@elseif($alumno->fichaRegistro->aceptado === false)<span class="ui-badge-danger">Rechazada</span>@else<span class="ui-badge-warning">Pendiente</span>@endif<a href="{{ route('profesor.fichas.show', $alumno->fichaRegistro) }}" class="text-sm font-semibold text-blue-800">Revisar</a></div></div></div></article>
                                @if($alumno->fichaRegistro->cronograma)
                                    <article x-show="(!studentFilter || studentFilter === '{{ $alumno->id }}') && (!documentFilter || documentFilter === 'cronograma')" class="rounded-xl border border-gray-200 p-4"><div class="flex items-start gap-3"><span class="ui-icon-box">@svg('heroicon-o-calendar-days', 'h-5 w-5')</span><div class="min-w-0 flex-1"><p class="font-bold text-gray-900">Cronograma</p><p class="mt-1 truncate text-sm text-gray-600">{{ $alumno->user->nombre }}</p><div class="mt-3 flex items-center justify-between gap-2">{!! $alumno->fichaRegistro->cronograma->firma_profesor ? '<span class="ui-badge-success">Firmado</span>' : '<span class="ui-badge-warning">Firma pendiente</span>' !!}<a href="{{ route('profesor.cronogramas.show', $alumno->fichaRegistro->cronograma) }}" class="text-sm font-semibold text-blue-800">Revisar</a></div></div></div></article>
                                    <article x-show="(!studentFilter || studentFilter === '{{ $alumno->id }}') && (!documentFilter || documentFilter === 'monitoreo')" class="rounded-xl border border-gray-200 p-4"><div class="flex items-start gap-3"><span class="ui-icon-box">@svg('heroicon-o-chart-bar-square', 'h-5 w-5')</span><div class="min-w-0 flex-1"><p class="font-bold text-gray-900">Monitoreo de prácticas</p><p class="mt-1 truncate text-sm text-gray-600">{{ $alumno->user->nombre }}</p><div class="mt-3 flex items-center justify-between gap-2"><span class="ui-badge-info">{{ $monitoreosPorAlumno[$alumno->id] }} semanas</span><a href="{{ route('profesor.monitoreos-practicas.index', $alumno) }}" class="text-sm font-semibold text-blue-800">Consultar</a></div></div></div></article>
                                @endif
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
