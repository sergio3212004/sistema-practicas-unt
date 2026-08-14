<x-app-layout>
    <x-slot name="header">
        <x-ui.page-header
            eyebrow="Panel institucional"
            title="Resumen"
            description="Consulta el estado de tus procesos y continúa con las tareas más importantes."
            icon="heroicon-o-squares-2x2"
        />
    </x-slot>

    <div class="ui-page">
        @switch($dashboard->role()->value)
            @case('administrador')
                <x-dashboard.admin :data="$dashboard" />
                @break
            @case('alumno')
                <x-dashboard.alumno :data="$dashboard" />
                @break
            @case('profesor')
                <x-dashboard.profesor :data="$dashboard" />
                @break
            @case('empresa')
                <x-dashboard.empresa :data="$dashboard" />
                @break
        @endswitch
    </div>
</x-app-layout>
