<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProdutoController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\AuthController; // <--- Importa o AuthController

Route::prefix('v1')->group(function () {

    // Status da API
    Route::get('/status', [StatusController::class, 'index']);

    // Categorias
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}/produtos', [CategoriaController::class, 'produtos']);

    // Produtos
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::get('/produtos/{slug}', [ProdutoController::class, 'show']);

    // LOGIN - Rota pública para autenticar e gerar o token Sanctum
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Rota protegida pelo Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/cliente', [ClienteController::class, 'show']);
    });

});