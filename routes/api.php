<?php

use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Support\Facades\Route;

// Protegidas con sesión (el dashboard las consume con fetch + token CSRF)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index']);
    Route::post('/productos', [ProductoController::class, 'store']);
    Route::put('/productos/{producto}', [ProductoController::class, 'update']);
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);

    Route::get('/pedidos', [PedidoController::class, 'index']);
    Route::post('/pedidos', [PedidoController::class, 'store']);
});
