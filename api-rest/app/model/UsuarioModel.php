<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    protected  $table ="users";
    protected  $fillable=[
        'nome',
        'ultimonome',
        'email',
        'password',
        'foto_url',
        'visibilidade',
        'estado',
        'tipo_cadastro',
        'tipo_online',
        'bi',
        'genero',
        'datanascimento',
        'foto_url'
    ];

    protected $hidden = [
        'remember_token',
        'password'
    ];
}
