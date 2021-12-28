<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function(){

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*  Gestion des permissions  */
    Route::prefix('permissions')->group( function() {
        Route::get('', [PermissionController::class, 'index'])->name('permissions.list');
        Route::get('/add-permission', [PermissionController::class, 'create'])->name('permission.create');
        Route::post('/add-permission', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('/edit-permission/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('/edit-permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
        Route::delete('/delete-permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    });

    /*  Gestion des rôles  */
    Route::prefix('roles')->group( function() {
        Route::get('', [RoleController::class, 'index'])->name('roles.list');
        Route::get('/show-role/{id}', [RoleController::class, 'show'])->name('role.show');
        Route::get('/add-role', [RoleController::class, 'create'])->name('role.create');
        Route::post('/add-role', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit-role/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/edit-role/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete-role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    /*  Gestion des joueurs  */
    Route::prefix('players')->group( function() {
        Route::get('', [UserController::class, 'index'])->name('players.list');
        Route::get('/show-player/{id}', [UserController::class, 'show'])->name('player.show');
        Route::get('/add-player', [UserController::class, 'create'])->name('player.create');
        Route::post('/add-player', [UserController::class, 'store'])->name('player.store');
        Route::get('/edit-player/{id}', [UserController::class, 'edit'])->name('player.edit');
        Route::post('/edit-player/{id}', [UserController::class, 'update'])->name('player.update');
        Route::delete('/delete-player/{id}', [UserController::class, 'destroy'])->name('player.destroy');
        Route::get('/change-status/{id}', [UserController::class, 'changeStatus'])->name('player.change.status');
    });
});

require __DIR__.'/auth.php';
