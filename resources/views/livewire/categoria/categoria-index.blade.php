<div>
    <div class="mb-4">
        <div class="small-label mb-1">Organização do catálogo</div>
        <h1 class="h2 page-title mb-1">Categorias</h1>
        <p class="subtle mb-0">Cadastre, edite e organize as categorias dos produtos.</p>
    </div>

    @if (session('success')) <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif
    @if (session('error')) <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div> @endif

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-header px-4 py-3"><h2 class="h5 fw-bold mb-0">{{ $categoriaId ? 'Editar categoria' : 'Nova categoria' }}</h2></div>
                <div class="card-body p-4">
                    <form wire:submit="{{ $categoriaId ? 'update' : 'store' }}" class="vstack gap-3">
                        <div>
                            <label for="nome_categoria" class="form-label fw-semibold">Nome da categoria</label>
                            <input id="nome_categoria" type="text" class="form-control @error('nome_categoria') is-invalid @enderror" wire:model="nome_categoria" maxlength="100" placeholder="Ex.: Rações">
                            @error('nome_categoria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success" type="submit"><i class="bi {{ $categoriaId ? 'bi-check-lg' : 'bi-plus-lg' }} me-1"></i>{{ $categoriaId ? 'Salvar alterações' : 'Cadastrar categoria' }}</button>
                            @if ($categoriaId) <button class="btn btn-outline-secondary" type="button" wire:click="cancelEdit">Cancelar</button> @endif
                        </div>
                    </form>
                    <div class="small subtle mt-3"><i class="bi bi-info-circle me-1"></i>Uma categoria só pode ser excluída quando não houver produtos vinculados.</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3"><div><h2 class="h5 fw-bold mb-0">Categorias cadastradas</h2><div class="small subtle">{{ $categorias->count() }} categoria(s)</div></div><div style="max-width:280px;width:100%"><input type="search" class="form-control" placeholder="Buscar categoria..." wire:model.live="busca"></div></div>
                <div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Categoria</th><th>Produtos vinculados</th><th class="text-end">Ações</th></tr></thead><tbody>
                    @forelse ($categorias as $categoria)
                        <tr><td class="fw-semibold"><i class="bi bi-tag text-success me-2"></i>{{ $categoria->nome_categoria }}</td><td><span class="badge rounded-pill badge-soft">{{ $categoria->produtos_count }}</span></td><td class="text-end text-nowrap"><button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $categoria->id }})"><i class="bi bi-pencil me-1"></i>Editar</button><button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $categoria->id }})" wire:confirm="Tem certeza que deseja excluir esta categoria?"><i class="bi bi-trash me-1"></i>Excluir</button></td></tr>
                    @empty
                        <tr><td colspan="3" class="text-center subtle py-5">Nenhuma categoria encontrada.</td></tr>
                    @endforelse
                </tbody></table></div>
            </div>
        </div>
    </div>
</div>
