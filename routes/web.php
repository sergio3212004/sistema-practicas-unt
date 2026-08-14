<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::middleware('auth')->group(function (): void {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');
});

require __DIR__.'/shared.php';
require __DIR__.'/admin.php';
require __DIR__.'/profesor.php';
require __DIR__.'/empresa.php';
require __DIR__.'/alumno.php';
require __DIR__.'/auth.php';
