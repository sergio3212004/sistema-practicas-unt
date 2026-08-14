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
        @if (isset($administrador))
            <x-dashboard.admin :administrador="$administrador" :semestres="$semestres" />
        @elseif (isset($alumno))
            <x-dashboard.alumno :alumno="$alumno" :metricas="$metricasAlumno" />
        @elseif (isset($profesor))
            <x-dashboard.profesor
                :semestre-activo="$semestreActivo"
                :profesor="$profesor"
                :aulas="$aulas"
                :total-entregas="$totalEntregas"
                :actividades-activas="$actividadesActivas"
            />
        @elseif (isset($empresa))
            <x-dashboard.empresa :empresa="$empresa" />
        @endif
    </div>
</x-app-layout>
