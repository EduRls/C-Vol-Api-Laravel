<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\MTurbinaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas publicas para acceder o registrar una cuenta
Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/local/auth/register', 'register');
    Route::post('/local/auth/login', 'login');
});

// Protected routes of product and logout
Route::middleware('auth:sanctum')->group( function () {
    Route::post('/local/auth/logout', [LoginRegisterController::class, 'logout']);

    // Rutas en las que se realiozará todas las operaciones siempre y cuenado el usuario este logueado
    Route::controller(MTurbinaController::class)->group(function() {
        Route::get('/v1/equipo/turbina', 'index');
        Route::get('/v1/equipo/turbina/{id}', 'show');
        Route::post('/v1/equipo/turbina', 'store');
        Route::post('/v1/equipo/turbina/{id}', 'update');
        Route::delete('/v1/equipo/turbina/{id}', 'destroy');
    });
});
