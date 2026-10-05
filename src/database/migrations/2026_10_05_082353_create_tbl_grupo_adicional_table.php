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
        Schema::create('tbl_grupo_adicional', function (Blueprint $table) {
            $table->integer('id_grupo_adicional', true);
            $table->integer('id_produto_fk')->nullable()->index('fk_grupo_produto');
            $table->string('nome_grupo_adicional', 50);
            $table->integer('qtd_min_grupo')->nullable()->default(0);
            $table->integer('qtd_max_grupo')->nullable()->default(1);
            $table->enum('status_grupo', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_grupo_adicional');
    }
};
