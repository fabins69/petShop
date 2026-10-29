<?php

namespace App\Livewire\Produto;

use App\Models\Produto;
use Livewire\Component;

class ProdutoIndex extends Component
{
    public string $busca = '';

    public function delete(int $id): void
    {
        Produto::findOrFail($id)->delete();
        session()->flash('success', 'Produto excluído. O histórico de movimentações será preservado.');
    }

    public function render()
    {
        $produtos = Produto::with('categoria')
            ->when(trim($this->busca) !== '', function ($query) {
                $termo = '%' . trim($this->busca) . '%';
                $query->where(function ($subquery) use ($termo) {
                    $subquery->where('nome', 'like', $termo)
                        ->orWhere('marca', 'like', $termo)
                        ->orWhereHas('categoria', fn ($categoria) => $categoria->where('nome_categoria', 'like', $termo));
                });
            })
            ->orderBy('nome')
            ->get();

        return view('livewire.produto.produto-index', compact('produtos'));
    }
}
