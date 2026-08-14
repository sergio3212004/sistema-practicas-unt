<?php

use App\Http\Controllers\Alumno\AulaController;
use App\Http\Controllers\Alumno\CronogramaController;
use App\Http\Controllers\Alumno\EntregaController;
use App\Http\Controllers\Alumno\FichaRegistroController;
use App\Http\Controllers\Alumno\InformeFinalController;
use App\Http\Controllers\Alumno\PostulacionController;
use App\Http\Controllers\Alumno\VerPracticaController;
use App\Http\Controllers\GoogleDriveController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:alumno'])
    ->prefix('alumno')
    ->name('alumno.')
    ->group(function (): void {
        Route::get('practicas', [VerPracticaController::class, 'index'])->name('practicas.index');
        Route::get('practicas/{id}', [VerPracticaController::class, 'show'])->name('practicas.show');
        Route::post('practicas/{practica}/postular', [PostulacionController::class, 'store'])
            ->name('practicas.postular');

        Route::get('drive/conectar', [GoogleDriveController::class, 'redirectToGoogle'])->name('drive.conectar');
        Route::get('drive/callback', [GoogleDriveController::class, 'handleGoogleCallback'])->name('drive.callback');

        Route::get('fichas', [FichaRegistroController::class, 'index'])->name('ficha.index');
        Route::get('fichas/create', [FichaRegistroController::class, 'create'])->name('ficha.create');
        Route::post('fichas/store', [FichaRegistroController::class, 'store'])->name('ficha-registro.store');
        Route::get('fichas/{fichaRegistro}', [FichaRegistroController::class, 'show'])->name('ficha.show');
        Route::delete('fichas/{fichaRegistro}', [FichaRegistroController::class, 'destroy'])
            ->name('ficha.destroy');
        Route::get('fichas/{fichaRegistro}/download-pdf', [FichaRegistroController::class, 'downloadPdf'])
            ->name('ficha.download-pdf');

        Route::get('cronograma/create/{fichaRegistro}', [CronogramaController::class, 'create'])
            ->name('cronograma.create');
        Route::post('cronograma/{fichaRegistro}', [CronogramaController::class, 'store'])
            ->name('cronograma.store');
        Route::get('cronograma/{cronograma}', [CronogramaController::class, 'show'])
            ->name('cronograma.show');
        Route::delete('cronograma/{cronograma}', [CronogramaController::class, 'destroy'])
            ->name('cronograma.destroy');
        Route::get('cronograma/{cronograma}/download-pdf', [CronogramaController::class, 'downloadPdf'])
            ->name('cronograma.download-pdf');

        Route::get('aula/{aula}', [AulaController::class, 'index'])->name('aula.index');

        Route::get('entregas/crear/{actividad}', [EntregaController::class, 'create'])->name('entregas.create');
        Route::post('entregas/guardar/{actividad}', [EntregaController::class, 'store'])->name('entregas.store');
        Route::get('entregas/{entrega}', [EntregaController::class, 'show'])->name('entregas.show');
        Route::get('entregas/{entrega}/editar', [EntregaController::class, 'edit'])->name('entregas.edit');
        Route::put('entregas/{entrega}', [EntregaController::class, 'update'])->name('entregas.update');
        Route::get('entregas/{entrega}/descargar', [EntregaController::class, 'download'])
            ->name('entregas.download');
        Route::delete('entregas/{entrega}', [EntregaController::class, 'destroy'])->name('entregas.destroy');

        Route::get('informe-final', [InformeFinalController::class, 'index'])->name('informe-final.index');
        Route::post('informe-final', [InformeFinalController::class, 'store'])->name('informe-final.store');
        Route::get('informe-final/download', [InformeFinalController::class, 'download'])
            ->name('informe-final.download');
    });
