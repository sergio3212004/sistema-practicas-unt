<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Datos de demostración
    |--------------------------------------------------------------------------
    |
    | Las cuentas demo están deshabilitadas por defecto en todos los entornos.
    | Sus credenciales pueden sobrescribirse sin editar el código fuente.
    |
    */
    'demo_enabled' => env('SEED_DEMO_DATA', false),

    'semester' => env('SEED_SEMESTER', '2026-II'),

    'users' => [
        'administrador' => [
            'email' => env('SEED_ADMIN_EMAIL', 'administrador.demo@unitru.edu.pe'),
            'password' => env('SEED_ADMIN_PASSWORD', 'UNT.Administracion@2026'),
            'legacy_email' => 'admin@unitru.edu.pe',
        ],
        'alumno' => [
            'email' => env('SEED_STUDENT_EMAIL', 'alumno.demo@unitru.edu.pe'),
            'password' => env('SEED_STUDENT_PASSWORD', 'UNT.Estudiante@2026'),
            'legacy_email' => 'smonge@unitru.edu.pe',
        ],
        'empresa' => [
            'email' => env('SEED_COMPANY_EMAIL', 'empresa.demo@unitru.edu.pe'),
            'password' => env('SEED_COMPANY_PASSWORD', 'UNT.Empresa@2026'),
            'legacy_email' => 'smonge67000123@gmail.com',
        ],
        'profesor' => [
            'email' => env('SEED_TEACHER_EMAIL', 'profesor.demo@unitru.edu.pe'),
            'password' => env('SEED_TEACHER_PASSWORD', 'UNT.Docencia@2026'),
            'legacy_email' => 'profesor2@unitru.edu.pe',
        ],
    ],
];
