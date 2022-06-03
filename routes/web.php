<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Modules\Anim\RewardsGridController;
use App\Http\Controllers\Modules\Anim\RewardsListController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function(){

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    /* Page de test pour page non autorisée */
    Route::get('test', [DashboardController::class, 'test'])->name('test');

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
        Route::get('/add-role/{id}', [UserController::class, 'addRole'])->name('player.role.add');
        Route::post('/store-role/{id}', [UserController::class, 'storeRole'])->name('player.role.store');
    });

    /* Animation */
        /* Gestion des grilles de lots */
        Route::prefix('anim')->group( function() {
            Route::prefix('grid-rewards')->group( function () {
               Route::get('', [RewardsGridController::class, 'index'])->name('anim.grids.rewards.list');
               Route::get('/add-grid', [RewardsGridController::class, 'create'])->name('anim.grid.rewards.create');
               Route::post('/add-grid', [RewardsGridController::class, 'store'])->name('anim.grid.rewards.store');
               Route::get('/show-grid/{id}', [RewardsGridController::class, 'show'])->name('anim.grid.rewards.show');
               Route::get('/edit-grid/{id}', [RewardsGridController::class, 'edit'])->name('anim.grid.rewards.edit');
               Route::post('/edit-grid/{id}', [RewardsGridController::class, 'update'])->name('anim.grid.rewards.update');
                Route::get('/confirm/{id}', [RewardsGridController::class, 'confirm'])->name('anim.grid.rewards.confirm');
                Route::delete('/delete-grid/{id}', [RewardsGridController::class, 'destroy'])->name('anim.grid.rewards.destroy');
               /* Gestion des lots */
               Route::post('/add-reward', [RewardsListController::class, 'add'])->name('anim.grid.rewards.add');
               Route::get('/draw/{id}', [RewardsListController::class, 'draw'])->name('anim.grid.rewards.draw');
               Route::delete('/delete-group-rewards/{id}/{name}', [RewardsListController::class, 'destroy'])->name('anim.grid.rewards.group.destroy');
               Route::post('/give-award/{id}', [RewardsListController::class, 'give'])->name('anim.grid.rewards.give');
            });
        });

});

require __DIR__.'/auth.php';
