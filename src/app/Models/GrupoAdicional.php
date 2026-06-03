<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoAdicional extends Model
{
    protected $table = 'tbl_grupo_adicional';
    protected $primaryKey = 'id_grupo_adicional';

    // Um grupo tem muitos adicionais/opções dentro dele
    public function adicionais()
    {
        return $this->hasMany(Adicional::class, 'id_grupo_fk', 'id_grupo_adicional');
    }
}