<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class VendaModel extends Model
{
    protected  $table ="Venda";
    protected  $fillable =[
        'total-venda',
        'quantidade-produtos',
        'id_usuario',
        'estado-venda'
    ];
}
