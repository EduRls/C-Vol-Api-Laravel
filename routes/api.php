<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\MTurbinaController;
use App\Http\Controllers\InformacionUsuariosController;
use App\Http\Controllers\PipaController;
use App\Http\Controllers\RegistroLlenadoAlmacenController;
use App\Http\Controllers\ReporteVolumetrico;
use App\Http\Controllers\RegistroEntradasSalidasPipaController;

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
    // Rutas para el medidor de turbina
    Route::controller(MTurbinaController::class)->group(function() {
        Route::get('/v1/equipo/turbina', 'index');
        Route::get('/v1/equipo/turbina/{id}', 'show');
        Route::post('/v1/equipo/turbina', 'store');
        Route::post('/v1/equipo/turbina/{id}', 'update');
        Route::delete('/v1/equipo/turbina/{id}', 'destroy');
    });

    //Ruta para la informacion del usuario
    Route::controller(InformacionUsuariosController::class)->group(function(){
        Route::get('/v1/usuario', 'index');
        Route::get('/v1/usuario/{id}', 'show');
        Route::post('/v1/usuario', 'store');
        Route::post('/v1/usuario/{id}', 'update');
        Route::delete('/v1/usuario/{id}', 'destroy');
    });

    // Ruta para la informacion de pipas
    Route::controller(PipaController::class)->group(function(){
        Route::get('/v1/pipa', 'index');
        Route::get('/v1/pipa/{id}', 'show');
        Route::post('/v1/pipa', 'store');
        Route::post('/v1/pipa/{id}', 'update');
        Route::delete('/v1/pipa/{id}', 'destroy');
    });

    //Registro llenado del almacen
    Route::controller(RegistroLlenadoAlmacenController::class)->group(function(){
        Route::get('/v1/almacen/registro', 'index');
        Route::get('/v1/almacen/registro/{id}', 'show');
        Route::post('/v1/almacen/registro', 'store');
        Route::post('/v1/almacen/registro/{id}', 'update');
        Route::delete('/v1/almacen/registro/{id}', 'destroy'); 
    });

    //Registro para el reporte volumetrico
    Route::controller(ReporteVolumetrico::class)->group(function(){
        Route::get('/v1/reporte/volumetrico', 'index');
        Route::get('/v1/reporte/volumetrico/{id}', 'show');
        Route::post('/v1/reporte/volumetrico', 'store');
        Route::post('/v1/reporte/volumetrico/{id}', 'update');
        Route::delete('/v1/reporte/volumetrico/{id}', 'destroy');
    });

    //Registro para entradas y salidas
    Route::controller(RegistroEntradasSalidasPipaController::class)->group(function(){
        Route::get('/v1/entrada-salida-pipa/registro', 'index');
        Route::get('/v1/entrada-salida-pipa/registro/{id}', 'show');
        Route::post('/v1/entrada-salida-pipa/registro', 'store');
        Route::post('/v1/entrada-salida-pipa/registro/{id}', 'update');
        Route::delete('/v1/entrada-salida-pipa/registro/{id}', 'destroy'); 
    });
});
