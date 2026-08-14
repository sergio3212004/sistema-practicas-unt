<?php

use App\Http\Controllers\Admin\AprobacionController;
use App\Http\Controllers\Admin\AulaController;
use App\Http\Controllers\Admin\InformeFinalController;
use App\Http\Controllers\Admin\PerfilController;
use App\Http\Controllers\Admin\SemestreController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::post('semestre/cerrar', [SemestreController::class, 'cerrar'])->name('semestre.cerrar');
        Route::post('semestre/nuevo', [SemestreController::class, 'store'])->name('semestre.nuevo');

        Route::resource('usuarios', UserController::class);
        Route::resource('aulas', AulaController::class);
        Route::get('aulas/{aula}/agregar-alumnos', [AulaController::class, 'agregarAlumnos'])
            ->name('aulas.agregar-alumnos');
        Route::post('aulas/{aula}/asignar-alumnos', [AulaController::class, 'asignarAlumnos'])
            ->name('aulas.asignar-alumnos');
        Route::delete('aulas/{aula}/quitar-alumno/{alumno}', [AulaController::class, 'quitarAlumno'])
            ->name('aulas.quitar-alumno');

        Route::get('aprobaciones', [AprobacionController::class, 'index'])->name('aprobaciones.index');
        Route::post('aprobaciones/{solicitud}/aprobar', [AprobacionController::class, 'aprobar'])
            ->name('aprobaciones.aprobar');
        Route::delete('aprobaciones/{solicitud}/rechazar', [AprobacionController::class, 'rechazar'])
            ->name('aprobaciones.rechazar');

        Route::get('perfil/empresa/{id}', [PerfilController::class, 'empresa'])->name('perfil.empresa');
        Route::get('perfil/solicitud/{id}', [PerfilController::class, 'solicitudEmpresa'])
            ->name('perfil.solicitud');

        Route::get('informes-finales', [InformeFinalController::class, 'index'])
            ->name('informes-finales.index');
        Route::get('informes-finales/{informe}/download', [InformeFinalController::class, 'download'])
            ->name('informes-finales.download');
        Route::delete('informes-finales/{informe}', [InformeFinalController::class, 'destroy'])
            ->name('informes-finales.destroy');
    });
