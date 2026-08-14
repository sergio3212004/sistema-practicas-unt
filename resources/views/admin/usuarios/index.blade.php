<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Administración"
            title="Gestión de usuarios"
            description="Administra cuentas, perfiles y permisos de acceso al sistema."
            icon="heroicon-o-users"
        >
            <x-slot name="actions">
                <a href="{{ route('admin.usuarios.create') }}" class="ui-btn-primary">
                    @svg('heroicon-o-plus', 'h-4 w-4') Nuevo usuario
                </a>
            </x-slot>
        </x-ui.page-header>
    </x-slot>

    <div class="ui-page">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.stat-card label="Usuarios" :value="$users->total()" description="Total registrado" icon="heroicon-o-users" />
            <x-ui.stat-card label="Estudiantes" :value="$roleCounts->get('alumno', 0)" description="Cuentas académicas" icon="heroicon-o-academic-cap" />
            <x-ui.stat-card label="Docentes" :value="$roleCounts->get('profesor', 0)" description="Supervisión de aulas" icon="heroicon-o-user-group" />
            <x-ui.stat-card label="Empresas" :value="$roleCounts->get('empresa', 0)" description="Organizaciones vinculadas" icon="heroicon-o-building-office-2" tone="success" />
        </div>

        <section class="ui-card overflow-hidden">
            <div class="ui-card-header">
                <div>
                    <h2 class="font-bold text-gray-950">Directorio de usuarios</h2>
                    <p class="mt-1 text-sm text-gray-600">Mostrando cuentas registradas y su rol institucional.</p>
                </div>
                <span class="ui-badge-info">{{ $users->total() }} registros</span>
            </div>

            @if($users->isEmpty())
                <div class="p-6">
                    <x-ui.empty-state title="No hay usuarios registrados" description="Crea la primera cuenta para empezar a gestionar el sistema." icon="heroicon-o-users">
                        <x-slot name="actions">
                            <a href="{{ route('admin.usuarios.create') }}" class="ui-btn-primary">Crear usuario</a>
                        </x-slot>
                    </x-ui.empty-state>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="ui-table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre o entidad</th>
                                <th scope="col">Rol</th>
                                <th scope="col" class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $role = \App\Enums\UserRole::tryFrom($user->rol->nombre);
                                    $isCompany = $user->rol->nombre === 'empresa';
                                @endphp
                                <tr class="transition hover:bg-blue-50/40">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-700 text-sm font-bold text-white">
                                                {{ str($user->email)->substr(0, 1)->upper() }}
                                            </span>
                                            <span class="break-all font-semibold text-gray-900">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="font-semibold text-gray-900">{{ $user->nombre ?: 'Sin perfil asignado' }}</p>
                                        @if($isCompany && $user->empresa?->razonSocial?->acronimo)
                                            <p class="mt-0.5 text-xs text-gray-500">{{ $user->empresa->razonSocial->acronimo }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="{{ $isCompany ? 'ui-badge-success' : 'ui-badge-info' }}">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                            {{ $role?->label() ?? ucfirst($user->rol->nombre) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex justify-end gap-1">
                                            <a href="{{ route('admin.usuarios.show', $user) }}" class="ui-btn-ghost px-2.5" aria-label="Ver usuario {{ $user->email }}">
                                                @svg('heroicon-o-eye', 'h-5 w-5')
                                            </a>
                                            <a href="{{ route('admin.usuarios.edit', $user) }}" class="ui-btn-ghost px-2.5" aria-label="Editar usuario {{ $user->email }}">
                                                @svg('heroicon-o-pencil-square', 'h-5 w-5')
                                            </a>
                                            <form action="{{ route('admin.usuarios.destroy', $user) }}" method="POST" @submit="if (!confirm('¿Confirmas la eliminación de este usuario? Esta acción no se puede deshacer.')) $event.preventDefault()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ui-btn-ghost px-2.5 text-red-700 hover:bg-red-50 hover:text-red-800" aria-label="Eliminar usuario {{ $user->email }}">
                                                    @svg('heroicon-o-trash', 'h-5 w-5')
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 text-sm text-gray-600 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <p>Mostrando <strong class="text-gray-900">{{ $users->firstItem() }}–{{ $users->lastItem() }}</strong> de <strong class="text-gray-900">{{ $users->total() }}</strong></p>
                    {{ $users->onEachSide(1)->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
