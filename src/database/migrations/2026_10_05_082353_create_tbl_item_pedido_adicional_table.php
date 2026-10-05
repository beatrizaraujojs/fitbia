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
        Schema::create('tbl_item_pedido_adicional', function (Blueprint $table) {
            $table->integer('id_item_add', true);
            $table->integer('id_item_pedido_fk')->index('fk_add_item_pedido');
            $table->integer('id_adicional_fk')->index('fk_add_item_adicional');
            $table->decimal('preco_cobrado_add');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_item_pedido_adicional');
    }
};
