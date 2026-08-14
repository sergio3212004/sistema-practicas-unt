<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    {{-- ================== CUENTA ================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <x-input-label for="email" value="Correo institucional" />
            {{-- IMPORTANTE: Agregar el campo email aunque esté disabled --}}
            <input type="hidden" name="email" value="{{ $user->email }}">
            <x-text-input
                id="email"
                type="email"
                class="mt-1 block w-full bg-gray-100"
                :value="$user->email"
                disabled
            />
        </div>

    </div>

    {{-- ================== ALUMNO ================== --}}
    @if(auth()->user()->alumno)
        <div class="pt-4 border-t border-gray-200">
            <h3 class="text-md font-semibold text-blue-700 mb-3">
                Información del Alumno
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <x-input-label value="Código de matrícula" />
                    <x-text-input
                        class="mt-1 block w-full bg-gray-100"
                        :value="auth()->user()->alumno->codigo_matricula"
                        disabled
                    />
                </div>

                <div>
                    <x-input-label value="Nombres" />
                    <x-text-input
                        class="mt-1 block w-full bg-gray-100"
                        :value="auth()->user()->alumno->nombres"
                        disabled
                    />
                </div>

                <div>
                    <x-input-label value="Apellido paterno" />
                    <x-text-input
                        class="mt-1 block w-full bg-gray-100"
                        :value="auth()->user()->alumno->apellido_paterno"
                        disabled
                    />
                </div>

                <div>
                    <x-input-label value="Apellido materno" />
                    <x-text-input
                        class="mt-1 block w-full bg-gray-100"
                        :value="auth()->user()->alumno->apellido_materno"
                        disabled
                    />
                </div>

                {{-- CAMPO TELÉFONO --}}
                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input
                        id="telefono"
                        name="telefono"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        :value="old('telefono', auth()->user()->alumno->telefono)"
                    />

                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <div>
                    <x-input-label value="Aula" />
                    <x-text-input
                        class="mt-1 block w-full bg-gray-100"
                        :value="auth()->user()->alumno->aula->numero ?? 'No asignada'"
                        disabled
                    />
                </div>

            </div>

            {{-- SECCIÓN DE CV CON GOOGLE DRIVE --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">
                    Curriculum Vitae (CV)
                </h4>

                @if(auth()->user()->alumno->cv)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">CV almacenado en Google Drive</p>
                                    <p class="text-xs text-gray-600">Último archivo seleccionado</p>
                                </div>
                            </div>
                            <a href="{{ auth()->user()->alumno->cv }}"
                               target="_blank"
                               class="inline-flex items-center px-3 py-2 border border-green-600 rounded-md text-sm font-medium text-green-600 hover:bg-green-50 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Ver CV
                            </a>
                        </div>
                    </div>
                @endif

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-700 mb-3">
                                Selecciona tu CV desde Google Drive. El archivo debe estar en formato PDF y será accesible mediante un enlace seguro.
                            </p>
                            <button type="button"
                                    onclick="openGoogleDrivePicker()"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                                </svg>
                                {{ auth()->user()->alumno->cv ? 'Cambiar CV desde Google Drive' : 'Seleccionar CV desde Google Drive' }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Campo oculto para almacenar el enlace seleccionado --}}
                <input type="hidden" id="cv_link" name="cv_link" value="{{ old('cv_link', auth()->user()->alumno->cv) }}">

                {{-- Previsualización del archivo seleccionado --}}
                <div id="selected-file-preview" class="mt-4 hidden">
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900" id="selected-file-name">-</p>
                                    <p class="text-xs text-green-600">✓ Archivo seleccionado (guardar cambios para confirmar)</p>
                                </div>
                            </div>
                            <button type="button"
                                    onclick="clearSelectedFile()"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>

                <x-input-error :messages="$errors->get('cv_link')" class="mt-2" />
            </div>
        </div>
    @endif

    {{-- ================== BOTÓN ================== --}}
    <div class="flex items-center gap-4 pt-4">
        <x-primary-button>
            Guardar cambios
        </x-primary-button>

        @if (session('status') === 'alumno-updated')
            <p class="text-sm text-green-600">
                ✓ Información actualizada correctamente.
            </p>
        @endif

        @if (session('status') === 'google-connected')
            <p class="text-sm text-blue-600">
                ✓ Conectado con Google Drive. Selecciona tu archivo.
            </p>
        @endif

        @if (session('error'))
            <p class="text-sm text-red-600">
                {{ session('error') }}
            </p>
        @endif
    </div>
</form>

{{-- Script para Google Drive Picker --}}
<script src="https://apis.google.com/js/api.js"></script>
<script>
    let pickerApiLoaded = false;

    function loadPicker() {
        gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onPickerApiLoad() {
        pickerApiLoaded = true;
    }

    function openGoogleDrivePicker() {
        // Redirigir al usuario para autenticarse con Google
        window.location.href = "{{ route('google.auth') }}";
    }

    // Si hay un token en la sesión, cargar el picker automáticamente
    @if(session('status') === 'google-connected' && session('google_drive_token'))
    window.addEventListener('load', function() {
        loadPicker();

        // Esperar a que se cargue el API
        setTimeout(function() {
            if (pickerApiLoaded) {
                const token = @json(session('google_drive_token'));
                createPicker(token.access_token);
            }
        }, 1000);
    });
    @else
    window.addEventListener('load', function() {
        loadPicker();
    });
    @endif

    function createPicker(accessToken) {
        if (pickerApiLoaded) {
            const view = new google.picker.DocsView(google.picker.ViewId.DOCS)
                .setMimeTypes('application/pdf')
                .setMode(google.picker.DocsViewMode.LIST);

            const picker = new google.picker.PickerBuilder()
                .setAppId('{{ config('services.google.client_id') }}')
                .setOAuthToken(accessToken)
                .addView(view)
                .setCallback(pickerCallback)
                .setTitle('Selecciona tu CV en formato PDF')
                .build();

            picker.setVisible(true);
        }
    }

    function pickerCallback(data) {
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
            const doc = data[google.picker.Response.DOCUMENTS][0];
            const fileId = doc[google.picker.Document.ID];
            const fileName = doc[google.picker.Document.NAME];
            const fileUrl = `https://drive.google.com/file/d/${fileId}/view`;

            // Establecer el enlace en el campo oculto
            document.getElementById('cv_link').value = fileUrl;

            // Mostrar previsualización
            document.getElementById('selected-file-name').textContent = fileName;
            document.getElementById('selected-file-preview').classList.remove('hidden');
        }
    }

    function clearSelectedFile() {
        document.getElementById('cv_link').value = '{{ old('cv_link', auth()->user()->alumno->cv ?? '') }}';
        document.getElementById('selected-file-preview').classList.add('hidden');
    }

    // Debug: ver qué se está enviando
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Teléfono:', document.getElementById('telefono').value);
        console.log('CV Link:', document.getElementById('cv_link').value);
    });
</script>
