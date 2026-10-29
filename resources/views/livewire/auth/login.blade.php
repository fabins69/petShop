<div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 155px)">
    <div class="col-12 col-sm-9 col-md-6 col-lg-4">
        <div class="text-center mb-4">
            <div class="metric-icon mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem"><i class="bi bi-heart-pulse-fill"></i></div>
            <h1 class="h3 page-title mb-1">Bem-vindo de volta</h1>
            <p class="subtle mb-0">Entre para gerenciar o estoque do pet shop.</p>
        </div>
        <div class="card">
            <div class="card-body p-4 p-lg-5">
                <form wire:submit="entrar" class="vstack gap-3">
                    <div>
                        <label for="email" class="form-label fw-semibold">E-mail</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" autocomplete="username" autofocus placeholder="admin@petshop.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="password" class="form-label fw-semibold">Senha</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" autocomplete="current-password" placeholder="Digite sua senha">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-2"><i class="bi bi-box-arrow-in-right me-2"></i>Entrar no sistema</button>
                </form>
            </div>
        </div>
        <p class="text-center subtle small mt-3">Acesso restrito aos funcionários autorizados.</p>
    </div>
</div>
