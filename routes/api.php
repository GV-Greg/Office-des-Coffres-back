<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function(){
    Route::get('check-auth/{username}', [AuthController::class, 'check']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});
