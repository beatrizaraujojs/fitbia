<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoAdicional extends Model
{
    protected $table = 'tbl_grupo_adicional';
    protected $primaryKey = 'id_grupo_adicional';

    // Um grupo tem muitos adicionais/opções dentro dele (Mantém exatamente igual)
    public function adicionais()
    {
        return $this->hasMany(Adicional::class, 'id_grupo_fk', 'id_grupo_adicional');
    }

    // ADICIONADO: Um grupo agora pode pertencer a vários produtos (Muitos para Muitos)
    public function produtos()
    {
        return $this->belongsToMany(
            Produto::class,
            'tbl_produto_grupo_adicional', // Nome da tabela intermediária que você criou no MySQL
            'id_grupo_adicional_fk',       // Chave estrangeira deste model na pivot
            'id_produto_fk'                // Chave estrangeira do Produto na pivot
        );
    }
}