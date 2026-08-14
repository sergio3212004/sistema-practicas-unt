<?php

use Illuminate\Support\Facades\Route;

test('public pages render a contextual browser title', function (string $route, string $title) {
    $this->get(route($route))
        ->assertOk()
        ->assertSee(
            '<title>'.$title.' | '.e(config('app.name')).'</title>',
            escape: false,
        );
})->with([
    'login' => ['login', 'Iniciar sesión'],
    'password recovery' => ['password.request', 'Recuperar contraseña'],
    'company registration' => ['empresa.register.form', 'Registro de empresa'],
]);

test('every navigable layout route has a configured title', function () {
    $routesWithTheirOwnDocument = collect([
        'admin.informes-finales.download',
        'alumno.cronograma.download-pdf',
        'alumno.drive.callback',
        'alumno.drive.conectar',
        'alumno.entregas.download',
        'alumno.ficha.download-pdf',
        'alumno.informe-final.download',
        'firma.cronograma.jefe',
        'firmas.ficha-registro.show',
        'google.auth',
        'google.callback',
        'profesor.formato-doce.alumnos',
        'profesor.formato-once.pdf',
        'profesor.informes-finales.download',
        'verification.verify',
    ]);

    $navigableRoutes = collect(Route::getRoutes())
        ->filter(fn ($route): bool => in_array('GET', $route->methods(), true))
        ->map(fn ($route): ?string => $route->getName())
        ->filter()
        ->reject(fn (string $name): bool => str_starts_with($name, 'generated::'))
        ->reject(fn (string $name): bool => str_starts_with($name, 'storage.'))
        ->reject(fn (string $name): bool => $routesWithTheirOwnDocument->contains($name));

    $configuredRoutes = collect(config('page-titles.routes'))->keys();

    expect($navigableRoutes->diff($configuredRoutes)->values()->all())->toBeEmpty();
});
