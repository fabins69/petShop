<?php

namespace App\Livewire\Produto;

use App\Models\Categoria;
use App\Models\Produto;
use Livewire\Component;

class ProdutoEdit extends Component
{
    public int $produtoId;
    public string $nome = '';
    public string $descricao = '';
    public string $marca = '';
    public $categoria_id = '';
    public $preco_custo = '';
    public $preco_venda = '';
    public int $qtd_estoque = 0;
    public $estoque_min = 0;
    public $prazo_validade = null;

    public function mount(int $id): void
    {
        $produto = Produto::findOrFail($id);
        $this->produtoId = $produto->id;
        $this->nome = $produto->nome;
        $this->descricao = $produto->descricao ?? '';
        $this->marca = $produto->marca;
        $this->categoria_id = $produto->categoria_id;
        $this->preco_custo = $produto->preco_custo;
        $this->preco_venda = $produto->preco_venda;
        $this->qtd_estoque = (int) $produto->qtd_estoque;
        $this->estoque_min = $produto->estoque_min;
        $this->prazo_validade = $produto->prazo_validade?->format('Y-m-d');
    }

    public function update()
    {
        $dados = $this->validate([
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string', 'max:2000'],
            'marca' => ['required', 'string', 'max:100'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'preco_custo' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'preco_venda' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'estoque_min' => ['required', 'integer', 'min:0', 'max:1000000'],
            'prazo_validade' => ['nullable', 'date'],
        ], [
            'nome.required' => 'Informe o nome do produto.',
            'marca.required' => 'Informe a marca do produto.',
            'categoria_id.required' => 'Selecione uma categoria.',
            'categoria_id.exists' => 'Selecione uma categoria válida.',
            'preco_custo.required' => 'Informe o preço de custo.',
            'preco_venda.required' => 'Informe o preço de venda.',
            'estoque_min.required' => 'Informe o estoque mínimo.',
            'prazo_validade.date' => 'Informe uma data de validade válida.',
        ]);

        Produto::findOrFail($this->produtoId)->update($dados);
        session()->flash('success', 'Produto atualizado com sucesso.');
        return $this->redirectRoute('produtos.index');
    }

    public function render()
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        return view('livewire.produto.produto-edit', compact('categorias'));
    }
}
