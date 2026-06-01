<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CasinhaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CheckoutController;





// Quando acessar o site na raiz (/), chama a função index do HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cardapio', [CardapioController::class, 'index'])->name('site.cardapio');
Route::get('/casinha', [CasinhaController::class, 'index'])->name('site.casinha');
Route::get('/contato', [ContatoController::class, 'index'])->name('site.contato');
Route::get('/cadastro', [CadastroController::class, 'index'])->name('site.cadastro');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('site.checkout');