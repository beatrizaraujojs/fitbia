<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProdutoController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\AuthController; // <--- Importa o AuthController
use App\Http\Controllers\Api\V1\EnderecoController;

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
        Route::put('/cliente', [ClienteController::class, 'update']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/favoritos', [FavoritoController::class, 'index']);
        Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle']);


        Route::get('/enderecos', [EnderecoController::class, 'index']);
        Route::post('/enderecos', [EnderecoController::class, 'store']);
        Route::put('/enderecos/{id}', [EnderecoController::class, 'update']);
        Route::delete('/enderecos/{id}', [EnderecoController::class, 'destroy']);
    });

    // Documentação da API (Acessível via navegador)
    Route::get('/documentacao', function () {
        return view('api.documentacao');
    });

    // Documentação da API (Acessível via navegador)
    Route::get('/documentacao', function () {
        return view('api.documentacao');
    });
});
