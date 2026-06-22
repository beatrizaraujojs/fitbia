<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido Manual - Fit Bia</title>
    
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        .form-card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #374151; font-weight: 600; font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #2b4231; }
        .btn-salvar { background-color: #2b4231; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-salvar:hover { background-color: #1e2f23; }
        .item-produto { display: flex; gap: 15px; align-items: center; margin-bottom: 10px; background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .btn-add-produto { background-color: #f3f4f6; color: #4b5563; padding: 10px 15px; border: 1px dashed #d1d5db; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; text-align: center; margin-bottom: 20px; transition: 0.3s; }
        .btn-add-produto:hover { background-color: #e5e7eb; }
    </style>
</head>
<body>

    <div class="dash-container">
        
        {{-- MENU LATERAL --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu"><i class="ph ph-x"></i></button>
            </div>
             <nav class="sidebar-nav">
                <a href="#"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="{{ route('admin.grupoadicional.index') }}"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                <a href="{{ route('admin.pedidos') }}" class="active"><i class="ph ph-receipt"></i> Pedidos</a>
                <a href="{{ route('admin.usuarios.index') }}"><i class="ph ph-users"></i> Usuários</a>
            </nav>
            <div class="sidebar-footer" style="padding: 20px;">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display: flex; align-items: center; justify-content: center; gap: 8px; background-color: hsla(0, 73%, 33%, 1.00); color: #e4c2c2ff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    <i class="ph ph-sign-out" style="font-size: 20px;"></i> Sair do Sistema
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile"><i class="ph ph-list"></i></button>
                    <h1>Lançar Novo Pedido</h1>
                </div>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <a href="{{ route('admin.pedidos') }}" style="color: #4b5563; text-decoration: none; font-weight: 600; font-size: 14px; background: #f3f4f6; padding: 8px 15px; border-radius: 8px;">
                        <i class="ph ph-arrow-left" style="font-size: 18px;"></i> Voltar
                    </a>
                </div>
            </header>

            <section class="content-area">
                
                <div class="form-card">
                    @if(session('error'))
                        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.pedidos.store') }}" method="POST">
                        @csrf

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select name="id_cliente_fk" required>
                                    <option value="">Selecione o Cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id_cliente }}">{{ $cliente->nome_cliente }} ({{ $cliente->whatsapp_cliente }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select name="forma_pagamento" required>
                                    <option value="pix">PIX</option>
                                    <option value="cartao">Cartão</option>
                                    <option value="dinheiro">Dinheiro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status Inicial</label>
                            <select name="status_pedido" required>
                                <option value="PENDENTE">Pendente</option>
                                <option value="PREPARANDO">Preparando</option>
                                <option value="ENTREGUE">Entregue (Já finalizado)</option>
                            </select>
                        </div>

                        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
                        <h3 style="margin-bottom: 15px; color: #2b4231;">Produtos do Pedido</h3>

                        <div id="lista-produtos">
                            {{-- Linha de Produto Padrão --}}
                            <div class="item-produto">
                                <div style="flex: 3;">
                                    <label style="font-size: 12px;">Produto</label>
                                    <select name="produtos[]" required style="padding: 8px;">
                                        <option value="">Escolha uma marmita...</option>
                                        @foreach($produtos as $produto)
                                            <option value="{{ $produto->id_produto }}">{{ $produto->nome_produto }} - R$ {{ number_format($produto->preco_base_produto, 2, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="flex: 1;">
                                    <label style="font-size: 12px;">Quantidade</label>
                                    <input type="number" name="quantidades[]" min="1" value="1" required style="padding: 8px;">
                                </div>
                            </div>
                        </div>

                        <div class="btn-add-produto" onclick="adicionarProduto()">
                            + Adicionar outro produto
                        </div>

                        <div class="form-group">
                            <label>Observações (Opcional)</label>
                            <textarea name="observacao" rows="3" placeholder="Anotações internas ou recado do cliente..."></textarea>
                        </div>

                        <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                            <button type="submit" class="btn-salvar">Salvar Pedido</button>
                        </div>
                    </form>
                </div>

            </section>
        </main>
    </div>

    <script>
        // Função para duplicar a caixinha de produtos e permitir adicionar vários itens
        function adicionarProduto() {
            const lista = document.getElementById('lista-produtos');
            const primeiraLinha = lista.children[0];
            const novaLinha = primeiraLinha.cloneNode(true);
            
            // Limpa os valores da linha clonada
            novaLinha.querySelector('select').value = "";
            novaLinha.querySelector('input').value = "1";
            
            lista.appendChild(novaLinha);
        }
    </script>
</body>
</html>