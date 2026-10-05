<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_pedido', function (Blueprint $table) {
            $table->integer('id_pedido', true);
            $table->integer('id_cliente_fk')->index('fk_pedido_cliente');
            $table->integer('id_endereco_fk')->index('fk_pedido_endereco');
            $table->integer('id_cupom_fk')->nullable()->index('fk_pedido_cupom');
            $table->enum('forma_pagamento_pedido', ['DINHEIRO', 'PIX', 'CARTAO_DEBITO', 'CARTAO_CREDITO', 'VALE_REFEICAO']);
            $table->enum('status_pedido', ['PENDENTE', 'PREPARANDO', 'SAIU PARA ENTREGA', 'ENTREGUE', 'CANCELADO'])->nullable()->default('PENDENTE');
            $table->decimal('valor_total_pedido');
            $table->decimal('troco_para_pedido')->nullable()->default(0);
            $table->text('observacoes_pedido')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pedido');
    }
};
