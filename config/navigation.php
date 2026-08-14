<?php

return [
    'administrador' => [
        ['route' => 'admin.usuarios.index', 'pattern' => 'admin.usuarios.*', 'label' => 'Usuarios', 'icon' => 'heroicon-o-users'],
        ['route' => 'admin.aulas.index', 'pattern' => 'admin.aulas.*', 'label' => 'Aulas', 'icon' => 'heroicon-o-academic-cap'],
        ['route' => 'admin.aprobaciones.index', 'pattern' => 'admin.aprobaciones.*', 'label' => 'Aprobaciones', 'icon' => 'heroicon-o-check-circle'],
        ['route' => 'admin.informes-finales.index', 'pattern' => 'admin.informes-finales.*', 'label' => 'Informes finales', 'icon' => 'heroicon-o-document-chart-bar'],
    ],
    'alumno' => [
        ['route' => 'alumno.practicas.index', 'pattern' => 'alumno.practicas.*', 'label' => 'Prácticas disponibles', 'icon' => 'heroicon-o-briefcase'],
        ['route' => 'alumno.ficha.index', 'pattern' => 'alumno.ficha*', 'label' => 'Ficha de registro', 'icon' => 'heroicon-o-document-text'],
        ['route' => 'alumno.informe-final.index', 'pattern' => 'alumno.informe-final.*', 'label' => 'Informe final', 'icon' => 'heroicon-o-document-arrow-up'],
    ],
    'profesor' => [
        ['route' => 'profesor.informes-finales.index', 'pattern' => 'profesor.informes-finales.*', 'label' => 'Informes finales', 'icon' => 'heroicon-o-document-chart-bar'],
        ['route' => 'profesor.formato-once.index', 'pattern' => 'profesor.formato-once.*', 'label' => 'Formato 11 — PPP', 'icon' => 'heroicon-o-clipboard-document-check'],
        ['route' => 'profesor.formato-doce.index', 'pattern' => 'profesor.formato-doce.*', 'label' => 'Formato 12 — PPP', 'icon' => 'heroicon-o-clipboard-document-check'],
    ],
    'empresa' => [
        ['route' => 'empresa.publicaciones.index', 'pattern' => 'empresa.publicaciones.*', 'label' => 'Publicaciones', 'icon' => 'heroicon-o-newspaper'],
        ['route' => 'empresa.postulaciones.index', 'pattern' => 'empresa.postulaciones.*', 'label' => 'Postulaciones', 'icon' => 'heroicon-o-paper-airplane'],
    ],
];
