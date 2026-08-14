@props(['data'])

<section class="rounded-2xl bg-blue-950 p-6 text-white shadow-panel sm:p-7">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-gold-400">Administración académica</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight">Bienvenido, {{ $data->administrador->nombre_completo }}</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100">Configura el periodo académico y accede a la gestión central del sistema.</p>
        </div>
        <span class="ui-badge border-white/15 bg-white/10 text-white">
            <span class="h-2 w-2 rounded-full {{ $data->semestreActivo ? 'bg-green-400' : 'bg-gold-400' }}"></span>
            {{ $data->semestreActivo?->nombre ?? 'Sin semestre activo' }}
        </span>
    </div>
</section>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat-card label="Semestres registrados" :value="$data->totalSemestres" description="Histórico académico" icon="heroicon-o-calendar-days" />
    <x-ui.stat-card label="Periodo actual" :value="$data->semestreActivo?->nombre ?? '—'" description="Semestre habilitado" icon="heroicon-o-bolt" tone="success" />
    <x-ui.stat-card label="Gestión de usuarios" value="Activa" description="Cuentas y perfiles" icon="heroicon-o-users" />
    <x-ui.stat-card label="Solicitudes" value="Revisar" description="Empresas pendientes" icon="heroicon-o-check-badge" tone="warning" />
</div>

<div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
    <section class="ui-card">
        <div class="ui-card-header">
            <div>
                <h3 class="font-bold text-gray-950">Configuración del semestre</h3>
                <p class="mt-1 text-sm text-gray-600">Cierra el periodo actual o crea el siguiente periodo académico.</p>
            </div>
        </div>
        <div class="grid gap-6 p-5 sm:p-6 lg:grid-cols-2">
            <form method="POST" action="{{ route('admin.semestre.cerrar') }}" class="space-y-4 rounded-xl border border-gray-200 bg-gray-50 p-4" @submit="if (!confirm('¿Confirmas el cierre del semestre seleccionado?')) $event.preventDefault()">
                @csrf
                <div>
                    <p class="text-sm font-bold text-gray-950">Cerrar semestre</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">Esta acción finaliza el periodo seleccionado.</p>
                </div>
                <div>
                    <label for="semestre_activo" class="ui-label">Semestre</label>
                    <select name="semestre_id" id="semestre_activo" class="ui-field" required @disabled($data->semestres->isEmpty())>
                        @forelse ($data->semestres as $semestre)
                            <option value="{{ $semestre->id }}" @selected($semestre->activo)>
                                {{ $semestre->nombre }}{{ $semestre->activo ? ' · Activo' : '' }}
                            </option>
                        @empty
                            <option value="">No hay semestres registrados</option>
                        @endforelse
                    </select>
                </div>
                <button type="submit" class="ui-btn-danger w-full" @disabled($data->semestres->isEmpty())>
                    @svg('heroicon-o-lock-closed', 'h-4 w-4')
                    Cerrar semestre
                </button>
            </form>

            <form method="POST" action="{{ route('admin.semestre.nuevo') }}" class="space-y-4 rounded-xl border border-blue-100 bg-blue-50 p-4">
                @csrf
                <div>
                    <p class="text-sm font-bold text-gray-950">Nuevo semestre</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">El nuevo periodo quedará activo automáticamente.</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="anio" class="ui-label">Año</label>
                        <input type="number" name="anio" id="anio" value="{{ date('Y') }}" min="2020" max="2100" required class="ui-field">
                    </div>
                    <div>
                        <label for="periodo" class="ui-label">Periodo</label>
                        <select name="periodo" id="periodo" required class="ui-field">
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="EXT">Extraordinario</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="ui-btn-primary w-full">
                    @svg('heroicon-o-plus', 'h-4 w-4')
                    Crear y activar
                </button>
            </form>
        </div>
    </section>

    <section class="ui-card">
        <div class="ui-card-header">
            <div>
                <h3 class="font-bold text-gray-950">Accesos de gestión</h3>
                <p class="mt-1 text-sm text-gray-600">Continúa con las operaciones frecuentes.</p>
            </div>
        </div>
        <div class="divide-y divide-gray-100 px-5 sm:px-6">
            @foreach([
                ['route' => 'admin.usuarios.index', 'icon' => 'heroicon-o-users', 'label' => 'Gestionar usuarios', 'description' => 'Cuentas, roles y perfiles'],
                ['route' => 'admin.aulas.index', 'icon' => 'heroicon-o-academic-cap', 'label' => 'Gestionar aulas', 'description' => 'Docentes, grupos y estudiantes'],
                ['route' => 'admin.aprobaciones.index', 'icon' => 'heroicon-o-check-circle', 'label' => 'Revisar aprobaciones', 'description' => 'Solicitudes de nuevas empresas'],
            ] as $action)
                <a href="{{ route($action['route']) }}" class="group flex items-center gap-4 py-4">
                    <span class="ui-icon-box">@svg($action['icon'], 'h-5 w-5')</span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-bold text-gray-900 group-hover:text-blue-800">{{ $action['label'] }}</span>
                        <span class="mt-0.5 block text-xs text-gray-500">{{ $action['description'] }}</span>
                    </span>
                    @svg('heroicon-o-chevron-right', 'h-4 w-4 text-gray-400 group-hover:text-blue-700')
                </a>
            @endforeach
        </div>
    </section>
</div>
