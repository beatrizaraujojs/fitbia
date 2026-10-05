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
        Schema::create('tbl_endereco', function (Blueprint $table) {
            $table->integer('id_endereco', true);
            $table->integer('id_cliente_fk')->index('fk_endereco_cliente');
            $table->string('cep_endereco', 9)->nullable();
            $table->string('rua_endereco', 100);
            $table->string('numero_endereco', 10)->nullable();
            $table->string('complemento_endereco', 100)->nullable();
            $table->string('bairro_endereco', 50)->nullable();
            $table->string('cidade_endereco', 50)->nullable()->default('São Paulo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_endereco');
    }
};
