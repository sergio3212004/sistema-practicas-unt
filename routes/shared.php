<?php

use App\Http\Controllers\Alumno\FirmaCronogramaController;
use App\Http\Controllers\Alumno\FirmaTokenController;
use App\Http\Controllers\Empresa\EmpresaRegisterController;
use App\Http\Controllers\GoogleDriveController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('empresa')->name('empresa.')->group(function (): void {
    Route::get('register', [EmpresaRegisterController::class, 'create'])->name('register.form');
    Route::post('register', [EmpresaRegisterController::class, 'register'])->name('register');
    Route::get('verify', [EmpresaRegisterController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('verify', [EmpresaRegisterController::class, 'verifyCode'])->name('verify.code');
});

Route::get('firmas/ficha-registro/{token}', [FirmaTokenController::class, 'show'])
    ->name('firmas.ficha-registro.show');
Route::post('firmar/{token}', [FirmaTokenController::class, 'store'])
    ->name('firmas.ficha-registro.store');

Route::get('firmas/cronograma/jefe/{token}', [FirmaCronogramaController::class, 'formJefe'])
    ->name('firma.cronograma.jefe');
Route::post('firmas/cronograma/jefe/{token}', [FirmaCronogramaController::class, 'guardarFirmaJefe'])
    ->name('firma.cronograma.jefe.guardar');

Route::middleware('auth')->group(function (): void {
    Route::get('google/auth', [GoogleDriveController::class, 'redirectToGoogle'])->name('google.auth');
    Route::get('google/callback', [GoogleDriveController::class, 'handleGoogleCallback'])->name('google.callback');
});
