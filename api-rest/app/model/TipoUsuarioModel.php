<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class TipoUsuarioModel extends Model
{
    protected $table ="tipousuario";
    protected  $fillable =[
        'nome',
        'descricao',
        'id_usuario',
        'id_tipo'
    ];
}
