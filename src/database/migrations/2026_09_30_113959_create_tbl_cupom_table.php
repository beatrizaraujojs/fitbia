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
        Schema::create('tbl_cupom', function (Blueprint $table) {
            $table->integer('id_cupom', true);
            $table->string('codigo_cupom', 20)->unique('codigo_cupom');
            $table->decimal('porcentagem_desconto', 5);
            $table->enum('status_cupom', ['ATIVO', 'INATIVO'])->nullable()->default('ATIVO');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_cupom');
    }
};
