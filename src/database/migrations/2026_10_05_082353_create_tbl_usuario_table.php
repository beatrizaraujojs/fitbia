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
        Schema::create('tbl_usuario', function (Blueprint $table) {
            $table->integer('id_usuario', true);
            $table->string('nome_usuario', 100);
            $table->string('email_usuario', 80)->unique('email_usuario');
            $table->string('senha_usuario');
            $table->string('cpf_usuario', 14)->nullable()->unique('cpf_usuario');
            $table->enum('nivel_acesso_usuario', ['ADMIN', 'FUNCIONARIO', 'CLIENTE'])->nullable()->default('CLIENTE');
            $table->enum('status_usuario', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_usuario');
    }
};
