<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->date('prazo_validade')->nullable()->change();
        });
    }

    public function down(): void
    {
        // A validade pode ser nula para produtos que não possuem vencimento.
        // Não tornamos a coluna obrigatória novamente para evitar falhas em dados existentes.
    }
};
