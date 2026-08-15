<x-app-layout :title="'Usuario · '.($usuario->nombre ?: $usuario->email)">
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración"
            :title="$usuario->nombre ?: 'Cuenta sin nombre de perfil'"
            :description="$usuario->email"
            icon="heroicon-o-user-circle"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.usuarios.index') }}" class="ui-btn-secondary">@svg('heroicon-o-arrow-left', 'h-4 w-4') Usuarios</a>
                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="ui-btn-primary">@svg('heroicon-o-pencil-square', 'h-4 w-4') Editar usuario</a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page max-w-6xl">
        <section class="ui-card overflow-hidden">
            <div class="border-b border-gray-200 bg-blue-950 px-5 py-6 text-white sm:px-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-xl font-bold" aria-hidden="true">
                            {{ str($usuario->email)->substr(0, 1)->upper() }}
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-lg font-bold">{{ $usuario->nombre ?: $usuario->email }}</p>
                            <p class="mt-1 break-all text-sm text-blue-100">{{ $usuario->email }}</p>
                        </div>
                    </div>
                    <span class="ui-badge border-white/15 bg-white/10 text-white">
                        @svg('heroicon-o-shield-check', 'h-4 w-4') {{ ucfirst($usuario->rol->nombre) }}
                    </span>
                </div>
            </div>

            <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Correo de acceso</p>
                    <p class="mt-1 break-all font-semibold text-gray-900">{{ $usuario->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-500">Rol y permisos</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ ucfirst($usuario->rol->nombre) }}</p>
                </div>
            </div>
        </section>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <x-ui.section-heading
                    title="Información del perfil"
                    :description="'Datos específicos de la cuenta con rol '.ucfirst($usuario->rol->nombre).'.'"
                    icon="heroicon-o-identification"
                />
            </div>
            <div class="ui-card-body">
                @switch($usuario->rol->nombre)
                    @case('administrador') @include('admin.usuarios.partials.show-administrador') @break
                    @case('alumno') @include('admin.usuarios.partials.show-alumno') @break
                    @case('empresa') @include('admin.usuarios.partials.show-empresa') @break
                    @case('profesor') @include('admin.usuarios.partials.show-profesor') @break
                    @default
                        <x-ui.empty-state title="Perfil no disponible" description="Este rol no tiene información de perfil asociada." icon="heroicon-o-identification" />
                @endswitch
            </div>
        </section>

        <section class="rounded-2xl border border-red-200 bg-red-50 p-5 sm:flex sm:items-center sm:justify-between sm:gap-6 sm:p-6" aria-labelledby="eliminar-usuario-titulo">
            <div>
                <h2 id="eliminar-usuario-titulo" class="font-bold text-red-800">Eliminar cuenta</h2>
                <p class="mt-1 max-w-3xl text-sm leading-6 text-red-700">Esta acción elimina la cuenta y su perfil asociado. No se puede deshacer.</p>
            </div>
            <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="mt-4 shrink-0 sm:mt-0" @submit="if (!confirm('¿Confirmas la eliminación de este usuario? Esta acción no se puede deshacer.')) $event.preventDefault()">
                @csrf
                @method('DELETE')
                <button type="submit" class="ui-btn-danger w-full sm:w-auto">@svg('heroicon-o-trash', 'h-4 w-4') Eliminar usuario</button>
            </form>
        </section>
    </div>
</x-app-layout>
