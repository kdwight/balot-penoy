<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');

    Route::middleware(['is_admin'])->group(function () {
        Route::prefix('users')->name('users.')->middleware(['is_admin'])->group(function () {
            Route::inertia('/', 'Users/Index')->name('index');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::put('update', [UserController::class, 'update'])->name('update');
            Route::patch('{user}/status', [UserController::class, 'status']);
            Route::get('list', [UserController::class, 'list'])->name('list');
        });
    });
});

require __DIR__ . '/auth.php';
