<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function(){
    Route::post('details', [AuthController::class, 'details']);
    Route::post('logout', [AuthController::class, 'logout']);
    /*  Gestion des joueurs  */
    Route::prefix('players')->group( function() {
        Route::get('', [UserController::class, 'index']);
        Route::get('/show-player/{id}', [UserController::class, 'show']);
        Route::post('/add-player', [UserController::class, 'store']);
        Route::get('/edit-player/{id}', [UserController::class, 'edit']);
        Route::post('/edit-player/{id}', [UserController::class, 'update']);
        Route::delete('/delete-player/{id}', [UserController::class, 'destroy']);
    });
});

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});
