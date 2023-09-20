<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => inertia('Dashboard', [
        'todos' => auth()->user()->todos
    ]))->name('dashboard');

    Route::prefix('todos')->name('todos.')->middleware(['todos_access'])->group(function () {
        Route::get('/', [TodoController::class, 'index'])->name('index');
        Route::post('store', [TodoController::class, 'store'])->name('store');
        Route::patch('{item}/complete', [TodoController::class, 'toggleStatus'])->name('status');
        Route::post('{todo}/store-item', [TodoController::class, 'storeItem'])->name('store-item');
        Route::put('{item}/update-item', [TodoController::class, 'updateItem'])->name('update-item');
        Route::delete('{item}/delete-item', [TodoController::class, 'destroyItem'])->name('delete-item');
    });

    Route::middleware(['is_admin'])->group(function () {
        Route::prefix('users')->name('users.')->middleware(['is_admin'])->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('store', [UserController::class, 'store'])->name('store');
            Route::put('{user}/update', [UserController::class, 'update'])->name('update');
            Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('destroy');
            Route::get('list', [UserController::class, 'list'])->name('list');
        });
    });
});

require __DIR__ . '/auth.php';
