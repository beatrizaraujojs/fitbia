<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\EnderecoController;
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\PedidoController;

Route::prefix('v1')->group(function () {
    
    // Status da API
    Route::get('/status', [StatusController::class, 'index']);

    // Categorias
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}/produtos', [CategoriaController::class, 'produtos']);

    // Clientes (Autenticação / Perfil)
    Route::post('/clientes/cadastro', [ClienteController::class, 'store']);
    Route::post('/clientes/login', [ClienteController::class, 'login']);
    Route::get('/clientes/{id}', [ClienteController::class, 'show']);
    Route::put('/clientes/{id}', [ClienteController::class, 'update']);

    // Endereços do Cliente
    Route::get('/clientes/{cliente_id}/enderecos', [EnderecoController::class, 'index']);
    Route::post('/clientes/{cliente_id}/enderecos', [EnderecoController::class, 'store']);
    Route::delete('/enderecos/{id}', [EnderecoController::class, 'destroy']);

    // Favoritos do Cliente
    Route::get('/clientes/{cliente_id}/favoritos', [FavoritoController::class, 'index']);
    Route::post('/favoritos', [FavoritoController::class, 'toggle']);

    // Pedidos
    Route::post('/pedidos', [PedidoController::class, 'store']);
    Route::get('/clientes/{cliente_id}/pedidos', [PedidoController::class, 'index']);
    Route::get('/pedidos/{id}', [PedidoController::class, 'show']);
});