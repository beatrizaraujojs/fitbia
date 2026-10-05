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
        Schema::create('tbl_produto_grupo_adicional', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_produto_fk')->index('fk_pivot_produto');
            $table->integer('id_grupo_adicional_fk')->index('fk_pivot_grupo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_produto_grupo_adicional');
    }
};
