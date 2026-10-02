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
        Schema::table('tbl_adicional', function (Blueprint $table) {
            $table->foreign(['id_grupo_fk'], 'fk_adicional_grupo')->references(['id_grupo_adicional'])->on('tbl_grupo_adicional')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_adicional', function (Blueprint $table) {
            $table->dropForeign('fk_adicional_grupo');
        });
    }
};
