<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProdutoModel extends Model
{
    protected  $table = "produtos";
    protected  $fillable =[
         'nome',
         'descricao',
         'imagem',
         'quantidade',
         'preco',
         'id_usuario',
         'estado'
    ];
}
