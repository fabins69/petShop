<?php

use App\Livewire\Auth\Login;
use App\Livewire\Categoria\CategoriaIndex;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Estoque\EstoqueMinimoIndex;
use App\Livewire\Estoque\MovimentacaoIndex;
use App\Livewire\Produto\ProdutoCreate;
use App\Livewire\Produto\ProdutoEdit;
use App\Livewire\Produto\ProdutoIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardIndex::class)->name('dashboard');

    Route::get('/produtos', ProdutoIndex::class)->name('produtos.index');
    Route::get('/produtos/create', ProdutoCreate::class)->name('produtos.create');
    Route::get('/produtos/{id}/edit', ProdutoEdit::class)->whereNumber('id')->name('produtos.edit');

    Route::get('/categorias', CategoriaIndex::class)->name('categorias.index');

    Route::get('/estoque/movimentacoes', MovimentacaoIndex::class)->name('estoque.movimentacoes');
    Route::get('/estoque/minimo', EstoqueMinimoIndex::class)->name('estoque.minimo');
});
