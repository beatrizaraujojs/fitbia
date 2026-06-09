<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
   

    // O Laravel já entende "created_at" e "updated_at" nativamente, 
    // por isso basta deixar as timestamps ativas.
    public $timestamps = true;

    protected $fillable = [
        'nome_categoria',
        'ordem_exibicao_categoria',
        'ativa_categoria',
    ];

    // hasMany: tem muitos
    public function ProdutosCategoria() {
        return $this->hasMany(Produto::class, 'id_categoria', 'id_categoria');
    }
    protected $table = 'tbl_categoria';
    protected $primaryKey = 'id_categoria';

    public function produtos()
    {
        return $this->hasMany(Produto::class, 'id_categoria_fk', 'id_categoria');
    }
}