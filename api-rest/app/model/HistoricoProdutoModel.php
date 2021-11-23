<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class HistoricoProdutoModel extends Model
{
    protected  $table ="historico-produto";
    protected  $fillable = [
        'id_usuario',
        'descricao',
        'imagem',
        'quantidade',
        'preco',
        'nome',
        'historico-estado'
    ];
}
