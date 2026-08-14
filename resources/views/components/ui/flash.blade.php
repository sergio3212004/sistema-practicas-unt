@php
    $notifications = collect([
        'success' => ['title' => 'Operación completada', 'icon' => 'heroicon-o-check-circle', 'classes' => 'border-green-500 text-green-700 bg-green-50'],
        'error' => ['title' => 'No se pudo completar', 'icon' => 'heroicon-o-exclamation-circle', 'classes' => 'border-red-500 text-red-700 bg-red-50'],
        'warning' => ['title' => 'Requiere atención', 'icon' => 'heroicon-o-exclamation-triangle', 'classes' => 'border-yellow-500 text-yellow-800 bg-yellow-50'],
        'info' => ['title' => 'Información', 'icon' => 'heroicon-o-information-circle', 'classes' => 'border-blue-500 text-blue-700 bg-blue-50'],
    ])->filter(fn ($settings, $key) => session()->has($key));
@endphp

@if($notifications->isNotEmpty())
    <div class="pointer-events-none fixed inset-x-4 top-20 z-[60] flex flex-col items-end gap-3 sm:left-auto sm:right-6 sm:w-full sm:max-w-sm">
        @foreach($notifications as $key => $settings)
            <div
                x-data="{ visible: true }"
                x-show="visible"
                x-init="setTimeout(() => visible = false, 5000)"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-x-4 sm:translate-y-0"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="translate-x-4 opacity-0"
                class="pointer-events-auto w-full rounded-2xl border-l-4 bg-white p-4 shadow-raised {{ $settings['classes'] }}"
                role="status"
            >
                <div class="flex items-start gap-3">
                    @svg($settings['icon'], 'mt-0.5 h-5 w-5 shrink-0')
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-900">{{ $settings['title'] }}</p>
                        <p class="mt-0.5 text-sm leading-5 text-gray-700">{{ session($key) }}</p>
                    </div>
                    <button type="button" @click="visible = false" class="rounded-lg p-1 text-gray-500 hover:bg-white/70 hover:text-gray-900" aria-label="Cerrar notificación">
                        @svg('heroicon-o-x-mark', 'h-4 w-4')
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endif
