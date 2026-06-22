<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido - Painel Admin</title>
    
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        .detalhes-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .card-detalhe { background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 25px; }
        .card-detalhe h3 { color: #2b4231; margin-bottom: 15px; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .card-detalhe p { margin-bottom: 8px; color: #444; font-size: 15px; }
        .card-detalhe strong { color: #222; }
        
        .lista-itens { list-style: none; padding: 0; margin: 0; }
        .item-pedido { padding: 15px 0; border-bottom: 1px dashed #ccc; }
        .item-pedido:last-child { border-bottom: none; }
        .item-titulo { font-weight: bold; font-size: 16px; color: #333; display: flex; justify-content: space-between;}
        .item-adicional { color: #666; font-size: 14px; margin-left: 15px; margin-top: 5px; }
        
        .btn-voltar { display: inline-flex; align-items: center; gap: 5px; background: #6c757d; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-weight: bold; margin-bottom: 20px; }
        .btn-voltar:hover { background: #5a6268; }
        
        /* Uma coluna no celular */
        @media(max-width: 768px) { .detalhes-grid { grid-template-columns: 1fr; } }
    </style>
</head>

<body>
    <div class="dash-container">
     

        {{-- MENU LATERAL --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h2>Fit Bia</h2>
                <button id="btn-fechar-menu" class="btn-fechar-menu" aria-label="Fechar Menu"><i class="ph ph-x"></i></button>
            </div>
            <nav class="sidebar-nav">
                <a href="#"><i class="ph ph-squares-four"></i> Visão Geral</a>
                <a href="{{ route('admin.categoria.index') }}"><i class="ph ph-tag"></i> Categorias</a>
                <a href="{{ route('admin.produto.index') }}"><i class="ph ph-package"></i> Produtos</a>
                <a href="{{ route('admin.grupoadicional.index') }}"><i class="ph ph-plus-circle"></i> Grupos Adicionais</a>
                <a href="{{ route('admin.pedidos') }}" class="{{ request()->routeIs('admin.pedidos') ? 'active' : '' }}"><i class="ph ph-receipt"></i> Pedidos</a>
                <a href="{{ route('admin.usuarios.index') }}" class="{{ request()->routeIs('admin.usuarios.*')}}"><i class="ph ph-users"></i> Usuários</a>
            </nav>
            <div class="sidebar-footer" style="padding: 20px;">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="display: flex; align-items: center; justify-content: center; gap: 8px; background-color: hsla(0, 73%, 33%, 1.00); color: #e4c2c2ff; padding: 12px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background-color 0.3s;">
                    <i class="ph ph-sign-out" style="font-size: 20px;"></i> Sair do Sistema
                </a>

                {{-- Formulário invisível de segurança do Laravel para fazer o Logout --}}
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gestão de Pedidos</h1>
                </div>
                 {{-- LADO DIREITO: Botão do Site + Perfil --}}
                <div style="display: flex; align-items: center; gap: 20px;">
                    
                    {{-- O NOVO BOTÃO DE VOLTAR PRO SITE --}}
                    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px; color: #4b5563; text-decoration: none; font-weight: 600; font-size: 14px; background: #f3f4f6; padding: 8px 15px; border-radius: 8px; transition: background 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="ph ph-storefront" style="font-size: 18px;"></i>
                        Ver o Site
                    </a>

                    <div class="user-profile" style="margin: 0;">
                        <span>Olá, {{ auth('admin')->user()->nome_usuario }}</span>
                        <i class="ph ph-user-circle"></i>
                    </div>
                </div>
            </header>
            <section class="content-area">
                
                <a href="{{ route('admin.pedidos') }}" class="btn-voltar"><i class="ph ph-arrow-left"></i> Voltar para Lista</a>

                <div class="detalhes-grid">
                    
                    {{-- DADOS DO CLIENTE E ENTREGA --}}
                    <div>
                        <div class="card-detalhe" style="margin-bottom: 20px;">
                            <h3>👤 Dados do Cliente</h3>
                            <p><strong>Nome:</strong> {{ $pedido->cliente->nome_cliente ?? 'Não informado' }}</p>
                            <p><strong>WhatsApp:</strong> {{ $pedido->cliente->whatsapp_cliente ?? 'Não informado' }}</p>
                            <p><strong>Status do Pedido:</strong> <span style="background: #eee; padding: 2px 8px; border-radius: 4px; font-weight:bold;">{{ $pedido->status_pedido }}</span></p>
                            <p><strong>Pagamento:</strong> {{ strtoupper($pedido->forma_pagamento_pedido) }}</p>
                        </div>

                        <div class="card-detalhe">
                            <h3>📍 Endereço de Entrega</h3>
                            @if($endereco)
                                <p><strong>Rua:</strong> {{ $endereco->rua_endereco }}, Nº {{ $endereco->numero_endereco }}</p>
                                <p><strong>Bairro:</strong> {{ $endereco->bairro_endereco }}</p>
                                @if($endereco->complemento_endereco)
                                    <p><strong>Complemento:</strong> {{ $endereco->complemento_endereco }}</p>
                                @endif
                                <p><strong>Cidade:</strong> {{ $endereco->cidade_endereco }}</p>
                            @else
                                <p style="color: #888;">Retirada no local ou endereço não registrado.</p>
                            @endif
                            
                            @if($pedido->observacoes_pedido)
                                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                                <p><strong>📌 Observação do Cliente:</strong></p>
                                <p style="background: #fff3cd; padding: 10px; border-radius: 4px; color: #856404;">
                                    {{ $pedido->observacoes_pedido }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- LISTA DE PRODUTOS --}}
                    <div class="card-detalhe">
                        <h3>📦 Resumo dos Itens</h3>
                        <ul class="lista-itens">
                            @foreach($itens as $item)
                                <li class="item-pedido">
                                    <div class="item-titulo">
                                        <span>{{ $item->quantidade_item }}x {{ $item->produto->nome_produto ?? 'Produto Removido' }}</span>
                                        <span>R$ {{ number_format($item->preco_unitario_item * $item->quantidade_item, 2, ',', '.') }}</span>
                                    </div>
                                    
                                    {{-- ADICIONAIS DESTE ITEM --}}
                                    @if(count($item->adicionais) > 0)
                                        @foreach($item->adicionais as $add)
                                            <div class="item-adicional">
                                                + 1x {{ $add->detalhe->nome_adicional ?? 'Adicional' }} (R$ {{ number_format($add->preco_cobrado_add, 2, ',', '.') }})
                                            </div>
                                        @endforeach
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div style="margin-top: 20px; text-align: right; border-top: 2px solid #eee; padding-top: 15px;">
                            <h2 style="color: #2b4231; margin: 0;">Total: R$ {{ number_format($pedido->valor_total_pedido, 2, ',', '.') }}</h2>
                        </div>
                    </div>

                </div>

            </section>
        </main>
    </div>
</body>
</html>