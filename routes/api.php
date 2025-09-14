<?php

use App\Http\Controllers\Api\ElevatorController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

Route::get('elevators/maacid', [ElevatorController::class, 'maacid']);
Route::post('elevators/notification', [ElevatorController::class, 'notification']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [LoginController::class, 'getUser']);
});


