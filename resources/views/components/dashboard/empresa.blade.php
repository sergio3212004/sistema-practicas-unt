@props(['data'])

<section class="rounded-2xl bg-blue-950 p-6 text-white shadow-panel sm:p-7">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-gold-400">Vinculación empresarial</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight">Bienvenido, {{ $data->empresa->nombre }}</h2>
            <p class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-blue-100">
                <span>{{ $data->empresa->razonSocial->nombre ?? $data->empresa->razonSocial->acronimo ?? 'Empresa registrada' }}</span>
                <span class="text-blue-400">·</span>
                <span>RUC {{ $data->empresa->ruc }}</span>
            </p>
        </div>
        <a href="{{ route('empresa.publicaciones.create') }}" class="ui-btn border-gold-400 bg-gold-500 text-gray-950 hover:border-gold-300 hover:bg-gold-400">
            @svg('heroicon-o-plus', 'h-4 w-4') Nueva publicación
        </a>
    </div>
</section>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat-card label="Ofertas publicadas" :value="$data->metricas['publicaciones']" description="Histórico de publicaciones" icon="heroicon-o-newspaper" />
    <x-ui.stat-card label="Ofertas activas" :value="$data->metricas['activas']" description="Visibles para estudiantes" icon="heroicon-o-check-circle" tone="success" />
    <x-ui.stat-card label="Postulaciones" :value="$data->metricas['postulaciones']" description="Candidaturas recibidas" icon="heroicon-o-users" />
    <x-ui.stat-card label="Pendientes" :value="$data->metricas['pendientes']" description="Requieren revisión" icon="heroicon-o-clock" tone="warning" />
</div>

<div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
    <section class="ui-card">
        <div class="ui-card-header">
            <div>
                <h3 class="font-bold text-gray-950">Información de la empresa</h3>
                <p class="mt-1 text-sm text-gray-600">Datos registrados para la vinculación con estudiantes.</p>
            </div>
            <span class="ui-badge-info">RUC verificado</span>
        </div>
        <div class="grid gap-x-8 gap-y-5 p-5 sm:grid-cols-2 sm:p-6">
            @foreach($data->detalles as $detail)
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">{{ $detail['label'] }}</p>
                    <p class="mt-1 break-words text-sm font-semibold text-gray-900">{{ $detail['value'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ui-card">
        <div class="ui-card-header">
            <div>
                <h3 class="font-bold text-gray-950">Acciones principales</h3>
                <p class="mt-1 text-sm text-gray-600">Gestiona tus oportunidades y candidatos.</p>
            </div>
        </div>
        <div class="divide-y divide-gray-100 px-5 sm:px-6">
            @foreach([
                ['route' => 'empresa.publicaciones.index', 'icon' => 'heroicon-o-newspaper', 'label' => 'Gestionar publicaciones', 'description' => 'Crea, edita y controla tus ofertas'],
                ['route' => 'empresa.postulaciones.index', 'icon' => 'heroicon-o-paper-airplane', 'label' => 'Revisar postulaciones', 'description' => 'Evalúa las candidaturas recibidas'],
            ] as $action)
                <a href="{{ route($action['route']) }}" class="group flex items-center gap-4 py-5">
                    <span class="ui-icon-box">@svg($action['icon'], 'h-5 w-5')</span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm font-bold text-gray-900 group-hover:text-blue-800">{{ $action['label'] }}</span>
                        <span class="mt-1 block text-xs text-gray-500">{{ $action['description'] }}</span>
                    </span>
                    @svg('heroicon-o-chevron-right', 'h-4 w-4 text-gray-400 group-hover:text-blue-700')
                </a>
            @endforeach
        </div>
    </section>
</div>
