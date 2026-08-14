<?php

use Illuminate\Support\Facades\Route;

test('state-changing routes use non-idempotent HTTP verbs', function (string $routeName, string $method) {
    $route = Route::getRoutes()->getByName($routeName);

    expect($route)->not->toBeNull()
        ->and($route->methods())->toContain($method);
})->with([
    ['alumno.practicas.postular', 'POST'],
    ['profesor.formato-once.destroy', 'DELETE'],
    ['profesor.formato-doce.destroy', 'DELETE'],
]);

test('the company publication resource has an explicit singular parameter', function () {
    $route = Route::getRoutes()->getByName('empresa.publicaciones.edit');

    expect($route->parameterNames())->toBe(['publicacion']);
});
