<div>
    <div class="mb-4"><div class="small-label mb-1">Controle de entradas e saídas</div><h1 class="h2 page-title mb-1">Movimentações de estoque</h1><p class="subtle mb-0">Cada operação atualiza o saldo e registra a data e o funcionário responsável.</p></div>
    @if (session('success')) <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="row g-4 align-items-start">
        <div class="col-12 col-xl-4">
            <div class="card">
                <div class="card-header px-4 py-3"><h2 class="h5 fw-bold mb-0">Registrar movimentação</h2></div>
                <div class="card-body p-4">
                    <form wire:submit="store" class="vstack gap-3">
                        <div><label for="produto_id" class="form-label fw-semibold">Produto *</label><select id="produto_id" class="form-select @error('produto_id') is-invalid @enderror" wire:model="produto_id"><option value="">Selecione um produto...</option>@foreach ($produtos as $produto)<option value="{{ $produto->id }}">{{ $produto->nome }} — {{ $produto->qtd_estoque }} un.</option>@endforeach</select>@error('produto_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div><label class="form-label fw-semibold d-block">Tipo de operação *</label><div class="row g-2"><div class="col-6"><label class="border rounded-3 p-3 w-100 d-flex gap-2 align-items-center {{ $tipo === 'entrada' ? 'border-success bg-success-subtle' : '' }}"><input type="radio" class="form-check-input mt-0" wire:model="tipo" value="entrada"><span><i class="bi bi-box-arrow-in-down text-success me-1"></i>Entrada</span></label></div><div class="col-6"><label class="border rounded-3 p-3 w-100 d-flex gap-2 align-items-center {{ $tipo === 'saida' ? 'border-danger bg-danger-subtle' : '' }}"><input type="radio" class="form-check-input mt-0" wire:model="tipo" value="saida"><span><i class="bi bi-box-arrow-up text-danger me-1"></i>Saída</span></label></div></div>@error('tipo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                        <div><label for="quantidade" class="form-label fw-semibold">Quantidade *</label><input id="quantidade" type="number" min="1" step="1" class="form-control @error('quantidade') is-invalid @enderror" wire:model="quantidade">@error('quantidade')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div><label for="observacao" class="form-label fw-semibold">Observação</label><textarea id="observacao" rows="3" maxlength="500" class="form-control @error('observacao') is-invalid @enderror" wire:model="observacao" placeholder="Ex.: reposição do fornecedor, avaria, ajuste..."></textarea>@error('observacao')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <button class="btn btn-success w-100" type="submit"><i class="bi bi-check-circle me-1"></i>Registrar operação</button>
                    </form>
                    <div class="alert alert-warning small mt-3 mb-0"><i class="bi bi-shield-check me-1"></i>Saídas maiores que a quantidade disponível são bloqueadas para impedir estoque negativo.</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header px-4 py-3"><h2 class="h5 fw-bold mb-1">Histórico de movimentações</h2><p class="small subtle mb-0">Exibindo até 100 operações mais recentes.</p></div>
                <div class="p-3 border-bottom"><div class="row g-2"><div class="col-12 col-md-4"><select class="form-select" wire:model.live="filtroTipo"><option value="">Todas as operações</option><option value="entrada">Somente entradas</option><option value="saida">Somente saídas</option></select></div><div class="col-12 col-md-8"><input type="search" class="form-control" wire:model.live="busca" placeholder="Buscar produto ou observação..."></div></div></div>
                <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Data e produto</th><th>Operação</th><th>Saldo</th><th>Funcionário</th></tr></thead><tbody>
                    @forelse ($movimentacoes as $movimentacao)
                        <tr><td><div class="fw-semibold">{{ $movimentacao->produto?->nome ?? $movimentacao->produto_nome }}</div><div class="small subtle">{{ $movimentacao->created_at->format('d/m/Y H:i') }}</div>@if($movimentacao->observacao)<div class="small subtle mt-1">{{ $movimentacao->observacao }}</div>@endif</td><td><span class="badge {{ $movimentacao->tipo === 'entrada' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $movimentacao->tipo === 'entrada' ? 'Entrada' : 'Saída' }}: {{ $movimentacao->quantidade }}</span></td><td><span class="small subtle">{{ $movimentacao->estoque_anterior }}</span><i class="bi bi-arrow-right mx-1"></i><span class="fw-semibold">{{ $movimentacao->estoque_posterior }}</span></td><td>{{ $movimentacao->user?->name ?? 'Funcionário removido' }}</td></tr>
                    @empty
                        <tr><td colspan="4" class="text-center subtle py-5">Nenhuma movimentação encontrada.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </div>
    </div>
</div>
