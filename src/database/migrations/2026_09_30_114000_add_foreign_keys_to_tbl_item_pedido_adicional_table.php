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
        Schema::table('tbl_item_pedido_adicional', function (Blueprint $table) {
            $table->foreign(['id_adicional_fk'], 'fk_add_item_adicional')->references(['id_adicional'])->on('tbl_adicional')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_item_pedido_fk'], 'fk_add_item_pedido')->references(['id_item_pedido'])->on('tbl_item_pedido')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_item_pedido_adicional', function (Blueprint $table) {
            $table->dropForeign('fk_add_item_adicional');
            $table->dropForeign('fk_add_item_pedido');
        });
    }
};
