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
        Schema::create('tbl_configuracao', function (Blueprint $table) {
            $table->integer('id_configuracao', true);
            $table->time('horario_abertura');
            $table->time('horario_fechamento');
            $table->decimal('valor_minimo_pedido')->nullable()->default(0);
            $table->enum('loja_aberta_status', ['ABERTA', 'FECHADA'])->nullable()->default('ABERTA');
            $table->decimal('taxa_entrega_padrao')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_configuracao');
    }
};
