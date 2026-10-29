<div>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div><div class="small-label mb-1">Catálogo de mercadorias</div><h1 class="h2 page-title mb-1">Produtos</h1><p class="subtle mb-0">Consulte os produtos e acompanhe as quantidades disponíveis.</p></div>
        <a class="btn btn-success" href="{{ route('produtos.create') }}"><i class="bi bi-plus-lg me-1"></i>Novo produto</a>
    </div>

    @if (session('success')) <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if (session('error')) <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="card">
        <div class="card-header px-4 py-3 d-flex flex-wrap align-items-center justify-content-between gap-3"><div><h2 class="h5 fw-bold mb-1">Lista de produtos</h2><div class="small subtle">{{ $produtos->count() }} produto(s) encontrado(s)</div></div><div style="max-width:340px;width:100%"><div class="input-group"><span class="input-group-text bg-white"><i class="bi bi-search"></i></span><input type="search" class="form-control" placeholder="Buscar por produto, marca ou categoria..." wire:model.live="busca"></div></div></div>
        <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Produto</th><th>Categoria</th><th>Preço de venda</th><th>Estoque</th><th>Validade</th><th class="text-end">Ações</th></tr></thead><tbody>
            @forelse ($produtos as $produto)
                <tr>
                    <td><div class="fw-semibold">{{ $produto->nome }}</div><div class="small subtle">{{ $produto->marca }} · ID {{ $produto->id }}</div></td>
                    <td>{{ $produto->categoria?->nome_categoria ?? 'Sem categoria' }}</td>
                    <td class="fw-semibold">R$ {{ number_format((float) $produto->preco_venda, 2, ',', '.') }}</td>
                    <td><div class="fw-semibold {{ $produto->qtd_estoque <= $produto->estoque_min ? 'text-danger' : '' }}">{{ $produto->qtd_estoque }} un.</div><div class="small subtle">Mínimo: {{ $produto->estoque_min }}</div>@if($produto->qtd_estoque <= $produto->estoque_min)<span class="badge text-bg-danger mt-1">Estoque baixo</span>@endif</td>
                    <td>{{ $produto->prazo_validade?->format('d/m/Y') ?? 'Não se aplica' }}</td>
                    <td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary me-1" href="{{ route('produtos.edit', $produto->id) }}"><i class="bi bi-pencil me-1"></i>Editar</a><button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $produto->id }})" wire:confirm="Deseja excluir este produto? O histórico de movimentações será mantido."><i class="bi bi-trash me-1"></i>Excluir</button></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center subtle py-5"><i class="bi bi-box-seam fs-3 d-block mb-2"></i>Nenhum produto encontrado. Cadastre o primeiro produto para começar.</td></tr>
            @endforelse
        </tbody></table></div>
    </div>
</div>
