<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Fit Bia</title>

    <link rel="stylesheet" href="{{ asset('fitbia/css/dashboard.css') }}">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <div class="dash-container">

        {{-- MENU LATERAL CENTRALIZADO --}}
        @include('admin.dash.partials.side-bar')

        {{-- CONTEÚDO PRINCIPAL --}}
        <main class="main-content">

            <header class="dash-header">
                <div class="header-left">
                    <button id="btn-menu-mobile" class="btn-menu-mobile" aria-label="Abrir Menu">
                        <i class="ph ph-list"></i>
                    </button>
                    <h1>Dashboard</h1>
                </div>

                <div class="user-profile">
                    <span>Olá, {{ auth('admin')->user()->nome_usuario ?? 'Admin' }}</span>
                    <i class="ph ph-user-circle"></i>
                </div>
            </header>

            <section class="content-area">

                {{-- CARDS COM ÍCONES PREMIUM --}}
                <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                    
                    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between; border-bottom: 4px solid #059669;">
                        <div>
                            <h3 style="color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Faturamento</h3>
                            <p class="stat-number" style="font-size: 26px; font-weight: 900; color: #111827; margin: 0;">R$ {{ number_format($receitaTotal ?? 0, 2, ',', '.') }}</p>
                        </div>
                        <div style="background: #ecfdf5; padding: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="ph ph-currency-dollar" style="font-size: 32px; color: #059669;"></i>
                        </div>
                    </div>

                    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 style="color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Total de Pedidos</h3>
                            <p class="stat-number" style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">{{ $totalPedidos ?? 0 }}</p>
                        </div>
                        <div style="background: #f0fdf4; padding: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="ph ph-receipt" style="font-size: 32px; color: #16a34a;"></i>
                        </div>
                    </div>

                    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 style="color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Produtos Ativos</h3>
                            <p class="stat-number" style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">{{ $produtosAtivos ?? 0 }}</p>
                        </div>
                        <div style="background: #eff6ff; padding: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="ph ph-package" style="font-size: 32px; color: #2563eb;"></i>
                        </div>
                    </div>

                    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 style="color: #6b7280; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Categorias</h3>
                            <p class="stat-number" style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">{{ $totalCategorias ?? 0 }}</p>
                        </div>
                        <div style="background: #fdf4ff; padding: 15px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="ph ph-tag" style="font-size: 32px; color: #c026d3;"></i>
                        </div>
                    </div>

                </div>

                {{-- SEÇÃO DE FATURAMENTO DETALHADO POR PERÍODO --}}
                <div class="faturamento-section" style="margin-top: 30px;">
                    <h2 style="font-size: 14px; font-weight: 700; color: #4b5563; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 15px;">💰 Fluxo de Caixa Flutuante</h2>

                    <div class="faturamento-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">

                        <div style="background: #ffffff; padding: 18px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #10b981; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 12px; color: #6b7280; font-weight: 600;">Ganho de Hoje</span>
                                <p style="font-size: 18px; font-weight: 800; color: #111827; margin: 4px 0 0 0;">R$ {{ number_format($faturamentoDia ?? 0, 2, ',', '.') }}</p>
                            </div>
                            <i class="ph ph-calendar-heart" style="font-size: 24px; color: #10b981;"></i>
                        </div>

                        <div style="background: #ffffff; padding: 18px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #3b82f6; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 12px; color: #6b7280; font-weight: 600;">Esta Semana</span>
                                <p style="font-size: 18px; font-weight: 800; color: #111827; margin: 4px 0 0 0;">R$ {{ number_format($faturamentoSemana ?? 0, 2, ',', '.') }}</p>
                            </div>
                            <i class="ph ph-calendar-blank" style="font-size: 24px; color: #3b82f6;"></i>
                        </div>

                        <div style="background: #ffffff; padding: 18px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #8b5cf6; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 12px; color: #6b7280; font-weight: 600;">Este Mês</span>
                                <p style="font-size: 18px; font-weight: 800; color: #111827; margin: 4px 0 0 0;">R$ {{ number_format($faturamentoMes ?? 0, 2, ',', '.') }}</p>
                            </div>
                            <i class="ph ph-chart-line-up" style="font-size: 24px; color: #8b5cf6;"></i>
                        </div>

                        <div style="background: #ffffff; padding: 18px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); border-left: 4px solid #f59e0b; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 12px; color: #6b7280; font-weight: 600;">Balanço Anual</span>
                                <p style="font-size: 18px; font-weight: 800; color: #111827; margin: 4px 0 0 0;">R$ {{ number_format($faturamentoAno ?? 0, 2, ',', '.') }}</p>
                            </div>
                            <i class="ph ph-trend-up" style="font-size: 24px; color: #f59e0b;"></i>
                        </div>

                    </div>
                </div>

                {{-- GRÁFICOS --}}
                <div class="charts-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                    
                    <div class="chart-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h3 style="color: #2b4231; margin-bottom: 20px; font-size: 16px; font-weight: 700;">📊 Status dos Pedidos</h3>
                        <div style="position: relative; height: 260px; width: 100%; display: flex; justify-content: center;">
                            <canvas id="graficoStatus"></canvas>
                        </div>
                    </div>

                    <div class="chart-card" style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <h3 style="color: #2b4231; margin-bottom: 20px; font-size: 16px; font-weight: 700;">💳 Formas de Pagamento</h3>
                        <div style="position: relative; height: 260px; width: 100%;">
                            <canvas id="graficoPagamento"></canvas>
                        </div>
                    </div>

                </div>

                {{-- SCRIPT DOS GRÁFICOS --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(17, 24, 39, 0.9)';
                        Chart.defaults.plugins.tooltip.padding = 12;
                        Chart.defaults.plugins.tooltip.cornerRadius = 8;
                        Chart.defaults.font.family = "'Inter', sans-serif";

                        const ctxStatus = document.getElementById('graficoStatus').getContext('2d');
                        new Chart(ctxStatus, {
                            type: 'doughnut',
                            data: {
                                labels: ['Pendentes', 'Preparando', 'Entregues', 'Cancelados'],
                                datasets: [{
                                    data: [
                                        {{ $graficoStatus['Pendentes'] ?? 0 }},
                                        {{ $graficoStatus['Preparando'] ?? 0 }},
                                        {{ $graficoStatus['Entregues'] ?? 0 }},
                                        {{ $graficoStatus['Cancelados'] ?? 0 }}
                                    ],
                                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                                    borderWidth: 0,
                                    hoverOffset: 8
                                }]
                            },
                            options: { 
                                responsive: true, 
                                maintainAspectRatio: false,
                                cutout: '75%',
                                plugins: {
                                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } }
                                }
                            }
                        });

                        const ctxPagamento = document.getElementById('graficoPagamento').getContext('2d');
                        new Chart(ctxPagamento, {
                            type: 'bar',
                            data: {
                                labels: ['PIX', 'Cartão', 'Dinheiro'],
                                datasets: [{
                                    label: 'Pedidos',
                                    data: [
                                        {{ $graficoPagamento['PIX'] ?? 0 }},
                                        {{ $graficoPagamento['Cartão'] ?? 0 }},
                                        {{ $graficoPagamento['Dinheiro'] ?? 0 }}
                                    ],
                                    backgroundColor: '#2b4231',
                                    borderRadius: 8,
                                    borderSkipped: false,
                                    barThickness: 40
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: { 
                                    x: { grid: { display: false } },
                                    y: { 
                                        beginAtZero: true, 
                                        ticks: { stepSize: 1 },
                                        border: { display: false },
                                        grid: { color: '#f3f4f6' }
                                    } 
                                }
                            }
                        });
                    });
                </script>

            </section>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btnMenuMobile = document.getElementById("btn-menu-mobile");
            const btnFecharMenu = document.getElementById("btn-fechar-menu");
            const sidebar = document.querySelector(".sidebar");

            if(btnMenuMobile && sidebar) {
                btnMenuMobile.addEventListener("click", () => sidebar.classList.add("aberta"));
            }

            if(btnFecharMenu && sidebar) {
                btnFecharMenu.addEventListener("click", () => sidebar.classList.remove("aberta"));
            }
        });
    </script>
</body>
</html>