<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonasController;

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

Route::prefix('personas')->group(function() {
    Route::put('/crear', [PersonasController::class, 'crear']);
    Route::put('/borrar', [PersonasController::class, 'borrar']);
    Route::put('/modificar', [PersonasController::class, 'modificar']);
    Route::put('/listar', [PersonasController::class, 'listar']);
    Route::put('/ver', [PersonasController::class, 'ver']);
});