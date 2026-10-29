<?php

namespace App\Livewire\Produto;

use App\Models\Categoria;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProdutoCreate extends Component
{
    public string $nome = '';
    public string $descricao = '';
    public string $marca = '';
    public $categoria_id = '';
    public $preco_custo = '';
    public $preco_venda = '';
    public $qtd_estoque = 0;
    public $estoque_min = 0;
    public $prazo_validade = null;

    public function store()
    {
        $dados = $this->validate([
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string', 'max:2000'],
            'marca' => ['required', 'string', 'max:100'],
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'preco_custo' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'preco_venda' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'qtd_estoque' => ['required', 'integer', 'min:0', 'max:1000000'],
            'estoque_min' => ['required', 'integer', 'min:0', 'max:1000000'],
            'prazo_validade' => ['nullable', 'date'],
        ], [
            'nome.required' => 'Informe o nome do produto.',
            'marca.required' => 'Informe a marca do produto.',
            'categoria_id.required' => 'Selecione uma categoria.',
            'categoria_id.exists' => 'Selecione uma categoria válida.',
            'preco_custo.required' => 'Informe o preço de custo.',
            'preco_custo.numeric' => 'O preço de custo deve ser numérico.',
            'preco_venda.required' => 'Informe o preço de venda.',
            'preco_venda.numeric' => 'O preço de venda deve ser numérico.',
            'qtd_estoque.required' => 'Informe a quantidade inicial.',
            'qtd_estoque.integer' => 'A quantidade deve ser um número inteiro.',
            'qtd_estoque.min' => 'O estoque não pode ser negativo.',
            'estoque_min.required' => 'Informe o estoque mínimo.',
            'estoque_min.integer' => 'O estoque mínimo deve ser um número inteiro.',
            'prazo_validade.date' => 'Informe uma data de validade válida.',
        ]);

        $produto = DB::transaction(function () use ($dados) {
            $produto = Produto::create($dados);
            $quantidadeInicial = (int) $produto->qtd_estoque;

            if ($quantidadeInicial > 0) {
                MovimentacaoEstoque::create([
                    'produto_id' => $produto->id,
                    'produto_nome' => $produto->nome,
                    'user_id' => Auth::id(),
                    'tipo' => 'entrada',
                    'quantidade' => $quantidadeInicial,
                    'estoque_anterior' => 0,
                    'estoque_posterior' => $quantidadeInicial,
                    'observacao' => 'Estoque inicial do cadastro',
                ]);
            }

            return $produto;
        });

        session()->flash('success', 'Produto cadastrado com sucesso.');
        return $this->redirectRoute('produtos.index');
    }

    public function render()
    {
        $categorias = Categoria::orderBy('nome_categoria')->get();
        return view('livewire.produto.produto-create', compact('categorias'));
    }
}
