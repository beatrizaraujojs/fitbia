<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CasinhaController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\GrupoAdicionalController;
use App\Http\Controllers\Admin\ProdutoController;
use App\Http\Controllers\Admin\PedidoController;


// 1. Raiz do site abre na Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Página do Cardápio
Route::get('/cardapio', [CardapioController::class, 'index'])->name('site.cardapio');

// 3. Demais páginas
Route::get('/casinha', [CasinhaController::class, 'index'])->name('site.casinha');
Route::get('/contato', [ContatoController::class, 'index'])->name('site.contato');
Route::get('/cadastro', [CadastroController::class, 'index'])->name('site.cadastro');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('site.checkout');



// Rotas de Visualização (Telas)
Route::get('/login', [ClienteController::class, 'mostrarLogin'])->name('site.login');
Route::get('/cadastro', [ClienteController::class, 'mostrarCadastro'])->name('site.cadastro');

// Rotas de Ação (Envio dos Formulários)
Route::post('/cadastro/salvar', [ClienteController::class, 'registrar'])->name('cliente.registrar');
Route::post('/login/entrar', [ClienteController::class, 'autenticar'])->name('cliente.autenticar');
Route::post('/logout', [ClienteController::class, 'logout'])->name('cliente.logout');


// Rota para a página de pedidos
Route::get('/checkout/pedidos', [CheckoutController::class, 'pedidos'])->name('site.checkout.pedidos');

// A NOVA ROTA PARA AS ETAPAS:
Route::get('/checkout/layout', [CheckoutController::class, 'layout'])->name('site.checkout.layout');

// === ROTAS DO CARRINHO ===
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('site.carrinho');
Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');

// === ROTAS DO CARRINHO ===
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('site.carrinho');
Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::post('/carrinho/atualizar/{id}', [CarrinhoController::class, 'atualizar'])->name('carrinho.atualizar'); // <- NOVA LINHA
Route::delete('/carrinho/remover/{id}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/checkout/finalizar', [App\Http\Controllers\CarrinhoController::class, 'finalizarPedido'])->name('pedido.salvar');

Route::post('/painel/endereco', [App\Http\Controllers\ClienteController::class, 'salvarEndereco'])->name('cliente.endereco.salvar');


// Rota do Painel (Só acessa quem estiver logado)
Route::middleware(['auth'])->group(function () {
    Route::get('/painel', function () {
        return view('site.painel.index'); // O caminho do seu arquivo blade
    })->name('site.painel');
});


// Rota do Painel (Só acessa quem estiver logado)
Route::middleware(['auth'])->group(function () {

    // A página do painel
    Route::get('/painel', function () {
        return view('site.painel.index');
    })->name('site.painel');

    // A rota que processa o salvamento do perfil
    Route::post('/painel/atualizar', [App\Http\Controllers\ClienteController::class, 'atualizarPerfil'])->name('cliente.atualizar');
});




// === ROTAS DO PAINEL ADMIN (SEM O MIDDLEWARE WEB REPETIDO) ===
Route::prefix('admin')->name('admin.')->group(function () {

    // Rota principal do Dash
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas de Categorias
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categoria.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::put('/categoria/{id}', [CategoriaController::class, 'update'])->name('categoria.update');
    Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');

    // Rotas de Produtos
    Route::get('/produto', [ProdutoController::class, 'index'])->name('produto.index');
    Route::post('/produto', [ProdutoController::class, 'store'])->name('produto.store');
    Route::put('/produto/{id}', [ProdutoController::class, 'update'])->name('produto.update');
    Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])->name('produto.destroy');
    Route::get('/produto/{id}/adicionais', [ProdutoController::class, 'adicionais'])->name('produto.adicionais');

    // Rotas de Grupos Adicionais
    Route::get('/grupos-adicionais', [GrupoAdicionalController::class, 'index'])->name('grupoadicional.index');
    Route::post('/grupos-adicionais', [GrupoAdicionalController::class, 'store'])->name('grupo.store');
    Route::put('/grupos-adicionais/{id}', [GrupoAdicionalController::class, 'update'])->name('grupo.update');
    Route::delete('/grupos-adicionais/{id}', [GrupoAdicionalController::class, 'destroy'])->name('grupo.destroy');


// Rotas de Gestão de Pedidos (Painel Admin)
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos');
    Route::post('/pedidos/{id}/status', [PedidoController::class, 'atualizarStatus'])->name('pedidos.status');

    // NOVA ROTA: Detalhes do Pedido
    Route::get('/pedidos/{id}/detalhes', [PedidoController::class, 'detalhes'])->name('pedidos.detalhes');
});
