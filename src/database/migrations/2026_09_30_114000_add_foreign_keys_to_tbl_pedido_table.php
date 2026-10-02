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
        Schema::table('tbl_pedido', function (Blueprint $table) {
            $table->foreign(['id_cliente_fk'], 'fk_pedido_cliente')->references(['id_cliente'])->on('tbl_cliente')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_cupom_fk'], 'fk_pedido_cupom')->references(['id_cupom'])->on('tbl_cupom')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_endereco_fk'], 'fk_pedido_endereco')->references(['id_endereco'])->on('tbl_endereco')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_pedido', function (Blueprint $table) {
            $table->dropForeign('fk_pedido_cliente');
            $table->dropForeign('fk_pedido_cupom');
            $table->dropForeign('fk_pedido_endereco');
        });
    }
};
