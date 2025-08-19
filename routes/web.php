<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InquilinoController;
use Illuminate\Support\Facades\Route;

// Ruta pública
Route::get('/', fn() => view('welcome'));

// Dashboard (autenticado)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/home', 'dashboard')->name('home'); // opcional, si querés alias

    // CRUD Inquilinos
    Route::resource('inquilinos', InquilinoController::class);

    // Secciones placeholder
    Route::view('/propiedades', 'propiedades.index')->name('propiedades.index');
    Route::view('/contratos', 'contratos.index')->name('contratos.index');
    Route::view('/pagos', 'pagos.index')->name('pagos.index');
    Route::view('/inquilinos', 'inquilinos.index')->name('inquilinos.index');

    // Perfil
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

// Autenticación
require __DIR__.'/auth.php';
