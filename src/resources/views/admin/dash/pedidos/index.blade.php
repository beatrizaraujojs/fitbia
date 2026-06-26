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
        .table-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 20px;
        }

        .table-admin {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .table-admin th {
            background-color: #f8f9fa;
            padding: 15px;
            font-size: 14px;
            color: #555;
            border-bottom: 2px solid #eee;
        }

        .table-admin td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            color: #444;
        }

        .table-admin tr:hover {
            background-color: #fcfcfc;
        }

        /* Cores Dinâmicas para os Status */
        .status-select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-weight: bold;
            cursor: pointer;
            outline: none;
        }

        .status-PENDENTE { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .status-PREPARANDO { background-color: #cce5ff; color: #004085; border-color: #b8daff; }
        .status-ENTREGUE { background-color: #d4edda; color: #155724; border-color: #c3e6cb; }
        .status-CANCELADO { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }

        .btn-detalhes {
            background-color: #2b4231;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-detalhes:hover { background-color: #1e2e22; }

        .alerta-sucesso {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        /* Estilo da nova barra de filtros */
        .filter-bar {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .filter-group { flex: 1; min-width: 150px; }
        .filter-group label { display: block; font-size: 13px; color: #555; margin-bottom: 5px; font-weight: bold; }
        .filter-group select, .filter-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; outline: none; }
        .filter-group select:focus, .filter-group input:focus { border-color: #2b4231; }
        
        .btn-novo-pedido {
            background-color: #10b981; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: bold; 
            display: flex; 
            align-items: center; 
            gap: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .btn-novo-pedido:hover { background-color: #059669; }
    </style>
</head>

<body>
    <div class="dash-container">

        {{-- MENU LATERAL --}}
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('fitbia/images/FITBIA LOGO.svg') }}" alt="Logótipo Fit Bia" style="max-width: 120px; height: auto;">
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

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">
            <header class="dash-header">
                <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu"><i class="ph ph-list"></i></button>
                    <h1>Gestão de Pedidos</h1>
                    
                    {{-- 🌟 NOVO BOTÃO DE CADASTRAR PEDIDO 🌟 --}}
                    <a href="{{ route('admin.pedidos.create') }}" class="btn-novo-pedido">
                        <i class="ph ph-plus-circle" style="font-size: 20px;"></i> Novo Pedido
                    </a>

                    {{-- 🌟 BOTÃO PARA DESBLOQUEAR O ÁUDIO 🌟 --}}
                    <button id="btn-ativar-som" style="background-color: #f8d7da; color: #721c24; padding: 10px 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 14px; transition: 0.3s;">
                        <i class="ph ph-speaker-slash" style="font-size: 20px;"></i> <span>Ativar Som</span>
                    </button>
                </div>
                 
                <div style="display: flex; align-items: center; gap: 20px;">
                    <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px; color: #4b5563; text-decoration: none; font-weight: 600; font-size: 14px; background: #f3f4f6; padding: 8px 15px; border-radius: 8px; transition: background 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        <i class="ph ph-storefront" style="font-size: 18px;"></i> Ver o Site
                    </a>
                    <div class="user-profile" style="margin: 0;">
                        <span>Olá, {{ auth('admin')->user()->nome_usuario }}</span>
                        <i class="ph ph-user-circle"></i>
                    </div>
                </div>
            </header>

            {{-- ÁREA DE FILTROS E TABELA --}}
            <section class="content-area">

                @if(session('success'))
                <div class="alerta-sucesso">
                    {{ session('success') }}
                </div>
                @endif

                {{-- 🌟 BARRA DE FILTROS 🌟 --}}
                <form method="GET" action="{{ route('admin.pedidos') }}" class="filter-bar">
                    <div class="filter-group">
                        <label>Período Rápido</label>
                        <select name="periodo">
                            <option value="">Todos os Pedidos</option>
                            <option value="hoje" {{ request('periodo') == 'hoje' ? 'selected' : '' }}>Hoje</option>
                            <option value="semana" {{ request('periodo') == 'semana' ? 'selected' : '' }}>Esta Semana</option>
                            <option value="mes" {{ request('periodo') == 'mes' ? 'selected' : '' }}>Este Mês</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Data Específica (Início)</label>
                        <input type="date" name="data_inicio" value="{{ request('data_inicio') }}">
                    </div>

                    <div class="filter-group">
                        <label>Data Específica (Fim)</label>
                        <input type="date" name="data_fim" value="{{ request('data_fim') }}">
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" style="background-color: #2b4231; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                            <i class="ph ph-funnel"></i> Filtrar
                        </button>

                        {{-- Botão de limpar aparece só se tiver algum filtro ativo --}}
                        @if(request()->has('periodo') || request()->has('data_inicio') || request()->has('data_fim'))
                        <a href="{{ route('admin.pedidos') }}" style="background-color: #f8d7da; color: #721c24; padding: 10px 20px; border-radius: 4px; font-weight: bold; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                            <i class="ph ph-x"></i> Limpar
                        </a>
                        @endif
                    </div>
                </form>

                {{-- TABELA --}}
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

                                <td>{{ $pedido->cliente->nome_cliente ?? 'Cliente Removido' }}</td>

                                <td style="font-weight: bold;">R$ {{ number_format($pedido->valor_total_pedido, 2, ',', '.') }}</td>
                                <td>{{ strtoupper($pedido->forma_pagamento_pedido) }}</td>

                                <td>
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
                                    Nenhum pedido encontrado para este filtro.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Links de Paginação --}}
                <div style="margin-top: 20px;">
                    {{ $pedidos->appends(request()->query())->links() }}
                </div>

            </section>
        </main>
    </div>

    {{-- ÁUDIO DE NOTIFICAÇÃO --}}
    <audio id="som-novo-pedido" preload="auto">
        <source src="{{ asset('fitbia/audio/universfield-new-notification-051-494246.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- SCRIPT PARA TOCAR O SOM E ATUALIZAR PEDIDOS AUTOMATICAMENTE (AJAX) --}}
    <script>
        // 1. Lógica do botão de desbloqueio de áudio
        let somAtivado = false;
        
        document.getElementById('btn-ativar-som').addEventListener('click', function() {
            const som = document.getElementById("som-novo-pedido");
            const icone = this.querySelector('i');
            const texto = this.querySelector('span');

            // Toca o som "silenciosamente" só para forçar o navegador a desbloquear
            som.volume = 0; 
            som.play().then(() => {
                som.pause();
                som.currentTime = 0;
                som.volume = 1; // Devolve o volume normal
                
                somAtivado = true;
                
                // Muda a aparência do botão para mostrar que está ativo (Verde)
                this.style.backgroundColor = "#d4edda";
                this.style.color = "#155724";
                icone.classList.remove('ph-speaker-slash');
                icone.classList.add('ph-speaker-high');
                texto.innerText = "Alertas Ativados";
            }).catch(error => console.log("Erro ao desbloquear som:", error));
        });

        // 2. Função para tocar o som de forma segura
        function tocarSomPedido() {
            if (!somAtivado) {
                console.log("O admin ainda não ativou o botão de som.");
                return;
            }

            const som = document.getElementById("som-novo-pedido");
            som.currentTime = 0; // Zera o áudio para tocar do início
            som.play().catch(error => console.log("O navegador bloqueou.", error));
        }

        // 3. Guarda o número do último pedido que está na tela no momento
        let ultimoPedidoId = {{ $pedidos->first()->id_pedido ?? 0 }};

        // 4. Função que verifica silenciosamente se há pedidos novos
        function verificarNovosPedidos() {
            let currentUrl = window.location.href;

            fetch(currentUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");

                // Encontra a tabela que acabou de chegar do servidor
                let novaTabela = doc.querySelector('.table-card');
                let primeiraLinhaNova = novaTabela.querySelector('tbody tr td:first-child');
                
                if (primeiraLinhaNova && primeiraLinhaNova.textContent.trim() !== "Nenhum pedido encontrado para este filtro.") {
                    let novoPedidoIdTexto = primeiraLinhaNova.textContent;
                    let novoPedidoId = parseInt(novoPedidoIdTexto.replace(/\D/g, ''));

                    // Se o ID for maior que o último guardado, significa que entrou um pedido novo!
                    if (novoPedidoId > ultimoPedidoId) {
                        console.log("NOVO PEDIDO DETETADO! A TOCAR O SOM...");
                        
                        // Atualiza a tabela na tela do utilizador
                        document.querySelector('.table-card').innerHTML = novaTabela.innerHTML;
                        
                        // Atualiza os links de paginação (caso existam)
                        let novaPaginacao = doc.querySelector('.content-area > div:last-child');
                        if (novaPaginacao && document.querySelector('.content-area > div:last-child')) {
                            document.querySelector('.content-area > div:last-child').innerHTML = novaPaginacao.innerHTML;
                        }

                        // Toca o alerta sonoro
                        tocarSomPedido();

                        // Atualiza a variável para não tocar o som repetido
                        ultimoPedidoId = novoPedidoId;
                    }
                }
            })
            .catch(error => console.error('Erro ao verificar pedidos:', error));
        }

        // 5. Executa a função a cada 10 segundos (10000 milissegundos)
        setInterval(verificarNovosPedidos, 10000); 
    </script>
</body>
</html>