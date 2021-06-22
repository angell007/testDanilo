<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ViajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    //Clientes
    Route::resource('/clientes', ClienteController::class, ['except' => 'update']);
    Route::patch('/clientes/update', [ClienteController::class, 'update'])->name('clientes.update');
    Route::get('/clientes/servicios/{cliente}', 'ClienteController@servicios');


    Route::resource('/viajes', ViajeController::class, ['except' => 'update']);
    Route::patch('/viajes/update', [ViajeController::class, 'update'])->name('viajes.update');
});
