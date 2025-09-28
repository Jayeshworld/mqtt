<?php

use App\Http\Controllers\Web\ElevatorController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\UserController;
use App\Models\Elevator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/migrate', function () {
    Artisan::call('migrate');
    return "Migrated";
});

Route::get('/privacy', function () {
    return view('privacy');
});
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('elevators', ElevatorController::class);
});
