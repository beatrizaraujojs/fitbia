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
        Schema::create('tbl_produto', function (Blueprint $table) {
            $table->integer('id_produto', true);
            $table->integer('id_categoria_fk')->index('fk_produto_categoria');
            $table->string('nome_produto', 100);
            $table->text('descricao_produto')->nullable();
            $table->string('foto_produto')->nullable();
            $table->decimal('preco_base_produto');
            $table->enum('status_produto', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->enum('destaque_produto', ['SIM', 'NAO'])->nullable()->default('NAO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_produto');
    }
};
