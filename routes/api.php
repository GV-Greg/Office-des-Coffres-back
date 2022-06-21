<?php

use App\Http\Controllers\API\Anim\DecodeActivityController;
use App\Http\Controllers\API\Anim\RaceChicksActivityController;
use App\Http\Controllers\API\Anim\RewardsGridActivityController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/* public access to animation activities */
Route::prefix('anim-public')->group( function() {
    Route::prefix('grid-rewards')->group( function() {
        Route::get('/show/{name}', [RewardsGridActivityController::class, 'activity'])->name('anim.public.grid-rewards.activity');
    });
    Route::prefix('decode')->group( function() {
        Route::get('/show/{name}', [DecodeActivityController::class, 'activity'])->name('anim.public.decode.activity');
    });
    Route::prefix('race-chicks')->group( function() {
        Route::get('/show/{name}', [RaceChicksActivityController::class, 'activity'])->name('anim.public.race-chicks.activity');
    });
});

Route::middleware(['auth:api'])->group(function(){
    Route::get('check-auth/{username}', [AuthController::class, 'check']);
    Route::post('logout', [AuthController::class, 'logout']);


});
