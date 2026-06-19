<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Painel Admin</title>
    
    {{-- CSS Principal do seu Dashboard --}}
    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        /* CSS específico apenas para a tabela de pedidos ficar bonita */
        .table-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-top: 20px;}
        .table-admin { width: 100%; border-collapse: collapse; text-align: left; }
        .table-admin th { background-color: #f8f9fa; padding: 15px; font-size: 14px; color: #555; border-bottom: 2px solid #eee; }
        .table-admin td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; color: #444; }
        .table-admin tr:hover { background-color: #fcfcfc; }

        /* Cores Dinâmicas para os Status */
        .status-select { padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc; font-weight: bold; cursor: pointer; outline: none;}
        .status-PENDENTE { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .status-PREPARANDO { background-color: #cce5ff; color: #004085; border-color: #b8daff; }
        .status-ENTREGUE { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .status-CANCELADO { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

        .btn-detalhes { background-color: #2b4231; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; }
        .btn-detalhes:hover { background-color: #1e2e22; }
        
        .alerta-sucesso { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;}
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
                
                {{-- O botão de pedidos com a classe active dinâmica! --}}
                <a href="{{ route('admin.pedidos') }}" class="{{ request()->routeIs('admin.pedidos') ? 'active' : '' }}"><i class="ph ph-receipt"></i> Pedidos</a>
            </nav>
            <div class="sidebar-footer">
                <a href="#"><i class="ph ph-sign-out"></i> Sair do Sistema</a>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">
            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gestão de Pedidos</h1>
                </div>
                <div class="user-profile">
                    <span>Olá, Administrador</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            {{-- ÁREA DA TABELA --}}
            <section class="content-area">
                
                @if(session('success'))
                    <div class="alerta-sucesso">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-card">
                    <table class="table-admin">
                        <thead>
                            <tr>
                                <th>Nº Pedido</th>
                                <th>Data</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Pagamento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                                <tr>
                                    <td style="font-weight: bold;">#{{ str_pad($pedido->id_pedido, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ date('d/m/Y H:i', strtotime($pedido->created_at)) }}</td>
                                    
                                    {{-- Puxa o nome do cliente pelo Model --}}
                                    <td>{{ $pedido->cliente->nome_cliente ?? 'Cliente Removido' }}</td>
                                    
                                    <td style="font-weight: bold;">R$ {{ number_format($pedido->valor_total_pedido, 2, ',', '.') }}</td>
                                    <td>{{ strtoupper($pedido->forma_pagamento_pedido) }}</td>
                                    
                                    <td>
                                        {{-- Formulário para atualizar o status super rápido --}}
                                        <form action="{{ route('admin.pedidos.status', $pedido->id_pedido) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <select name="status" class="status-select status-{{ $pedido->status_pedido }}" onchange="this.form.submit()">
                                                <option value="PENDENTE" {{ $pedido->status_pedido == 'PENDENTE' ? 'selected' : '' }}>Pendente</option>
                                                <option value="PREPARANDO" {{ $pedido->status_pedido == 'PREPARANDO' ? 'selected' : '' }}>Preparando</option>
                                                <option value="ENTREGUE" {{ $pedido->status_pedido == 'ENTREGUE' ? 'selected' : '' }}>Entregue</option>
                                                <option value="CANCELADO" {{ $pedido->status_pedido == 'CANCELADO' ? 'selected' : '' }}>Cancelado</option>
                                            </select>
                                        </form>
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('admin.pedidos.detalhes', $pedido->id_pedido) }}" class="btn-detalhes"><i class="ph ph-eye"></i> Detalhes</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 30px; color: #888;">
                                        Nenhum pedido recebido ainda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Links de Paginação (se passarem de 15 pedidos) --}}
                <div style="margin-top: 20px;">
                    {{ $pedidos->links() }}
                </div>

            </section>
        </main>
    </div>
</body>
</html>