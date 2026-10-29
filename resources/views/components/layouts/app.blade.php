<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PetShop | Controle de Estoque' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @livewireStyles
    <style>
        :root { --pet-green: #176b50; --pet-green-dark: #104d3b; --pet-mint: #eaf5ef; --pet-ink: #23312c; --pet-muted: #6b7973; }
        body { background: #f5f7f6; color: var(--pet-ink); font-family: Inter, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .navbar-pet { background: linear-gradient(110deg, var(--pet-green-dark), var(--pet-green)); }
        .navbar-pet .navbar-brand { color: #fff; font-weight: 750; letter-spacing: -.02em; }
        .navbar-pet .nav-link { color: rgba(255,255,255,.82); border-radius: .55rem; margin: 0 .1rem; }
        .navbar-pet .nav-link:hover, .navbar-pet .nav-link.active { color: #fff; background: rgba(255,255,255,.14); }
        .page-title { font-weight: 750; letter-spacing: -.035em; }
        .subtle { color: var(--pet-muted); }
        .card { border: 1px solid #e6ece8; border-radius: 1rem; box-shadow: 0 5px 22px rgba(20, 50, 38, .035); }
        .card-header { background: #fff; border-bottom: 1px solid #edf1ee; border-radius: 1rem 1rem 0 0 !important; }
        .btn-success { background-color: var(--pet-green); border-color: var(--pet-green); }
        .btn-success:hover { background-color: var(--pet-green-dark); border-color: var(--pet-green-dark); }
        .form-control, .form-select { border-color: #dce5df; border-radius: .65rem; min-height: 43px; }
        .form-control:focus, .form-select:focus { border-color: #79b59b; box-shadow: 0 0 0 .2rem rgba(23,107,80,.12); }
        .table > :not(caption) > * > * { padding: .85rem .75rem; vertical-align: middle; }
        .metric-icon { width: 46px; height: 46px; display: inline-flex; align-items: center; justify-content: center; border-radius: .9rem; background: var(--pet-mint); color: var(--pet-green); font-size: 1.25rem; }
        .badge-soft { background: #eaf5ef; color: #176b50; }
        .small-label { font-size: .78rem; text-transform: uppercase; letter-spacing: .055em; font-weight: 700; color: var(--pet-muted); }
    </style>
</head>
<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-dark navbar-pet shadow-sm">
            <div class="container-fluid px-lg-4">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                    <i class="bi bi-heart-pulse-fill"></i><span>PetShop <span class="fw-normal opacity-75">Estoque</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPetshop" aria-controls="menuPetshop" aria-expanded="false" aria-label="Abrir menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menuPetshop">
                    <div class="navbar-nav ms-lg-4 me-auto my-2 my-lg-0">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2 me-1"></i>Visão geral</a>
                        <a class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}" href="{{ route('produtos.index') }}"><i class="bi bi-box-seam me-1"></i>Produtos</a>
                        <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}"><i class="bi bi-tags me-1"></i>Categorias</a>
                        <a class="nav-link {{ request()->routeIs('estoque.movimentacoes') ? 'active' : '' }}" href="{{ route('estoque.movimentacoes') }}"><i class="bi bi-arrow-left-right me-1"></i>Movimentações</a>
                        <a class="nav-link {{ request()->routeIs('estoque.minimo') ? 'active' : '' }}" href="{{ route('estoque.minimo') }}"><i class="bi bi-exclamation-triangle me-1"></i>Estoque mínimo</a>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-white mt-2 mt-lg-0">
                        <span class="small d-none d-md-inline"><i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right me-1"></i>Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-dark navbar-pet shadow-sm">
            <div class="container"><a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('login') }}"><i class="bi bi-heart-pulse-fill"></i> PetShop Estoque</a></div>
        </nav>
    @endauth

    <main class="container-fluid px-3 px-lg-4 py-4">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
