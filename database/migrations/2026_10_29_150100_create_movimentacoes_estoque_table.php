<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->nullable()->constrained('produtos')->nullOnDelete();
            // Snapshot para preservar a identificação do produto se ele for excluído.
            $table->string('produto_nome');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo', 10); // entrada ou saida
            $table->unsignedInteger('quantidade');
            $table->unsignedInteger('estoque_anterior')->default(0);
            $table->unsignedInteger('estoque_posterior')->default(0);
            $table->string('observacao', 500)->nullable();
            $table->timestamps();

            $table->index(['tipo', 'created_at']);
            $table->index(['produto_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
