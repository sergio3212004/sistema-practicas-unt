@props(['data'])

<section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <header class="border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-sm font-bold text-white">
                    {{ $data['semana']->numero }}
                </span>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $data['semana']->nombre }}</h3>
                    <p class="text-xs text-gray-500">
                        {{ trans_choice(':count actividad|:count actividades', $data['totalActividades'], ['count' => $data['totalActividades']]) }}
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">{{ $data['progreso'] }}%</span>
                <div
                    class="h-2 w-32 rounded-full bg-gray-200"
                    role="progressbar"
                    aria-label="Progreso de la semana {{ $data['semana']->numero }}"
                    aria-valuenow="{{ $data['progreso'] }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    <div class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600" style="width: {{ $data['progreso'] }}%"></div>
                </div>
            </div>
        </div>
    </header>

    <div class="divide-y divide-gray-100">
        @forelse($data['actividades'] as $actividad)
            <x-alumno.aula.actividad :data="$actividad" />
        @empty
            <div class="p-8 text-center">
                <span class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                    @svg('heroicon-o-inbox', 'h-6 w-6 text-gray-400')
                </span>
                <p class="text-sm text-gray-500">No hay actividades en esta semana.</p>
            </div>
        @endforelse
    </div>
</section>
