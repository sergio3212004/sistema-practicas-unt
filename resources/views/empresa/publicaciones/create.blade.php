<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                <x-heroicon-o-document-text class="h-8 w-8 text-indigo-600"/>
                Nueva Publicación
            </h1>

            <a href="{{ route('empresa.publicaciones.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                Volver
            </a>
        </div>

        {{-- Card --}}
        <div class="relative">
            <!-- Glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl blur opacity-20"></div>

            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden">

                {{-- Header card --}}
                <div class="bg-gradient-to-br from-blue-800 to-indigo-900 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">
                        Información de la vacante
                    </h2>
                    <p class="text-blue-100 text-sm">
                        Publica una nueva convocatoria de prácticas preprofesionales
                    </p>
                </div>

                {{-- Form --}}
                <form action="{{ route('empresa.publicaciones.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-8 space-y-6">
                    @csrf

                    {{-- Título --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Título de la publicación
                        </label>
                        <input type="text"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               required
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Cargo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Cargo solicitado
                        </label>
                        <input type="text"
                               name="cargo"
                               value="{{ old('cargo') }}"
                               required
                               placeholder="Ej. Practicante de Desarrollo de Software"
                               class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Descripción de la vacante
                        </label>
                        <textarea name="descripcion"
                                  rows="5"
                                  required
                                  class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion') }}</textarea>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Estado de la vacante
                        </label>
                        <select name="estado"
                                required
                                class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Disponible" {{ old('estado') === 'Disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>
                            <option value="Cubierta" {{ old('estado') === 'Cubierta' ? 'selected' : '' }}>
                                Cubierta
                            </option>
                        </select>
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Imagen referencial
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition">
                            <input type="file"
                                   name="imagen"
                                   accept="image/*"
                                   class="w-full text-sm text-gray-600">
                            <p class="mt-2 text-xs text-gray-500">
                                PNG o JPG — Máx. 2MB
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-6 flex justify-end gap-4">
                        <a href="{{ route('empresa.publicaciones.index') }}"
                           class="px-5 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow hover:from-blue-700 hover:to-indigo-700 transition">
                            Publicar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
