<?php

use App\Http\Controllers\Web\ElevatorController;
use App\Http\Controllers\Web\UserController;
use App\Models\Elevator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('elevators', ElevatorController::class);
// });