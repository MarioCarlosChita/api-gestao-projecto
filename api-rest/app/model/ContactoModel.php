<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ContactoModel extends Model{
    protected  $table ="contactos";
    protected  $fillable = ['tipo','descricao' , 'id_usuario'];
}
