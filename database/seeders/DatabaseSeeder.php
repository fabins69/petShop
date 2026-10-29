<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@petshop.com'],
            ['name' => 'Administrador', 'password' => '123456789']
        );

        $racoes = Categoria::firstOrCreate(['nome_categoria' => 'Rações']);
        $medicamentos = Categoria::firstOrCreate(['nome_categoria' => 'Medicamentos']);
        $brinquedos = Categoria::firstOrCreate(['nome_categoria' => 'Brinquedos']);
        $higiene = Categoria::firstOrCreate(['nome_categoria' => 'Higiene']);
        $acessorios = Categoria::firstOrCreate(['nome_categoria' => 'Acessórios']);

        $produtos = [
            [
                'nome' => 'Ração Premium para Cães 10 kg',
                'marca' => 'NutriPet',
                'categoria_id' => $racoes->id,
                'descricao' => 'Ração completa para cães adultos.',
                'preco_custo' => 95.00,
                'preco_venda' => 129.90,
                'qtd_estoque' => 12,
                'estoque_min' => 5,
                'prazo_validade' => today()->addMonths(8)->toDateString(),
            ],
            [
                'nome' => 'Antipulgas para cães',
                'marca' => 'VetCare',
                'categoria_id' => $medicamentos->id,
                'descricao' => 'Produto veterinário. Consulte as instruções da embalagem.',
                'preco_custo' => 28.00,
                'preco_venda' => 44.90,
                'qtd_estoque' => 2,
                'estoque_min' => 4,
                'prazo_validade' => today()->addMonths(5)->toDateString(),
            ],
            [
                'nome' => 'Bola de borracha',
                'marca' => 'PetPlay',
                'categoria_id' => $brinquedos->id,
                'descricao' => 'Brinquedo resistente para cães.',
                'preco_custo' => 8.00,
                'preco_venda' => 16.90,
                'qtd_estoque' => 20,
                'estoque_min' => 6,
                'prazo_validade' => null,
            ],
            [
                'nome' => 'Shampoo para pets 500 ml',
                'marca' => 'BanhoBom',
                'categoria_id' => $higiene->id,
                'descricao' => 'Shampoo para higiene animal.',
                'preco_custo' => 12.00,
                'preco_venda' => 22.90,
                'qtd_estoque' => 7,
                'estoque_min' => 5,
                'prazo_validade' => today()->addMonths(10)->toDateString(),
            ],
            [
                'nome' => 'Coleira ajustável',
                'marca' => 'PetFit',
                'categoria_id' => $acessorios->id,
                'descricao' => 'Coleira ajustável para cães de pequeno e médio porte.',
                'preco_custo' => 10.00,
                'preco_venda' => 24.90,
                'qtd_estoque' => 0,
                'estoque_min' => 3,
                'prazo_validade' => null,
            ],
        ];

        foreach ($produtos as $dados) {
            $produto = Produto::firstOrCreate(
                ['nome' => $dados['nome'], 'marca' => $dados['marca']],
                $dados
            );

            if ($produto->qtd_estoque > 0) {
                MovimentacaoEstoque::firstOrCreate(
                    ['produto_id' => $produto->id, 'observacao' => 'Estoque inicial de demonstração'],
                    [
                        'produto_nome' => $produto->nome,
                        'user_id' => $admin->id,
                        'tipo' => 'entrada',
                        'quantidade' => $produto->qtd_estoque,
                        'estoque_anterior' => 0,
                        'estoque_posterior' => $produto->qtd_estoque,
                    ]
                );
            }
        }
    }
}
