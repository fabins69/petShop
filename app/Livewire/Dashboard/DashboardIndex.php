<?php

namespace App\Livewire\Dashboard;

use App\Models\Categoria;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $totalProdutos = Produto::count();
        $totalCategorias = Categoria::count();
        $itensEstoqueBaixo = Produto::whereColumn('qtd_estoque', '<=', 'estoque_min')->count();
        $produtosVencidos = Produto::whereNotNull('prazo_validade')
            ->whereDate('prazo_validade', '<', today())
            ->count();
        $produtosVencendo = Produto::whereNotNull('prazo_validade')
            ->whereBetween('prazo_validade', [today(), today()->addDays(30)])
            ->count();

        $estoqueBaixo = Produto::with('categoria')
            ->whereColumn('qtd_estoque', '<=', 'estoque_min')
            ->orderBy('qtd_estoque')
            ->limit(6)
            ->get();

        $movimentacoesRecentes = MovimentacaoEstoque::with(['produto', 'user'])
            ->latest()
            ->limit(6)
            ->get();

        return view('livewire.dashboard.dashboard-index', compact(
            'totalProdutos',
            'totalCategorias',
            'itensEstoqueBaixo',
            'produtosVencidos',
            'produtosVencendo',
            'estoqueBaixo',
            'movimentacoesRecentes',
        ));
    }
}
