<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Favorito extends Model
{
    protected $table = 'tbl_favorito';
    protected $primaryKey = 'id_favorito';
    public $timestamps = false; 

    protected $fillable = [
        'id_cliente_fk',
        'id_produto_fk',
    ];

    // Adiciona esta relação para ligar o favorito ao produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto_fk', 'id_produto');
    }
}