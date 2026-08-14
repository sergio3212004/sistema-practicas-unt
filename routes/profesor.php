<?php

use App\Http\Controllers\Profesor\ActividadesController;
use App\Http\Controllers\Profesor\AulaController;
use App\Http\Controllers\Profesor\CronogramaController;
use App\Http\Controllers\Profesor\EntregasController;
use App\Http\Controllers\Profesor\FichaRegistroController;
use App\Http\Controllers\Profesor\FormatoDoceController;
use App\Http\Controllers\Profesor\FormatoOnceController;
use App\Http\Controllers\Profesor\InformeFinalController;
use App\Http\Controllers\Profesor\MonitoreoPracticaController;
use App\Http\Controllers\Profesor\SemanaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:profesor'])
    ->prefix('profesor')
    ->name('profesor.')
    ->group(function (): void {
        Route::get('aula/{aula}', [AulaController::class, 'show'])->name('aula.index');
        Route::get('aulas/{aula}', [AulaController::class, 'show'])->name('aulas.show');

        Route::get('semanas', [SemanaController::class, 'index'])->name('semanas.index');
        Route::get('aulas/{aula}/semanas/create', [SemanaController::class, 'create'])->name('semanas.create');
        Route::post('aulas/{aula}/semanas', [SemanaController::class, 'store'])->name('semanas.store');
        Route::get('semanas/{semana}', [SemanaController::class, 'show'])->name('semanas.show');
        Route::get('semanas/{semana}/edit', [SemanaController::class, 'edit'])->name('semanas.edit');
        Route::put('semanas/{semana}', [SemanaController::class, 'update'])->name('semanas.update');
        Route::delete('semanas/{semana}', [SemanaController::class, 'destroy'])->name('semanas.destroy');

        Route::get('aulas/{aula}/actividades/create', [ActividadesController::class, 'create'])
            ->name('actividades.create');
        Route::post('aulas/{aula}/actividades', [ActividadesController::class, 'store'])
            ->name('actividades.store');
        Route::get('actividades/{actividad}', [ActividadesController::class, 'show'])->name('actividades.show');
        Route::delete('actividades/{actividad}/destroy', [ActividadesController::class, 'destroy'])
            ->name('actividades.destroy');
        Route::patch('entregas/{entrega}/calificar', [EntregasController::class, 'calificar'])
            ->name('entregas.calificar');

        Route::get('fichas/{fichaRegistro}', [FichaRegistroController::class, 'show'])->name('fichas.show');
        Route::patch('fichas/{fichaRegistro}/aceptar', [FichaRegistroController::class, 'aceptar'])
            ->name('fichas.aceptar');
        Route::patch('fichas/{fichaRegistro}/rechazar', [FichaRegistroController::class, 'rechazar'])
            ->name('fichas.rechazar');

        Route::get('cronogramas/{cronograma}', [CronogramaController::class, 'show'])
            ->name('cronogramas.show');
        Route::post('cronogramas/{cronograma}/firmar', [CronogramaController::class, 'firmar'])
            ->name('cronogramas.firmar');
        Route::patch('cronogramas/{cronograma}/calificar', [CronogramaController::class, 'calificar'])
            ->name('cronogramas.calificar');

        Route::get('monitoreos-practicas/alumno/{alumno}', [MonitoreoPracticaController::class, 'index'])
            ->name('monitoreos-practicas.index');
        Route::get('monitoreos-practicas/{monitoreoPractica}', [MonitoreoPracticaController::class, 'show'])
            ->name('monitoreos-practicas.show');

        Route::get('informes-finales', [InformeFinalController::class, 'index'])->name('informes-finales.index');
        Route::get('informes-finales/{informe}/download', [InformeFinalController::class, 'download'])
            ->name('informes-finales.download');

        Route::get('formato-once', [FormatoOnceController::class, 'index'])->name('formato-once.index');
        Route::get('formato-once/create/{aula}', [FormatoOnceController::class, 'create'])->name('formato-once.create');
        Route::post('formato-once/store/{aula}', [FormatoOnceController::class, 'store'])->name('formato-once.store');
        Route::get('formato-once/{formatoOnce}', [FormatoOnceController::class, 'show'])->name('formato-once.show');
        Route::get('formato-once/{formatoOnce}/edit', [FormatoOnceController::class, 'edit'])
            ->name('formato-once.edit');
        Route::delete('formato-once/{formatoOnce}', [FormatoOnceController::class, 'destroy'])
            ->name('formato-once.destroy');
        Route::get('aula/{aula}/list', [FormatoOnceController::class, 'list'])->name('formato-once.list');
        Route::put('formato-once/list/{formatoOnce}', [FormatoOnceController::class, 'update'])
            ->name('formato-once.update');
        Route::get('formato-once/{formatoOnce}/pdf', [FormatoOnceController::class, 'generatePdf'])
            ->name('formato-once.pdf');

        Route::get('formato-doce', [FormatoDoceController::class, 'index'])->name('formato-doce.index');
        Route::get('formato-doce/create', [FormatoDoceController::class, 'create'])->name('formato-doce.create');
        Route::post('formato-doce/store', [FormatoDoceController::class, 'store'])->name('formato-doce.store');
        Route::get('formato-doce/{formatoDoce}', [FormatoDoceController::class, 'show'])->name('formato-doce.show');
        Route::get('formato-doce/aula/{aula}/alumnos', [FormatoDoceController::class, 'getAlumnos'])
            ->name('formato-doce.alumnos');
        Route::delete('formato-doce/{formatoDoce}', [FormatoDoceController::class, 'destroy'])
            ->name('formato-doce.destroy');
    });
