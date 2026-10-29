<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProdutoController;
use App\Http\Controllers\Api\V1\ClienteController;
use App\Http\Controllers\Api\V1\FavoritoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EnderecoController;
use App\Http\Controllers\Api\V1\PasswordRecoveryController;
use App\Http\Controllers\Api\V1\CupomController;
use App\Http\Controllers\Api\V1\PedidoController;

Route::prefix('v1')->group(function () {

    // Rotas públicas
    Route::get('/status', [StatusController::class, 'index']);

    // Categorias
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}/produtos', [CategoriaController::class, 'produtos']);

    // Produtos
    Route::get('/produtos', [ProdutoController::class, 'index']);
    Route::get('/produtos/{slug}', [ProdutoController::class, 'show']);

    // Autenticação
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    // Cupons
    Route::post('/cupons/validar', [CupomController::class, 'validarCupom']);

    // Recuperação de senha
    Route::post('/senha/solicitar', [PasswordRecoveryController::class, 'solicitar']);
    Route::post('/senha/validar', [PasswordRecoveryController::class, 'validar']);
    Route::post('/senha/redefinir', [PasswordRecoveryController::class, 'redefinir']);

    // Rotas protegidas pelo Sanctum
    Route::middleware('auth:sanctum')->group(function () {

        // Cliente
        Route::get('/cliente', [ClienteController::class, 'show']);
        Route::put('/cliente', [ClienteController::class, 'update']);
        Route::put('/cliente/senha', [ClienteController::class, 'updateSenha']);

        // Endereços
        Route::get('/enderecos', [EnderecoController::class, 'index']);
        Route::post('/enderecos', [EnderecoController::class, 'store']);
        Route::put('/enderecos/{id}', [EnderecoController::class, 'update']);
        Route::delete('/enderecos/{id}', [EnderecoController::class, 'destroy']);

        // Favoritos
        Route::get('/favoritos', [FavoritoController::class, 'index']);
        Route::post('/favoritos/toggle', [FavoritoController::class, 'toggle']);

        // Pedidos
        Route::get('/pedidos', [PedidoController::class, 'index']);
        Route::post('/pedidos', [PedidoController::class, 'store']);
        
    });

    // Documentação da API
    Route::get('/documentacao', function () {
        return view('api.documentacao');
    });
});
