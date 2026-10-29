<?php

namespace App\Livewire\Categoria;

use App\Models\Categoria;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CategoriaIndex extends Component
{
    public string $nome_categoria = '';
    public string $busca = '';
    public ?int $categoriaId = null;

    public function store(): void
    {
        $dados = $this->validate([
            'nome_categoria' => ['required', 'string', 'max:100', 'unique:categorias,nome_categoria'],
        ], [
            'nome_categoria.required' => 'Informe o nome da categoria.',
            'nome_categoria.unique' => 'Já existe uma categoria com esse nome.',
            'nome_categoria.max' => 'O nome deve ter no máximo 100 caracteres.',
        ]);

        Categoria::create($dados);
        $this->reset('nome_categoria');
        session()->flash('success', 'Categoria cadastrada com sucesso.');
    }

    public function edit(int $id): void
    {
        $categoria = Categoria::findOrFail($id);
        $this->categoriaId = $categoria->id;
        $this->nome_categoria = $categoria->nome_categoria;
        $this->resetValidation();
    }

    public function update(): void
    {
        if (!$this->categoriaId) {
            return;
        }

        $dados = $this->validate([
            'nome_categoria' => [
                'required', 'string', 'max:100',
                Rule::unique('categorias', 'nome_categoria')->ignore($this->categoriaId),
            ],
        ], [
            'nome_categoria.required' => 'Informe o nome da categoria.',
            'nome_categoria.unique' => 'Já existe uma categoria com esse nome.',
            'nome_categoria.max' => 'O nome deve ter no máximo 100 caracteres.',
        ]);

        Categoria::findOrFail($this->categoriaId)->update($dados);
        $this->cancelEdit();
        session()->flash('success', 'Categoria atualizada com sucesso.');
    }

    public function cancelEdit(): void
    {
        $this->reset('nome_categoria', 'categoriaId');
        $this->resetValidation();
    }

    public function delete(int $id): void
    {
        $categoria = Categoria::withCount('produtos')->findOrFail($id);

        if ($categoria->produtos_count > 0) {
            session()->flash('error', 'Não é possível excluir esta categoria porque há produtos vinculados a ela.');
            return;
        }

        $categoria->delete();
        if ($this->categoriaId === $id) {
            $this->cancelEdit();
        }
        session()->flash('success', 'Categoria excluída com sucesso.');
    }

    public function render()
    {
        $categorias = Categoria::withCount('produtos')
            ->when(trim($this->busca) !== '', function ($query) {
                $query->where('nome_categoria', 'like', '%' . trim($this->busca) . '%');
            })
            ->orderBy('nome_categoria')
            ->get();

        return view('livewire.categoria.categoria-index', compact('categorias'));
    }
}
