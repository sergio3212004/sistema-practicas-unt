<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg">
                    @svg('heroicon-o-document-text', 'w-6 h-6 text-white')
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        Ficha de Registro
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Gestiona tu ficha de prácticas pre profesionales</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(!$ficha)
                {{-- NO EXISTE FICHA - ESTADO INICIAL --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

                    <!-- Banner superior con gradiente -->
                    <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-8 py-6">
                        <div class="flex items-center justify-center">
                            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                @svg('heroicon-o-document-plus', 'w-10 h-10 text-white')
                            </div>
                        </div>
                    </div>

                    <!-- Contenido principal -->
                    <div class="px-8 py-10 text-center">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">
                            Comienza tu registro
                        </h3>

                        <p class="text-gray-600 mb-2 max-w-2xl mx-auto">
                            Aún no has registrado tu ficha de prácticas pre profesionales.
                        </p>

                        <p class="text-sm text-gray-500 mb-8 max-w-xl mx-auto">
                            Para iniciar tus prácticas, primero debes completar el registro con los datos de la empresa donde realizarás tus actividades.
                        </p>

                        <!-- Pasos a seguir -->
                        <div class="grid md:grid-cols-3 gap-6 mb-10 max-w-3xl mx-auto">
                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                                <div class="w-12 h-12 bg-blue-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-white font-bold text-lg">1</span>
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2">Registra tu ficha</h4>
                                <p class="text-sm text-gray-600">Completa los datos de la empresa y tu información</p>
                            </div>

                            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-gray-800 font-bold text-lg">2</span>
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2">Espera aprobación</h4>
                                <p class="text-sm text-gray-600">Tu ficha será revisada por el coordinador</p>
                            </div>

                            <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="text-white font-bold text-lg">3</span>
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2">Crea cronograma</h4>
                                <p class="text-sm text-gray-600">Una vez aceptada, programa tus actividades</p>
                            </div>
                        </div>

                        <!-- Botón de acción principal -->
                        <a href="{{ route('alumno.ficha.create') }}"
                           class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-800 to-blue-900 text-white font-semibold rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-200 group">
                            @svg('heroicon-o-document-plus', 'w-5 h-5 mr-2 group-hover:rotate-12 transition-transform')
                            Registrar Ficha de Prácticas
                        </a>
                    </div>
                </div>

            @else
                {{-- EXISTE FICHA - VISTA CON INFORMACIÓN --}}
                <div class="space-y-6">

                    <!-- Card principal con información de la ficha -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

                        <!-- Header con estado -->
                        <div class="bg-gradient-to-r from-blue-800 to-blue-900 px-8 py-6">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                        @svg('heroicon-o-briefcase', 'w-8 h-8 text-white')
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-1">
                                            Tu Ficha de Registro
                                        </h3>
                                        <p class="text-blue-200 text-sm">
                                            {{ $ficha->razon_social }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    @if($ficha->aceptado === true)
                                        <span class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-full shadow-lg">
                                            @svg('heroicon-o-check-circle', 'w-5 h-5 mr-2')
                                            Ficha Aceptada
                                        </span>

                                    @elseif($ficha->aceptado === false)
                                        <span class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-full shadow-lg">
                                            @svg('heroicon-o-x-circle', 'w-5 h-5 mr-2')
                                            Rechazada
                                        </span>

                                    @else
                                        <span class="inline-flex items-center px-4 py-2 bg-yellow-400 text-gray-900 text-sm font-semibold rounded-full shadow-lg">
                                            @svg('heroicon-o-clock', 'w-5 h-5 mr-2')
                                            En Revisión
                                        </span>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="px-8 py-6">
                            @if($ficha->aceptado===null)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-information-circle', 'w-6 h-6 text-yellow-600')
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-yellow-800 mb-1">Tu ficha está en proceso de revisión</h4>
                                            <p class="text-sm text-yellow-700">
                                                El coordinador académico está revisando tu solicitud. Recibirás una notificación cuando sea aprobada.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($ficha->aceptado===true)
                                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-check-badge', 'w-6 h-6 text-green-600')
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-green-800 mb-1">¡Felicitaciones! Tu ficha ha sido aceptada</h4>
                                            <p class="text-sm text-green-700">
                                                Ahora puedes proceder a crear tu cronograma de actividades y comenzar tus prácticas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-x-circle', 'w-6 h-6 text-red-600')
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-semibold text-red-800 mb-1">Lo sentimos, tu ficha ha sido rechazada</h4>
                                            <p class="text-sm text-red-700">
                                                Comunicate con tu profesor coordinador para saber cual ha sido el problema, elimina la actual y vuelve a iniciar el proceso.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Mostrar calificación si existe -->
                            @if($ficha->cronograma && $ficha->cronograma->estaCalificado())
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-xl p-6 mb-6">
                                    <div class="flex items-center justify-between flex-wrap gap-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                                @svg('heroicon-o-academic-cap', 'w-8 h-8 text-white')
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-800 mb-1">Calificación Final</h4>
                                                <p class="text-sm text-gray-600">Tu cronograma ha sido evaluado</p>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg border-4 border-purple-600">
                                                <span class="text-3xl font-bold text-purple-600">
                                                    {{ number_format($ficha->cronograma->calificacion, 0) }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 font-medium">de 20</p>
                                        </div>
                                    </div>

                                    @php
                                        $calificacion = $ficha->cronograma->calificacion;
                                        if ($calificacion >= 17) {
                                            $mensaje = '¡Excelente desempeño!';
                                            $color = 'text-green-700';
                                            $bgColor = 'bg-green-100';
                                        } elseif ($calificacion >= 14) {
                                            $mensaje = 'Buen trabajo';
                                            $color = 'text-blue-700';
                                            $bgColor = 'bg-blue-100';
                                        } elseif ($calificacion >= 11) {
                                            $mensaje = 'Desempeño regular';
                                            $color = 'text-yellow-700';
                                            $bgColor = 'bg-yellow-100';
                                        } else {
                                            $mensaje = 'Necesitas mejorar';
                                            $color = 'text-red-700';
                                            $bgColor = 'bg-red-100';
                                        }
                                    @endphp

                                    <div class="mt-4 {{ $bgColor }} rounded-lg px-4 py-3">
                                        <p class="text-sm font-semibold {{ $color }} text-center">
                                            {{ $mensaje }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Grid de acciones -->
                            <div class="grid md:grid-cols-2 gap-4">

                                <!-- Ver Ficha -->
                                <a href="{{ route('alumno.ficha.show', $ficha) }}"
                                   class="group relative bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200 rounded-xl p-6 transition-all duration-200 hover:shadow-lg">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="w-12 h-12 bg-blue-800 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            @svg('heroicon-o-document-magnifying-glass', 'w-6 h-6 text-white')
                                        </div>
                                        <div class="w-6 h-6 bg-blue-800 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform">
                                            @svg('heroicon-o-arrow-right', 'w-4 h-4 text-white')
                                        </div>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-800 mb-1">Ver Ficha Completa</h4>
                                    <p class="text-sm text-gray-600">Revisa todos los detalles de tu registro</p>
                                </a>

                                <!-- Cronograma -->
                                @if(!$ficha->cronograma)
                                    <a href="{{ route('alumno.cronograma.create', $ficha) }}"
                                       class="group relative bg-gradient-to-br from-indigo-50 to-indigo-100 hover:from-indigo-100 hover:to-indigo-200 border-2 border-indigo-200 rounded-xl p-6 transition-all duration-200 hover:shadow-lg">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                @svg('heroicon-o-calendar-days', 'w-6 h-6 text-white')
                                            </div>
                                            <div class="w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform">
                                                @svg('heroicon-o-arrow-right', 'w-4 h-4 text-white')
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-1">Crear Cronograma</h4>
                                        <p class="text-sm text-gray-600">Programa tus actividades de prácticas</p>
                                    </a>
                                @else
                                    <a href="{{ route('alumno.cronograma.show', $ficha->cronograma) }}"
                                       class="group relative bg-gradient-to-br from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border-2 border-emerald-200 rounded-xl p-6 transition-all duration-200 hover:shadow-lg">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="w-12 h-12 bg-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                                @svg('heroicon-o-calendar-days', 'w-6 h-6 text-white')
                                            </div>
                                            <div class="w-6 h-6 bg-emerald-600 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform">
                                                @svg('heroicon-o-arrow-right', 'w-4 h-4 text-white')
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-800 mb-1">Ver Cronograma</h4>
                                        <p class="text-sm text-gray-600">Consulta tu planificación de actividades</p>
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Card informativa adicional -->
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-800 rounded-lg flex items-center justify-center">
                                    @svg('heroicon-o-light-bulb', 'w-6 h-6 text-white')
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-2">¿Necesitas ayuda?</h4>
                                <p class="text-sm text-gray-600 mb-3">
                                    Si tienes dudas sobre tu ficha o el proceso de prácticas, puedes contactar al coordinador académico.
                                </p>

                            </div>
                        </div>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
