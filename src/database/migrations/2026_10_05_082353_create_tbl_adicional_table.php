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
        Schema::create('tbl_adicional', function (Blueprint $table) {
            $table->integer('id_adicional', true);
            $table->integer('id_grupo_fk')->index('fk_adicional_grupo');
            $table->string('nome_adicional', 50);
            $table->decimal('preco_adicional')->nullable()->default(0);
            $table->enum('status_adicional', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_adicional');
    }
};
