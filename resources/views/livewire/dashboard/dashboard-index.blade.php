<div>
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="small-label mb-1">Painel de controle</div>
            <h1 class="h2 page-title mb-1">Visão geral do estoque</h1>
            <p class="subtle mb-0">Acompanhe produtos, alertas e movimentações do pet shop.</p>
        </div>
        <a href="{{ route('produtos.create') }}" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>Novo produto</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="small-label mb-1">Produtos cadastrados</div><div class="fs-2 fw-bold">{{ $totalProdutos }}</div><a href="{{ route('produtos.index') }}" class="small text-success text-decoration-none">Ver produtos <i class="bi bi-arrow-right"></i></a></div><span class="metric-icon"><i class="bi bi-box-seam"></i></span></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="small-label mb-1">Categorias</div><div class="fs-2 fw-bold">{{ $totalCategorias }}</div><a href="{{ route('categorias.index') }}" class="small text-success text-decoration-none">Gerenciar <i class="bi bi-arrow-right"></i></a></div><span class="metric-icon"><i class="bi bi-tags"></i></span></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="small-label mb-1">Estoque no limite/baixo</div><div class="fs-2 fw-bold {{ $itensEstoqueBaixo ? 'text-danger' : '' }}">{{ $itensEstoqueBaixo }}</div><a href="{{ route('estoque.minimo') }}" class="small text-success text-decoration-none">Ver alertas <i class="bi bi-arrow-right"></i></a></div><span class="metric-icon" style="background:#fff1e8;color:#b95621"><i class="bi bi-exclamation-triangle"></i></span></div></div></div>
        <div class="col-12 col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex justify-content-between align-items-center"><div><div class="small-label mb-1">Validades vencidas</div><div class="fs-2 fw-bold {{ $produtosVencidos ? 'text-danger' : '' }}">{{ $produtosVencidos }}</div><div class="small subtle">{{ $produtosVencendo }} vencem em 30 dias</div></div><span class="metric-icon" style="background:#fff1e8;color:#b95621"><i class="bi bi-calendar2-x"></i></span></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center px-4 py-3"><div><h2 class="h5 fw-bold mb-1">Produtos com estoque baixo</h2><p class="small subtle mb-0">Quantidade no limite ou abaixo do mínimo configurado.</p></div><a href="{{ route('estoque.minimo') }}" class="btn btn-sm btn-outline-success">Ver todos</a></div>
                <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Produto</th><th>Categoria</th><th>Estoque</th><th>Mínimo</th></tr></thead><tbody>
                    @forelse ($estoqueBaixo as $produto)
                        <tr><td class="fw-semibold">{{ $produto->nome }}<div class="small subtle">{{ $produto->marca }}</div></td><td>{{ $produto->categoria?->nome_categoria ?? 'Sem categoria' }}</td><td><span class="badge text-bg-danger">{{ $produto->qtd_estoque }}</span></td><td>{{ $produto->estoque_min }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center subtle py-4"><i class="bi bi-check-circle text-success me-1"></i>Nenhum produto no limite de estoque.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center px-4 py-3"><div><h2 class="h5 fw-bold mb-1">Movimentações recentes</h2><p class="small subtle mb-0">Últimas entradas e saídas registradas.</p></div><a href="{{ route('estoque.movimentacoes') }}" class="btn btn-sm btn-outline-success">Abrir histórico</a></div>
                <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Produto</th><th>Tipo</th><th>Qtd.</th><th>Data</th></tr></thead><tbody>
                    @forelse ($movimentacoesRecentes as $movimentacao)
                        <tr><td class="fw-semibold">{{ $movimentacao->produto?->nome ?? $movimentacao->produto_nome }}<div class="small subtle">{{ $movimentacao->user?->name ?? 'Funcionário removido' }}</div></td><td><span class="badge {{ $movimentacao->tipo === 'entrada' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $movimentacao->tipo === 'entrada' ? 'Entrada' : 'Saída' }}</span></td><td>{{ $movimentacao->quantidade }}</td><td class="text-nowrap">{{ $movimentacao->created_at->format('d/m/Y H:i') }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center subtle py-4">Ainda não há movimentações registradas.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </div>
    </div>
</div>
