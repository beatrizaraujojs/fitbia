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
        Schema::create('tbl_cliente', function (Blueprint $table) {
            $table->integer('id_cliente', true);
            $table->string('nome_cliente', 100);
            $table->string('email_cliente', 80)->nullable()->unique('email_cliente');
            $table->string('senha_cliente')->nullable();
            $table->string('whatsapp_cliente', 20)->unique('whatsapp_cliente');
            $table->string('cpf_cliente', 14)->nullable()->unique('cpf_cliente');
            $table->date('data_nascimento')->nullable();
            $table->enum('status_cliente', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cliente');
    }
};
