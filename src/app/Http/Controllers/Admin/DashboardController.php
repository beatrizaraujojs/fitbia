<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
   public function index()
    {
        // 1. Cards Gerais
        $totalPedidos = Pedido::count();
        $produtosAtivos = Produto::where('status_produto', 'ATIVO')->count();
        $totalCategorias = Categoria::count();
        $receitaTotal = Pedido::where('status_pedido', '!=', 'CANCELADO')->sum('valor_total_pedido');

        // 💰 2. FATURAMENTO POR PERÍODO (Ignorando cancelados)
        $hoje = Carbon::today();
        
        $faturamentoDia = Pedido::where('status_pedido', '!=', 'CANCELADO')
            ->whereDate('created_at', $hoje)
            ->sum('valor_total_pedido');

        $faturamentoSemana = Pedido::where('status_pedido', '!=', 'CANCELADO')
            ->whereBetween('created_at', [$hoje->copy()->startOfWeek(), $hoje->copy()->endOfWeek()])
            ->sum('valor_total_pedido');

        $faturamentoMes = Pedido::where('status_pedido', '!=', 'CANCELADO')
            ->whereMonth('created_at', $hoje->month)
            ->whereYear('created_at', $hoje->year)
            ->sum('valor_total_pedido');

        $faturamentoAno = Pedido::where('status_pedido', '!=', 'CANCELADO')
            ->whereYear('created_at', $hoje->year)
            ->sum('valor_total_pedido');


        // 3. Gráficos (Status)
        $graficoStatus = [
            'Pendentes'  => Pedido::where('status_pedido', 'PENDENTE')->count(),
            'Preparando' => Pedido::where('status_pedido', 'PREPARANDO')->count(),
            'Entregues'  => Pedido::where('status_pedido', 'ENTREGUE')->count(),
            'Cancelados' => Pedido::where('status_pedido', 'CANCELADO')->count(),
        ];

        // 4. Gráficos (Pagamento)
        $graficoPagamento = [
            'PIX'      => Pedido::where('forma_pagamento_pedido', 'PIX')->count(),
            'Cartão'   => Pedido::where('forma_pagamento_pedido', 'CARTAO')->count(),
            'Dinheiro' => Pedido::where('forma_pagamento_pedido', 'DINHEIRO')->count(),
        ];

        return view('admin.dash.dashboard', compact(
            'totalPedidos', 
            'produtosAtivos', 
            'totalCategorias',
            'receitaTotal',
            'faturamentoDia',      // Novas variáveis enviadas para a view
            'faturamentoSemana',
            'faturamentoMes',
            'faturamentoAno',
            'graficoStatus',
            'graficoPagamento'
        ));
    }
}