<?php

use App\Http\Controllers\Empresa\PostulacionController;
use App\Http\Controllers\Empresa\PublicacionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:empresa', 'company.approved'])
    ->prefix('empresa')
    ->name('empresa.')
    ->group(function (): void {
        Route::resource('publicaciones', PublicacionController::class)
            ->except('show')
            ->parameters(['publicaciones' => 'publicacion']);

        Route::get('postulaciones', [PostulacionController::class, 'index'])->name('postulaciones.index');
        Route::get('postulaciones/{publicacion}', [PostulacionController::class, 'show'])
            ->name('postulaciones.show');
        Route::patch('postulaciones/{postulacion}/aprobar', [PostulacionController::class, 'aprobar'])
            ->name('postulaciones.aprobar');
        Route::patch('postulaciones/{postulacion}/rechazar', [PostulacionController::class, 'rechazar'])
            ->name('postulaciones.rechazar');
    });
