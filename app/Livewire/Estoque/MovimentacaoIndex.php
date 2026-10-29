<?php

namespace App\Livewire\Estoque;

use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MovimentacaoIndex extends Component
{
    public ?int $produto_id = null;
    public string $tipo = 'entrada';
    public $quantidade = 1;
    public string $observacao = '';
    public string $filtroTipo = '';
    public string $busca = '';

    public function store(): void
    {
        $dados = $this->validate([
            'produto_id' => ['required', 'integer', 'exists:produtos,id'],
            'tipo' => ['required', 'in:entrada,saida'],
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000000'],
            'observacao' => ['nullable', 'string', 'max:500'],
        ], [
            'produto_id.required' => 'Selecione um produto.',
            'produto_id.exists' => 'O produto selecionado não existe mais.',
            'tipo.required' => 'Selecione o tipo de movimentação.',
            'tipo.in' => 'O tipo deve ser entrada ou saída.',
            'quantidade.required' => 'Informe a quantidade.',
            'quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'quantidade.min' => 'A quantidade mínima é 1.',
            'observacao.max' => 'A observação deve ter no máximo 500 caracteres.',
        ]);

        $resultado = DB::transaction(function () use ($dados) {
            $produto = Produto::whereKey($dados['produto_id'])->lockForUpdate()->firstOrFail();
            $anterior = (int) $produto->qtd_estoque;
            $quantidade = (int) $dados['quantidade'];

            if ($dados['tipo'] === 'saida' && $quantidade > $anterior) {
                return ['ok' => false, 'estoque' => $anterior];
            }

            $posterior = $dados['tipo'] === 'entrada'
                ? $anterior + $quantidade
                : $anterior - $quantidade;

            $produto->update(['qtd_estoque' => $posterior]);

            MovimentacaoEstoque::create([
                'produto_id' => $produto->id,
                'produto_nome' => $produto->nome,
                'user_id' => Auth::id(),
                'tipo' => $dados['tipo'],
                'quantidade' => $quantidade,
                'estoque_anterior' => $anterior,
                'estoque_posterior' => $posterior,
                'observacao' => filled($dados['observacao'] ?? null) ? $dados['observacao'] : null,
            ]);

            return ['ok' => true, 'estoque' => $posterior];
        });

        if (!$resultado['ok']) {
            $this->addError('quantidade', 'Saída não permitida: há apenas ' . $resultado['estoque'] . ' unidade(s) em estoque.');
            return;
        }

        $this->reset('produto_id', 'quantidade', 'observacao');
        $this->tipo = 'entrada';
        $this->quantidade = 1;
        session()->flash('success', 'Movimentação registrada. Novo estoque: ' . $resultado['estoque'] . ' unidade(s).');
    }

    public function render()
    {
        $produtos = Produto::orderBy('nome')->get(['id', 'nome', 'qtd_estoque']);

        $movimentacoes = MovimentacaoEstoque::with(['produto', 'user'])
            ->when($this->filtroTipo !== '', fn ($query) => $query->where('tipo', $this->filtroTipo))
            ->when(trim($this->busca) !== '', function ($query) {
                $termo = '%' . trim($this->busca) . '%';
                $query->where(function ($subquery) use ($termo) {
                    $subquery->where('produto_nome', 'like', $termo)
                        ->orWhere('observacao', 'like', $termo);
                });
            })
            ->latest()
            ->limit(100)
            ->get();

        return view('livewire.estoque.movimentacao-index', compact('produtos', 'movimentacoes'));
    }
}
