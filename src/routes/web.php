
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CasinhaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CheckoutController;


// Importe os Controllers que vamos usar (você vai criá-los no próximo passo)
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;

// 1. Raiz do site abre na Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Página do Cardápio
Route::get('/cardapio', [CardapioController::class, 'index'])->name('site.cardapio');

// 3. Demais páginas
Route::get('/casinha', [CasinhaController::class, 'index'])->name('site.casinha');
Route::get('/contato', [ContatoController::class, 'index'])->name('site.contato');
Route::get('/cadastro', [CadastroController::class, 'index'])->name('site.cadastro');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('site.checkout');
Route::post('/carrinho/adicionar', [CheckoutController::class, 'adicionarItem'])->name('carrinho.adicionar');
Route::post('/carrinho/adicionar', [CheckoutController::class, 'adicionarItem'])->name('carrinho.adicionar');




// === ROTAS DO PAINEL ADMIN ===
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rota principal do Dash (A tela que acabamos de fazer)
    // URL: /admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // // Rotas de CRUD (Cria automaticamente as rotas de index, create, store, edit, update, destroy)
    // // URL: /admin/categorias, /admin/categorias/create, etc.
   Route::get('/categorias', [App\Http\Controllers\Admin\CategoriaController::class, 'index'])->name('categoria.index');

     Route::post('/categorias', [CategoriaController::class, 'store'])->name('categoria.store');
    // Route::resource('produtos', ProdutoController::class);
    // Route::resource('grupos-adicionais', GrupoAdicionalController::class);
    
    // // Pedidos geralmente não tem "create" no admin (vem do cliente), então podemos limitar:
    // Route::resource('pedidos', PedidoController::class)->except(['create', 'store']);
});