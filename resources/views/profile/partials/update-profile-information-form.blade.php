<section>
    <header>
        <h2 class="text-lg font-medium text-blue-700">
            Información del Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Datos de tu cuenta institucional.
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- ================== ALUMNO ================== --}}
        @if(auth()->user()->alumno)
            @include('profile.partials.alumno-information')
        @endif

        {{-- ================== PROFESOR ================== --}}
        @if(auth()->user()->profesor)
            @include('profile.partials.profesor-information')
        @endif

        {{-- ================== EMPRESA ================== --}}
        @if(auth()->user()->empresa)
            @include('profile.partials.empresa-information')
        @endif
    </div>
</section>
