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
        Schema::table('tbl_item_pedido', function (Blueprint $table) {
            $table->foreign(['id_pedido_fk'], 'fk_item_pedido')->references(['id_pedido'])->on('tbl_pedido')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_produto_fk'], 'fk_item_produto')->references(['id_produto'])->on('tbl_produto')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_item_pedido', function (Blueprint $table) {
            $table->dropForeign('fk_item_pedido');
            $table->dropForeign('fk_item_produto');
        });
    }
};
