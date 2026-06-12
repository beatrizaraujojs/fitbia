
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

use App\Http\Controllers\Admin\ProdutoController;

use App\Http\Controllers\Admin\GrupoController;

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



  Route::get('/produto', [ProdutoController::class, 'index'])->name('produto.index');
  Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');


  // Rota para editar o produto
  Route::put('/produto/{id}', [\App\Http\Controllers\Admin\ProdutoController::class, 'update'])->name('produto.update');

  Route::delete('/produto/{id}', [\App\Http\Controllers\Admin\ProdutoController::class, 'destroy'])->name('produto.destroy');

  Route::delete('/categoria/{id}', [\App\Http\Controllers\Admin\CategoriaController::class, 'destroy'])->name('categoria.destroy');


  // A rota deve ser do tipo PUT ou PATCH para atualizações
  // Deixe apenas /categoria e categoria.update, pois o grupo já cuida do "admin"
  Route::put('/categoria/{id}', [\App\Http\Controllers\Admin\CategoriaController::class, 'update'])->name('categoria.update');

  // Rota para a tela de gerenciar os grupos adicionais de um produto específico
  Route::get('/produto/{id}/adicionais', [\App\Http\Controllers\Admin\ProdutoController::class, 'adicionais'])->name('produto.adicionais');


  // Rota para salvar um novo grupo adicional
  Route::post('/grupo-adicional', [\App\Http\Controllers\Admin\GrupoAdicionalController::class, 'store'])->name('grupo.store');
  
 // Ajuste o caminho para o seu Controller

// Route::post('/admin/grupo/store', [GrupoController::class, 'store'])->name('admin.grupo.store');


// Rota para salvar um novo grupo adicional
Route::post('/grupo-adicional', [\App\Http\Controllers\Admin\GrupoAdicionalController::class, 'store'])->name('grupo.store');
  
  // Route::resource('grupos-adicionais', GrupoAdicionalController::class);


  // // Pedidos geralmente não tem "create" no admin (vem do cliente), então podemos limitar:
  // Route::resource('pedidos', PedidoController::class)->except(['create', 'store']);
});
