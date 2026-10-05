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
        Schema::create('tbl_item_pedido', function (Blueprint $table) {
            $table->integer('id_item_pedido', true);
            $table->integer('id_pedido_fk')->index('fk_item_pedido');
            $table->integer('id_produto_fk')->index('fk_item_produto');
            $table->integer('quantidade_item');
            $table->decimal('preco_unitario_item');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_item_pedido');
    }
};
