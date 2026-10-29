# Sistema de Gerenciamento de Estoque de Pet Shop

Aplicação web em Laravel 11 + Livewire 3 para cadastrar produtos e categorias, controlar entradas e saídas, consultar o histórico de movimentações e identificar produtos no limite de estoque.

## Funcionalidades

- Autenticação de funcionários por e-mail e senha.
- Painel inicial com totais, produtos com estoque baixo e movimentações recentes.
- Cadastro, consulta, edição e exclusão de produtos.
- Cadastro, edição e exclusão de categorias; não permite excluir categoria que tenha produtos vinculados.
- Entradas e saídas de estoque com data/hora e funcionário responsável.
- Bloqueio de saída quando a quantidade solicitada for maior que o saldo disponível.
- Registro da quantidade inicial no histórico ao cadastrar produto.
- Consulta de estoque mínimo e indicadores de validade vencida/próxima do vencimento.
- Histórico de movimentações preservado mesmo quando um produto é excluído.
- Validade opcional para os produtos que não possuem vencimento.

## Requisitos

- PHP 8.2 ou superior
- Composer
- Laravel 11 e Livewire 3 (dependências instaladas pelo Composer)
- Banco SQLite ou MySQL

## Como executar

1. Extraia o projeto e abra o terminal dentro da pasta `exemplolaravel`.
2. Atualize/instale as dependências:

   ```bash
   composer update
   ```

   O projeto enviado tinha um `composer.lock` antigo. Em PHP 8.4, é importante atualizar o Carbon para uma versão compatível antes de executar comandos do Artisan.

3. Crie o arquivo de ambiente a partir do exemplo. No Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

   Se você já possui um `.env` configurado no projeto original, preserve esse arquivo e não o substitua.

4. Gere a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

5. Configure o banco de dados no `.env`. Para MySQL, informe `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`. Para SQLite, crie o arquivo `database/database.sqlite` e deixe `DB_CONNECTION=sqlite`.
6. Se estiver começando com um banco vazio, execute as migrations e cadastre os dados de demonstração:

   ```bash
   php artisan migrate --seed
   ```

   Se estiver aplicando as alterações sobre o banco que você já usa, faça uma cópia de `database/database.sqlite` (ou backup do MySQL) e rode apenas `php artisan migrate`. Não use `migrate:fresh` no banco com seus dados.

7. Inicie o servidor local:

   ```bash
   php artisan serve
   ```

8. Acesse `http://127.0.0.1:8000/login`.

## Acesso de demonstração

- E-mail: `admin@petshop.com`
- Senha: `123456789`

A senha é apenas para teste escolar/local. Troque-a antes de qualquer uso real.

## Regras importantes

- O estoque inicial é informado no cadastro do produto e gera uma entrada inicial no histórico se a quantidade for maior que zero.
- Depois do cadastro, o saldo é alterado pela tela **Movimentações**. O campo de estoque na tela de edição é somente leitura para que as alterações não deixem de aparecer no histórico.
- O sistema trata a quantidade igual ao estoque mínimo como alerta, além das quantidades inferiores.
- Os registros de movimentação guardam um snapshot do nome do produto, então o histórico continua identificável após a exclusão do produto.

## Script SQL

O arquivo `database/petshop_mysql.sql` contém uma versão do esquema e dados de demonstração para MySQL 8+. Use o script em um banco de testes vazio. Se estiver executando o Laravel, prefira `php artisan migrate --seed` para manter o histórico de migrations do framework sincronizado.
