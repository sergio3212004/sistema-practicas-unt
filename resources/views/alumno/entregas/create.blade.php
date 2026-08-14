{{-- resources/views/alumno/entregas/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Nueva Entrega
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $actividad->titulo }}
                </p>
            </div>
            <a href="{{ route('alumno.aula.index', $actividad->aula) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                @svg('heroicon-o-arrow-left', 'w-4 h-4 mr-2')
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Información de la Actividad --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        @svg('heroicon-o-information-circle', 'w-6 h-6 text-indigo-600')
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Información de la Actividad</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase">Semana</p>
                                <p class="text-sm text-gray-900 font-medium">{{ $actividad->semana->nombre }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase">Tipo</p>
                                <p class="text-sm text-gray-900 font-medium">{{ $actividad->tipoActividad->nombre }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase">Fecha Inicio</p>
                                <p class="text-sm text-gray-900 font-medium">{{ $actividad->fecha_inicio->format('d/m/Y H:i') }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase">Fecha Límite</p>
                                <p class="text-sm text-red-600 font-medium">{{ $actividad->fecha_limite->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if($actividad->descripcion)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs font-medium text-gray-500 uppercase mb-1">Descripción</p>
                                <p class="text-sm text-gray-700">{{ $actividad->descripcion }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Formulario de Entrega --}}
            <form action="{{ route('alumno.entregas.store', $actividad) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="formEntrega">
                @csrf

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                    {{-- Header del formulario --}}
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            @svg('heroicon-o-arrow-up-tray', 'w-5 h-5 mr-2 text-indigo-600')
                            Realizar Entrega
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Modo de entrega:
                            <span class="font-semibold">
                                {{ $actividad->tipoActividad->modo_entrega === 'pdf' ? 'Archivo PDF' : 'Google Drive' }}
                            </span>
                        </p>
                    </div>

                    <div class="p-6 space-y-6">

                        @if($actividad->tipoActividad->modo_entrega === 'pdf')
                            {{-- Modo: Subir archivo PDF --}}
                            <div>
                                <label for="archivo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Archivo de Entrega <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input type="file"
                                           name="archivo"
                                           id="archivo"
                                           accept=".pdf,.doc,.docx,.zip,.rar"
                                           class="hidden"
                                           onchange="mostrarNombreArchivo(this)">

                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-400 transition-colors cursor-pointer"
                                         onclick="document.getElementById('archivo').click()">
                                        <div class="flex flex-col items-center">
                                            @svg('heroicon-o-cloud-arrow-up', 'w-12 h-12 text-gray-400 mb-3')
                                            <p class="text-sm font-medium text-gray-700 mb-1">
                                                Haz clic para seleccionar un archivo
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                PDF, DOC, DOCX, ZIP o RAR (máx. 10MB)
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Mostrar nombre del archivo seleccionado --}}
                                    <div id="archivoSeleccionado" class="hidden mt-3">
                                        <div class="flex items-center justify-between p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                @svg('heroicon-o-document', 'w-5 h-5 text-indigo-600')
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" id="nombreArchivo"></p>
                                                    <p class="text-xs text-gray-500" id="tamañoArchivo"></p>
                                                </div>
                                            </div>
                                            <button type="button"
                                                    onclick="removerArchivo()"
                                                    class="text-red-600 hover:text-red-800">
                                                @svg('heroicon-o-x-circle', 'w-5 h-5')
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('archivo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        @elseif($actividad->tipoActividad->modo_entrega === 'drive')
                            {{-- Modo: Google Drive --}}

                            @if(!$driveConectado)
                                {{-- No está conectado a Drive --}}
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-exclamation-triangle', 'w-8 h-8 text-amber-600')
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-amber-900 mb-2">
                                                Conecta tu cuenta de Google Drive
                                            </h4>
                                            <p class="text-sm text-amber-800 mb-4">
                                                Para realizar entregas mediante Google Drive, primero debes conectar tu cuenta de Google.
                                            </p>
                                            <a href="{{ route('alumno.drive.conectar') }}"
                                               class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-amber-900 border border-amber-300 rounded-lg font-medium transition-colors">
                                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                                </svg>
                                                Conectar Google Drive
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Está conectado - Mostrar Google Picker --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Archivo de Google Drive <span class="text-red-500">*</span>
                                    </label>

                                    <input type="hidden" name="drive_file_id" id="driveFileId">
                                    <input type="hidden" name="drive_file_name" id="driveFileName">

                                    <div id="drivePickerContainer">
                                        <button type="button"
                                                onclick="abrirDrivePicker()"
                                                class="w-full border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-400 transition-colors">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-400 mb-3" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM19 18H6c-2.21 0-4-1.79-4-4 0-2.05 1.53-3.76 3.56-3.97l1.07-.11.5-.95C8.08 7.14 9.94 6 12 6c2.62 0 4.88 1.86 5.39 4.43l.3 1.5 1.53.11c1.56.1 2.78 1.41 2.78 2.96 0 1.65-1.35 3-3 3zM8 13h2.55v3h2.9v-3H16l-4-4z"/>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-700 mb-1">
                                                    Seleccionar archivo de Google Drive
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Solo archivos PDF
                                                </p>
                                            </div>
                                        </button>
                                    </div>

                                    {{-- Mostrar archivo seleccionado de Drive --}}
                                    <div id="driveArchivoSeleccionado" class="hidden mt-3">
                                        <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" id="driveNombreArchivo"></p>
                                                    <p class="text-xs text-gray-500">Google Drive</p>
                                                </div>
                                            </div>
                                            <button type="button"
                                                    onclick="removerDriveArchivo()"
                                                    class="text-red-600 hover:text-red-800">
                                                @svg('heroicon-o-x-circle', 'w-5 h-5')
                                            </button>
                                        </div>
                                    </div>

                                    @error('drive_file_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        @endif



                    </div>

                    {{-- Footer con botones --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <a href="{{ route('alumno.aula.index', $actividad->aula) }}"
                           class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            Cancelar
                        </a>

                        <button type="submit"
                                id="btnEntregar"
                                @if($actividad->tipoActividad->modo_entrega === 'drive' && !$driveConectado) disabled @endif
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            @svg('heroicon-o-paper-airplane', 'w-5 h-5 mr-2')
                            Realizar Entrega
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    @if($actividad->tipoActividad->modo_entrega === 'drive' && $driveConectado)
        {{-- Google Picker API --}}
        <script src="https://apis.google.com/js/api.js"></script>
        <script>
            let pickerApiLoaded = false;
            let oauthToken = null;

            // Cargar el API de Google Picker
            function cargarPicker() {
                gapi.load('picker', {'callback': onPickerApiLoad});
                gapi.load('auth', {'callback': onAuthApiLoad});
            }

            function onAuthApiLoad() {
                // El token ya está en la sesión del servidor
                oauthToken = 'ya_autenticado';
            }

            function onPickerApiLoad() {
                pickerApiLoaded = true;
            }

            // Abrir el selector de Google Drive
            function abrirDrivePicker() {
                if (pickerApiLoaded && oauthToken) {
                    const picker = new google.picker.PickerBuilder()
                        .addView(new google.picker.DocsView()
                            .setMimeTypes('application/pdf')
                            .setMode(google.picker.DocsViewMode.LIST))
                        .setOAuthToken('{{ session("google_drive_token")["access_token"] ?? "" }}')
                        .setDeveloperKey('{{ config("services.google.api_key") }}')
                        .setCallback(pickerCallback)
                        .setTitle('Selecciona un archivo PDF')
                        .build();
                    picker.setVisible(true);
                }
            }

            // Callback cuando se selecciona un archivo
            function pickerCallback(data) {
                if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                    const doc = data[google.picker.Response.DOCUMENTS][0];
                    const fileId = doc[google.picker.Document.ID];
                    const fileName = doc[google.picker.Document.NAME];

                    // Guardar en campos ocultos
                    document.getElementById('driveFileId').value = fileId;
                    document.getElementById('driveFileName').value = fileName;

                    // Mostrar archivo seleccionado
                    document.getElementById('driveNombreArchivo').textContent = fileName;
                    document.getElementById('drivePickerContainer').classList.add('hidden');
                    document.getElementById('driveArchivoSeleccionado').classList.remove('hidden');
                }
            }

            // Remover archivo de Drive seleccionado
            function removerDriveArchivo() {
                document.getElementById('driveFileId').value = '';
                document.getElementById('driveFileName').value = '';
                document.getElementById('drivePickerContainer').classList.remove('hidden');
                document.getElementById('driveArchivoSeleccionado').classList.add('hidden');
            }

            // Cargar el picker al cargar la página
            window.onload = cargarPicker;
        </script>
    @endif

    @if($actividad->tipoActividad->modo_entrega === 'pdf')
        {{-- Scripts para manejo de archivos PDF --}}
        <script>
            function mostrarNombreArchivo(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const tamaño = (file.size / 1024 / 1024).toFixed(2); // MB

                    document.getElementById('nombreArchivo').textContent = file.name;
                    document.getElementById('tamañoArchivo').textContent = tamaño + ' MB';
                    document.getElementById('archivoSeleccionado').classList.remove('hidden');

                    // Habilitar botón de envío
                    document.getElementById('btnEntregar').disabled = false;
                }
            }

            function removerArchivo() {
                document.getElementById('archivo').value = '';
                document.getElementById('archivoSeleccionado').classList.add('hidden');
            }
        </script>
    @endif
</x-app-layout>
