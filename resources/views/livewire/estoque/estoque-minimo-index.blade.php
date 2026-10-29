<div>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4"><div><div class="small-label mb-1">Reposição de mercadorias</div><h1 class="h2 page-title mb-1">Alerta de estoque mínimo</h1><p class="subtle mb-0">Produtos cuja quantidade está no limite ou abaixo do mínimo configurado.</p></div><a href="{{ route('estoque.movimentacoes') }}" class="btn btn-success"><i class="bi bi-arrow-left-right me-1"></i>Registrar movimentação</a></div>
    <div class="alert alert-warning border-0"><i class="bi bi-exclamation-triangle-fill me-2"></i><strong>{{ $produtos->count() }}</strong> produto(s) precisam de atenção nesta consulta.</div>
    <div class="card">
        <div class="card-header px-4 py-3 d-flex flex-wrap align-items-center justify-content-between gap-3"><div><h2 class="h5 fw-bold mb-0">Produtos para reposição</h2></div><div style="max-width:340px;width:100%"><input type="search" class="form-control" wire:model.live="busca" placeholder="Buscar por nome ou marca..."></div></div>
        <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Produto</th><th>Categoria</th><th>Quantidade atual</th><th>Estoque mínimo</th><th>Faltam para o mínimo</th><th></th></tr></thead><tbody>
            @forelse ($produtos as $produto)
                <tr><td><div class="fw-semibold">{{ $produto->nome }}</div><div class="small subtle">{{ $produto->marca }}</div></td><td>{{ $produto->categoria?->nome_categoria ?? 'Sem categoria' }}</td><td><span class="badge text-bg-danger">{{ $produto->qtd_estoque }} un.</span></td><td>{{ $produto->estoque_min }} un.</td><td class="fw-semibold">{{ max(0, (int) $produto->estoque_min - (int) $produto->qtd_estoque) }} un.</td><td class="text-end"><a class="btn btn-sm btn-outline-success" href="{{ route('estoque.movimentacoes') }}"><i class="bi bi-plus-lg me-1"></i>Repor</a></td></tr>
            @empty
                <tr><td colspan="6" class="text-center py-5"><i class="bi bi-check-circle text-success fs-2 d-block mb-2"></i><span class="fw-semibold">Tudo certo!</span><div class="subtle">Nenhum produto está no limite de estoque com os filtros atuais.</div></td></tr>
            @endforelse
        </tbody></table></div>
    </div>
</div>
