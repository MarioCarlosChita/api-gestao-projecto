<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class VendaProdutoModel extends Model
{
    protected  $table ="venda_produtos";
    protected  $fillable =[
        'preco',
        'quantidade-produto',
        'id_usuario',
        'id_venda',
        'total',
        'id_produto',
        'estado-produto'
    ];
}
