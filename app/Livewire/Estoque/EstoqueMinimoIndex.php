<?php

namespace App\Livewire\Estoque;

use App\Models\Produto;
use Livewire\Component;

class EstoqueMinimoIndex extends Component
{
    public string $busca = '';

    public function render()
    {
        $produtos = Produto::with('categoria')
            ->whereColumn('qtd_estoque', '<=', 'estoque_min')
            ->when(trim($this->busca) !== '', function ($query) {
                $termo = '%' . trim($this->busca) . '%';
                $query->where(function ($subquery) use ($termo) {
                    $subquery->where('nome', 'like', $termo)
                        ->orWhere('marca', 'like', $termo);
                });
            })
            ->orderBy('qtd_estoque')
            ->get();

        return view('livewire.estoque.estoque-minimo-index', compact('produtos'));
    }
}
