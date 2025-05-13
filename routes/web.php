<?php

use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');

    Route::middleware(['verified'])->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
        Route::get('cars/{car}', [CarController::class, 'show'])->name('cars.show');
    });

    Route::prefix('admin')->group(function () {
        Route::view('/asd', 'livewire.car-form')->name('admin.dashboard');
        Route::get('/cars', [AdminCarController::class, 'index'])->name('livewire.carForm');
    });
});

require __DIR__ . '/auth.php';
